<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use App\Models\Armada;
use App\Models\Customer;
use App\Models\Order;
use App\Models\TripayChannel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ArmadaController extends Controller
{

    private $maxSize = 1048576;
    protected $apiController;

    public function __construct(ApiController $apiController)
    {
        $this->apiController = $apiController;
        $this->middleware(function ($request, $next) {
            if (Auth::guest()) {
                Redirect::to("/")->send();
            }

            if (Auth::user()->level != 'armada') {
                Redirect::to("/keluar")->send();
            }

            return $next($request);
        });
    }

    public function home()
    {
        $armada = Armada::where('user_id', Auth::id())->first();
        $orders = Order::with(['tripay_channel', 'detailOrderSepithank.sepithank', 'customer', 'armada.kecamatan'])->where('armada_id', $armada->armada_id)->whereIn('order_status_job', ['on_queue', 'on_the_way', 'on_process', 'rejected'])->orderBy('order_id', 'desc')->get();
        $paymentGroups = TripayChannel::distinct()->get(['channel_group']);
        $paymentChannels = TripayChannel::all();
        return view('armada.home', ['orders' => $orders, 'paymentGroups' => $paymentGroups, 'paymentChannels' => $paymentChannels,]);
    }

    public function history()
    {
        $armada = Armada::where('user_id', Auth::id())->first();
        $orders = Order::with(['tripay_channel', 'detailOrderSepithank.sepithank', 'customer', 'armada.kecamatan'])->where('armada_id', $armada->armada_id)->whereIn('order_status_job', ['done'])->orderBy('order_id', 'desc')->get();
        return view('armada.history', ['orders' => $orders]);
    }

    public function onTheWay($id)
    {
        $order = Order::with('armada')->where('order_id', $id)->first();
        $order->order_status_job = 'on_the_way';
        $order->date_on_the_way = Carbon::now();
        $order->save();
        $customer = Customer::find($order->customer_id);
        $this->apiController->sendMessageWhatsapp(
            $customer->customer_phone,
            "Halo " . $customer->customer_name . "!
        
Petugas " . $order->armada->armada_driver . " kami sedang dalam perjalanan, mohon menunggu di lokasi anda. Terimakasih!"
        );
        $this->apiController->sendMessageWhatsapp(
            AppSetting::find(1)->admin_wa,
            "Halo Admin Siyati!

Petugas " . $order->armada->armada_driver . " sedang dalam perjalanan untuk mengerjakan pesanan dengan invoice " . $order->order_invoice . "."
        );
        return redirect()->back()->with('success', 'Status telah berubah. Hati - hati dijalan!');
    }

    public function doTheWork($id)
    {
        $order = Order::with('armada')->where('order_id', $id)->first();
        $customer = Customer::find($order->customer_id);
        $order->order_status_job = 'on_process';
        $order->date_process = Carbon::now();
        if ($order->order_payment_method == 'tunai') {
            $order->order_status_payment = 'payed';
            $order->date_payed = Carbon::now();
            $this->apiController->sendMessageWhatsapp(
                $customer->customer_phone,
                "Halo " . $customer->customer_name . "!
            
Kami berhasil menerima dana anda! Silakan menunggu petugas kami dalam memproses Septic Tank anda. Terimakasih!"
            );
        } else {
            $this->apiController->sendMessageWhatsapp(
                $customer->customer_phone,
                "Halo " . $customer->customer_name . "!
        
Petugas " . $order->armada->armada_driver . " kami sedang menyedot septic tank anda, mohon menunggu. Terimakasih!"
            );
        }
        $this->apiController->sendMessageWhatsapp(
            AppSetting::find(1)->admin_wa,
            "Halo Admin Siyati!

Petugas " . $order->armada->armada_driver . " sedang menyedot septic tank pesanan dengan invoice " . $order->order_invoice . "."
        );
        $order->save();
        return redirect()->back()->with('success', 'Status telah berubah. Semangat bekerja!');
    }

    public function proofOfWork(Request $request)
    {
        $order = Order::with('armada')->where('order_id', $request->order)->first();
        $customer = Customer::find($order->customer_id);

        $toPhoto = '/image';
        if ($request->has('order_proof_photo')) {
            $image1 = $request->file('order_proof_photo');
            $namePhoto1 = time() . "_" . strtolower(str_replace(" ", "_", $request->nik)) . ".jpg";

            if ($image1->getSize() > $this->maxSize) {
                return redirect()->back()->with('failed', 'Ukuran foto terlalu besar!');
            }

            $image1->move(public_path($toPhoto), $namePhoto1);

            $order->order_proof_photo = $toPhoto . '/' . $namePhoto1;
        }

        $order->save();
        $this->apiController->sendMessageWhatsapp(
            $customer->customer_phone,
            "Halo " . $customer->customer_name . "!
        
Petugas " . $order->armada->armada_driver . " kami telah selesai menyedot septic tank anda. Terimakasih!"
        );
        $this->apiController->sendMessageWhatsapp(
            AppSetting::find(1)->admin_wa,
            "Halo Admin Siyati!

Petugas " . $order->armada->armada_driver . " telah selesai menyedot septic tank pesanan dengan invoice " . $order->order_invoice . "."
        );
        return redirect()->back()->with('success', 'Bukti anda telah di upload. Selamat beristirahat!');
    }

    public function selectPayment(Request $request)
    {
        $order = Order::find($request->order);
        $customer = Customer::find($order->customer_id);

        $toPhoto = '/image';
        if ($request->has('order_septictank_photo')) {
            $image1 = $request->file('order_septictank_photo');
            $namePhoto1 = time() . "_" . strtolower(str_replace(" ", "_", $request->nik)) . ".jpg";

            if ($image1->getSize() > $this->maxSize) {
                return redirect()->back()->with('failed', 'Ukuran foto terlalu besar!');
            }

            $image1->move(public_path($toPhoto), $namePhoto1);

            $order->order_septictank_photo = $toPhoto . '/' . $namePhoto1;
        }

        $order->order_cubic = $request->order_cubic;
        // LOGIKA KUBIK
        $price = AppSetting::find(1)->price_per_cubic * round($request->order_cubic);
        $order->order_payment_method = $request->order_payment_method;
        $order->order_price = $price;

        if ($request->order_payment_method == 'tunai') {
            $order->order_status_job = 'on_process';
            $order->date_process = Carbon::now();
            $order->order_status_payment = 'payed';
            $order->date_payed = Carbon::now();
            $this->apiController->sendMessageWhatsapp(
                $customer->customer_phone,
                "Halo " . $customer->customer_name . "!
            
Kami berhasil menerima dana anda! Silakan menunggu petugas kami dalam memproses Septic Tank anda. Terimakasih!"
            );

            $this->apiController->sendMessageWhatsapp(
                AppSetting::find(1)->admin_wa,
                "Halo Admin Siyati!
    
Petugas " . $order->armada->armada_driver . " sedang menyedot septic tank pesanan dengan invoice " . $order->order_invoice . "."
            );

            $order->save();
            
            return redirect()->back()->with('success', 'Status telah berubah. Semangat bekerja!');
        } else {

            $order->save();
            
            return redirect()->back()->with('success', 'Status telah berubah. Silakan arahkan customer melakukan pembayaran!');

        }
        
    }
    public function paymentVirtual(Request $request)
    {
        $order = Order::find($request->order);
        $customer = Customer::find($order->customer_id);
        $armada = Armada::find($order->armada_id);
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
            $this->apiController->sendMessageWhatsapp(
                $customer->customer_phone,
                "Halo " . $customer->customer_name . "!
            
Pesanan anda dengan invoice ".$order->order_invoice." telah berhasil dibuat, silakan lakukan pembayaran pada link berikut 
".$order->payment_url."

Terimakasih!"
            );
            $this->apiController->sendMessageWhatsapp(
                $armada->armada_phone,
                "Halo " . $armada->armada_driver . "!
            
Pesanan atas nama " .$customer->customer_name. " dengan invoice ".$order->order_invoice." telah berhasil dibuat, silakan lakukan pembayaran pada link berikut 
".$order->payment_url."

Terimakasih!"
            );
            return redirect()->back()->with('success', 'Silakan arahkan customer melakukan pembayaran!');
        } else {
            $order->channel_id = null;
            $order->save();
            dd($makePayment);
            return redirect()->back()->with('error', 'Gagal Melakukan pembayaran, silahkan ulangi beberapa saat lagi.');
        }
    }
}
