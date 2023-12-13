<?php

namespace App\Http\Controllers;

use App\Models\Armada;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ArmadaController extends Controller
{
    
    private $maxSize = 1048576;
    public function __construct()
    {
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

    public function home() {
        $armada = Armada::where('user_id', Auth::id())->first();
        $orders = Order::with(['tripay_channel', 'detailOrderSepithank.sepithank', 'customer'])->where('armada_id', $armada->armada_id)->whereIn('order_status_job', ['on_queue', 'on_the_way', 'on_process', 'done', 'rejected'])->orderBy('order_id', 'desc')->get();
        return view('armada.home', ['orders' => $orders]);
    }

    public function onTheWay($id) {
        $order = Order::find($id);
        $order->order_status_job = 'on_the_way';
        $order->save();
        return redirect()->back()->with('success', 'Status telah berubah. Hati - hati dijalan!');
    }

    public function doTheWork($id) {
        $order = Order::find($id);
        $order->order_status_job = 'on_process';
        if($order->order_payment_method == 'tunai') {
            $order->order_status_payment = 'payed';
        }
        $order->save();
        return redirect()->back()->with('success', 'Status telah berubah. Semangat bekerja!');
    }

    public function proofOfWork(Request $request) {
        $order = Order::find($request->order);


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
        return redirect()->back()->with('success', 'Bukti anda telah di upload. Selamat beristirahat!');
    }
}
