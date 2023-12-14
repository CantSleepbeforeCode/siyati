<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\TripayChannel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class ApiController extends Controller
{
    public function sendLocation(Request $request) {
        $customer = Customer::where('user_id', Auth::id())->first();
        $customer->customer_lat = $request->latitude;
        $customer->customer_long = $request->longitude;
        $customer->save();
        
        return true;
    }

    public function connectToTripay($url, $method, $payload = null)
    {
        $curl = curl_init();

        switch ($method) {
            case 'GET':
                curl_setopt_array($curl, array(
                    CURLOPT_FRESH_CONNECT  => true,
                    CURLOPT_URL            => 'https://tripay.co.id/api/' . $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HEADER         => false,
                    CURLOPT_HTTPHEADER     => ['Authorization: Bearer ' . '2sipPZVwgnStvLBdU8foUvROOvtF4jbXdG649xtd'],
                    CURLOPT_FAILONERROR    => false,
                    CURLOPT_IPRESOLVE      => CURL_IPRESOLVE_V4
                ));
                break;

            case 'POST':
                curl_setopt_array($curl, [
                    CURLOPT_FRESH_CONNECT  => true,
                    CURLOPT_URL            => 'https://tripay.co.id/api/' . $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HEADER         => false,
                    CURLOPT_HTTPHEADER     => ['Authorization: Bearer ' . '2sipPZVwgnStvLBdU8foUvROOvtF4jbXdG649xtd'],
                    CURLOPT_FAILONERROR    => false,
                    CURLOPT_POST           => true,
                    CURLOPT_POSTFIELDS     => http_build_query($payload),
                    CURLOPT_IPRESOLVE      => CURL_IPRESOLVE_V4
                ]);
                break;

            default:
                break;
        }

        $response = curl_exec($curl);
        $json = json_decode($response);
        $error = curl_error($curl);

        curl_close($curl);

        // if (empty($error)) {
        //     $this->logApi($response);
        // } else {
        //     $this->logApi($error);
        // }

        return empty($error) ? $json : $error;
    }

    public function getChannelPayment()
    {
        $result = $this->connectToTripay('merchant/payment-channel', 'GET');

        if ($result->success) {
            TripayChannel::truncate();
            foreach ($result->data as $data) {
                $channel = new TripayChannel();
                $channel->channel_code = $data->code;
                $channel->channel_name = $data->name;
                $channel->channel_group = $data->group;
                $channel->channel_type = $data->type;
                $channel->fee_merchant_flat = $data->fee_merchant->flat;
                $channel->fee_merchant_percent = $data->fee_merchant->percent;
                $channel->fee_customer_flat = $data->fee_customer->flat;
                $channel->fee_customer_percent = $data->fee_customer->percent;
                $channel->total_fee_flat = $data->total_fee->flat;
                $channel->total_fee_percent = $data->total_fee->percent;
                $channel->minimum_fee = $data->minimum_fee;
                $channel->maximum_fee = $data->maximum_fee;
                $channel->channel_icon_url = $data->icon_url;
                $channel->channel_active = $data->active;
                $channel->save();
            }

            return "success";
        } else {
            return 'error';
        }
    }

    public function createTransactionTripay(Order $order)
    {
        $orderWithDetail = Order::with(['tripay_channel', 'customer'])->where('order_invoice', $order->order_invoice)->first();

        $data = [
            'method'         => $orderWithDetail->tripay_channel->channel_code,
            'merchant_ref'   => $orderWithDetail->order_invoice,
            'amount'         => $orderWithDetail->order_price,
            'customer_name'  => $orderWithDetail->customer->customer_name, // Wajib
            'customer_email' => 'guest@gmail.com', // Wajib
            'customer_phone' => $orderWithDetail->customer->customer_phone,
            'order_items'    => [
                [
                    'sku'         => 'SIYATI',
                    'name'        => 'Permintaan Penyedotan Septic Tank',
                    'price'       => $orderWithDetail->order_price,
                    'quantity'    => 1,
                    'product_url' => null,
                    'image_url'   => null,
                ],
            ],
            'return_url'   => 'http://' . $_SERVER['SERVER_NAME'] . '/permintaan',
            'expired_time' => (time() + (24 * 60 * 60)), // 24 jam
            'signature'    => hash_hmac('sha256', 'T23949' . $orderWithDetail->order_invoice . $orderWithDetail->order_price, 'mV5fq-yidrd-z1fAS-9dKsJ-ycW27')
        ];


        $execute = $this->connectToTripay('transaction/create', 'POST', $data);

        return $execute;
    }

    public function getTransactionTripay(Order $order)
    {
        $payload = [
            'reference' => $order->payment_invoice
        ];

        return $this->connectToTripay('transaction/detail?' . http_build_query($payload), 'GET');
    }

    public function handleTripay(Request $request)
    {
        $callbackSignature = $request->server('HTTP_X_CALLBACK_SIGNATURE');
        $json = $request->getContent();
        $signature = hash_hmac('sha256', $json, 'mV5fq-yidrd-z1fAS-9dKsJ-ycW27');

        if ($signature !== (string) $callbackSignature) {
            return Response::json([
                'success' => false,
                'message' => 'invalid signature'
            ]);
        }

        if ('payment_status' !== (string) $request->server('HTTP_X_CALLBACK_EVENT')) {
            return Response::json([
                'success' => false,
                'message' => 'Unrecognized callback event, no action was taken',
            ]);
        }

        $data = json_decode($json);

        if (JSON_ERROR_NONE !== json_last_error()) {
            return Response::json([
                'success' => false,
                'message' => 'Invalid data sent by tripay',
            ]);
        }

        $invoiceId = $data->merchant_ref;
        $tripayReference = $data->reference;
        $status = strtoupper((string) $data->status);

        if ($data->is_closed_payment === 1) {
            $invoice = Order::where('invoice', $invoiceId)
                ->where('payment_invoice', $tripayReference)
                ->where('status', 'ordered')
                ->first();

            if (!$invoice) {
                return Response::json([
                    'success' => false,
                    'message' => 'no invoice found or already paid: ' . $invoiceId,
                ]);
            }

            switch ($status) {
                case 'PAID':
                    $invoice->update(['status' => 'payed']);
                    // $this->addSalary($invoice);
                    break;
                case 'EXPIRED':
                    $invoice->update(['status' => 'fail_pay']);
                    break;
                case 'FAILED':
                    $invoice->update(['status' => 'fail_pay']);
                    break;
                default:
                    return Response::json([
                        'success' => false,
                        'message' => 'Unrecognized payment status'
                    ]);
            }

            return Response::json(['success' => true]);
        }
    }
}
