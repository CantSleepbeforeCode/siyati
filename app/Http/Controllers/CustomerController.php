<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\DetailOrderSepithank;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Order;
use App\Models\Sepithank;
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
                Redirect::to("/keluar")->send();
            }

            return $next($request);
        });
    }

    public function home()
    {
        $kecamatans = Kecamatan::all();
        $kelurahans = Kelurahan::all();
        $customer = Customer::where('user_id', Auth::id())->first();
        return view('customer.home', ['customer' => $customer, 'kecamatans' => $kecamatans, 'kelurahans' => $kelurahans]);
    }

    public function request(Request $request)
    {
        $customer = Customer::where('user_id', Auth::id())->first();
        if ($request->method() == 'GET') {
            $sepithanks = Sepithank::where('customer_id', $customer->customer_id)->get();
            $orders = Order::with(['tripay_channel', 'detailOrderSepithank.sepithank', 'customer', 'armada.kecamatan'])->where('customer_id', $customer->customer_id)->orderBy('order_id', 'desc')->get();
            $paymentGroups = TripayChannel::distinct()->get(['channel_group']);
            $paymentChannels = TripayChannel::all();
            return view('customer.request', ['customer' => $customer, 'orders' => $orders, 'paymentGroups' => $paymentGroups, 'paymentChannels' => $paymentChannels, 'sepithanks' => $sepithanks,]);
        } else if ($request->method() == 'POST') {
            // $orderCek = DB::select("SELECT * FROM orders WHERE customer_id = '$customer->customer_id' AND order_status in ('ordered', 'payed')");
            // if($orderCek == null) {
            $lastTransaction = Order::orderBy('order_id', 'desc')->first();
            $index = 0;
            if ($lastTransaction != null) {
                $index = (int)substr($lastTransaction->order_invoice, 5);
            }
            // $price = DB::select("SELECT * FROM price_references WHERE $customer->customer_vol BETWEEN minimum_size and maximum_size AND type = '$customer->customer_unit';");

            $order = new Order();
            $order->customer_id = $customer->customer_id;
            $order->order_invoice = $this->getUniqueCode() . sprintf('%0' . 10 . 's', $index + 1);
            $order->order_lat = $customer->customer_lat;
            $order->order_long = $customer->customer_long;
            $order->order_price = 5000 * count($request->sepithank);
            // if($price == null) {
            //     $order->order_price = 0;
            // } else {
            //     $order->order_price = $price[0]->price;
            // }
            $order->order_status_payment = 'ordered';
            $order->order_status_job = 'not_start';
            $order->order_date = Carbon::now();
            $order->order_payment_method = $request->order_payment_method;
            $order->save();


            foreach ($request->sepithank as $sepithank) {
                $detailOrder = new DetailOrderSepithank();
                $detailOrder->order_id = $order->order_id;
                $detailOrder->sepithank_id = $sepithank;
                $detailOrder->price = 5000;
                $detailOrder->save();
            }

            $this->apiController->sendMessageWhatsapp(
                '682290349259', 
                "Halo Admin Siyati!
            
Terdapat permintaan sedot tinja baru dari " . $customer->customer_name . " dengan tipe bangunan " . $customer->customer_nomenklatur . "!

Silakan buka website Siyati untuk memproses!");
            return redirect()->back()->with('success', 'Berhasil membuat tiket!');
            // } else {
            //     return redirect()->back()->with('error', 'Anda memiliki tiket aktif! Silakan selesaikan tiket aktif terlebih dahulu.');
            // }
        }
    }

    public function doneOrder($id) {
        $order = Order::find($id);
        $order->order_status_job = 'done';
        $order->date_done = Carbon::now();
        $order->save();
        return redirect()->back()->with('success', 'Berhasil menyelesaikan permintaan!');
    }

    public function paymentVirtual(Request $request)
    {
        $order = Order::find($request->order);
        if ($order == null || $order->channel_id != null) {
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

    public function payment()
    {
        $customer = Customer::where('user_id', Auth::id())->first();
        return view('customer.payment', ['customer' => $customer]);
    }

    public function report()
    {
        $customer = Customer::where('user_id', Auth::id())->first();
        $orders = Order::with(['tripay_channel'])->where(['customer_id' => $customer->customer_id, 'order_status_job' => 'done'])->get();
        $arrMonth = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        $query = '';
        for ($date = 1; $date <= 12; $date++) {
            if ($date == 12) {
                $query .= "SELECT '" . $arrMonth[$date] . ' - ' . date('Y') . "' as day, case when sum(order_price) is null then 0 else sum(order_price) end as sum_price FROM orders WHERE customer_id = $customer->customer_id and month(order_date) = $date and year(order_date) = " . date('Y') . " and order_status_job = 'done'";
            } else {
                $query .= "SELECT '" . $arrMonth[$date] . ' - ' . date('Y') . "' as day, case when sum(order_price) is null then 0 else sum(order_price) end as sum_price FROM orders WHERE customer_id = $customer->customer_id and month(order_date) = $date and year(order_date) = " . date('Y') . " and order_status_job = 'done'
            
                UNION ALL
                
                ";
            }
        }


        $orders = DB::select($query);
        return view('customer.report', ['customer' => $customer, 'orders' => $orders]);
    }

    public function ecard()
    {
        $customer = Customer::where('user_id', Auth::id())->first();
        return view('customer.ecard', ['customer' => $customer]);
    }

    public function sepithank()
    {
        $customer = Customer::where('user_id', Auth::id())->first();
        $sepithanks = Sepithank::where('customer_id', $customer->customer_id)->get();
        return view('customer.sepithank', ['customer' => $customer, 'sepithanks' => $sepithanks]);
    }

    public function addSepithank(Request $request)
    {
        $customer = Customer::where('user_id', Auth::id())->first();
        $sepithank = new Sepithank();
        $sepithank->customer_id = $customer->customer_id;
        $sepithank->sepithank_vol = $request->sepithank_vol;
        $sepithank->sepithank_unit = $request->sepithank_unit;
        $sepithank->save();

        return redirect()->back()->with('success', 'Berhasil menambah sepithank!');
    }

    public function editSepithank(Request $request)
    {
        $sepithank = Sepithank::find($request->sepithank);
        $sepithank->sepithank_vol = $request->sepithank_vol;
        $sepithank->sepithank_unit = $request->sepithank_unit;
        $sepithank->save();

        return redirect()->back()->with('success', 'Berhasil mengubah sepithank!');
    }

    public function deleteSepithank($id)
    {
        $sepithank = Sepithank::find($id);
        $sepithank->delete();

        return redirect()->back()->with('error', 'Berhasil mengubah sepithank!');
    }

    function getUniqueCode()
    {
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
