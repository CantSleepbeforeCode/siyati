<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\TripayChannel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CustomerController extends Controller
{
    protected $apiController;
    public function __construct(ApiController $apiController)
    {
        $this->apiController = $apiController;
        $this->middleware(function ($request, $next) {
            if (Auth::guest()) {
                Redirect::to("/")->send();
            }

            if (Auth::user()->level != 'customer') {
                Redirect::to("/logout")->send();
            }

            return $next($request);
        });
    }

    public function home() {
        $customer = Customer::where('user_id', Auth::id())->first();
        return view('customer.home', ['customer' => $customer]);
    }
    
    public function request(Request $request) {
        $customer = Customer::where('user_id', Auth::id())->first();
        if($request->method() == 'GET') {
            $orders = Order::with(['tripay_channel'])->where('customer_id', $customer->customer_id)->orderBy('order_id', 'desc')->get();
            $paymentGroups = TripayChannel::distinct()->get(['channel_group']);
            $paymentChannels = TripayChannel::all();
            return view('customer.request', ['customer' => $customer, 'orders' => $orders, 'paymentGroups' => $paymentGroups, 'paymentChannels' => $paymentChannels]);
        } else if($request->method() == 'POST') {
            $orderCek = DB::select("SELECT * FROM orders WHERE customer_id = '$customer->customer_id' AND order_status in ('ordered', 'payed')");
            if($orderCek == null) {
                $lastTransaction = Order::orderBy('order_id', 'desc')->first();
                $index = 0;
                if ($lastTransaction != null) {
                    $index = (int)substr($lastTransaction->invoice, 5);
                }
                $price = DB::select("SELECT * FROM price_references WHERE $customer->customer_vol BETWEEN minimum_size and maximum_size AND type = '$customer->customer_unit';");
    
                $order = new Order();
                $order->customer_id = $customer->customer_id;
                $order->order_invoice = $this->getUniqueCode() . sprintf('%0' . 10 . 's', $index + 1);
                $order->order_lat = $customer->customer_lat;
                $order->order_long = $customer->customer_long;
                if($price == null) {
                    $order->order_price = 0;
                } else {
                    $order->order_price = $price[0]->price;
                }
                $order->order_status = 'ordered';
                $order->order_date = Carbon::now();
                $order->order_payment_method = $request->order_payment_method;
                $order->save();
                return redirect()->back()->with('success', 'Berhasil membuat tiket!');
            } else {
                return redirect()->back()->with('error', 'Anda memiliki tiket aktif! Silakan selesaikan tiket aktif terlebih dahulu.');
            }
        }
    }

    public function paymentVirtual(Request $request) {
        $order = Order::find($request->order);
        if($order == null || $order->channel_id != null) {
            return redirect()->back()->with('error', 'Terjadi kesalahan, Silakan hubungi petugas.');
        }

        $order->channel_id = $request->channel;
        $order->save();
        $makePayment = $this->apiController->createTransactionTripay($order);

        if ($makePayment->success) {
            $data = $makePayment->data;
            $order->payment_invoice = $data->reference;
            $order->payment_expired = $data->expired_time;
            $order->payment_url = $data->checkout_url;
            $order->save();

            return Redirect($data->checkout_url);
        } else {
            $order->channel_id = null;
            return redirect()->back()->with('error', 'Gagal Melakukan pembayaran, silahkan ulangi beberapa saat lagi.');
        }
    }

    public function payment() {
        $customer = Customer::where('user_id', Auth::id())->first();
        return view('customer.payment', ['customer' => $customer]);
    }

    public function report() {
        $customer = Customer::where('user_id', Auth::id())->first();
        $orders = Order::with(['tripay_channel'])->where(['customer_id' => $customer->customer_id, 'order_status' => 'done'])->get();
        return view('customer.report', ['customer' => $customer, 'orders' => $orders]);
    }

    public function ecard() {
        $customer = Customer::where('user_id', Auth::id())->first();
        return view('customer.ecard', ['customer' => $customer]);
    }

    function getUniqueCode() {
        $n = 3;
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
     
        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
     
        return $randomString;
    }
     
}
