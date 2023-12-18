<?php

namespace App\Http\Controllers;

use App\Models\Armada;
use App\Models\Customer;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Nomenclature;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class AdministratorController extends Controller
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

            if (Auth::user()->level != 'administrator') {
                Redirect::to("/keluar")->send();
            }

            return $next($request);
        });
    }

    public function home() {
        $orderOrdered = Order::whereIn('order_status_job', ['not_start', 'on_queue'])->count();
        $orderProcess = Order::whereIn('order_status_job', ['on_the_way', 'on_process'])->count();
        $orderFailed = Order::where('order_status_job', 'rejected')->count();
        $orderDone = Order::where('order_status_job', 'done')->count();
        $orders = Order::with(['tripay_channel', 'customer'])->get();

        $query = '';
        for ($date = 1; $date <= date('t'); $date++) {
            if ($date == date('t')) {
                $query .= "SELECT " . $date . " as day, count(order_id) as count FROM orders WHERE month(order_date) = " . date('m') . " and year(order_date) = " . date('Y') . " and day(order_date) = " . $date . ";";
            } else {
                $query .= "SELECT " . $date . " as day, count(order_id) as count FROM orders WHERE month(order_date) = " . date('m') . " and year(order_date) = " . date('Y') . " and day(order_date) = " . $date . "
            
                UNION ALL
                
                ";
            }
        }

        $dailyOrders = DB::select($query);

        $buildings = DB::select("SELECT sum(customer_id) as total, customer_nomenklatur from customers group by 2");

        return view('administrator.home', ['orderOrdered' => $orderOrdered, 'orderProcess' => $orderProcess, 'orderFailed' => $orderFailed, 'orderDone' => $orderDone, 'dailyOrders' => $dailyOrders, 'orders' => $orders, 'buildings' => $buildings]);
    }

    public function masterData() {
        $kecamatans = Kecamatan::all();
        $kelurahans = Kelurahan::with('kecamatan')->get();
        $nomenclatures = Nomenclature::all();
        return view('administrator.master-data', ['kecamatans' => $kecamatans, 'kelurahans' => $kelurahans, 'nomenclatures' => $nomenclatures]);
    }

    public function member() {
        $kecamatans = Kecamatan::all();
        $kelurahans = Kelurahan::all();
        $customers = Customer::with(['user', 'sepithank'])->get();
        return view('administrator.my-member', ['customers' => $customers, 'kecamatans' => $kecamatans, 'kelurahans' => $kelurahans]);
    }

    public function armada() {
        $lastArmada = Armada::orderBy('armada_id', 'desc')->first();
        $index = 0;
        if ($lastArmada != null) {
            $index = (int)substr($lastArmada->armada_id, 5);
        }
        $newIdArmada = 'AMD' . sprintf('%0' . 10 . 's', $index + 1);
        
        $armadas = Armada::with('kecamatan', 'user')->get();
        $kecamatans = Kecamatan::all();
        return view('administrator.my-armada', ['armadas' => $armadas, 'kecamatans' => $kecamatans, 'newIdArmada' => $newIdArmada]);
    }

    public function addArmada(Request $request) {
        $user = new User();
        $user->nik = $request->username;
        $user->password = Hash::make($request->password);
        $user->level = 'armada';
        $user->save();

        $armada = new Armada();
        $armada->armada_id = $request->armada_id;
        $armada->user_id = $user->user_id;
        $armada->armada_driver = $request->armada_driver;
        $armada->armada_plat = $request->armada_plat;
        $armada->armada_id_gps = $request->armada_id_gps;
        $armada->armada_subdistinct = $request->armada_subdistinct;

        $toPhoto = '/image';
        if ($request->has('armada_driver_photo')) {
            $image1 = $request->file('armada_driver_photo');
            $namePhoto1 = time() . "_" . strtolower(str_replace(" ", "_", $request->nik)) . ".jpg";

            if ($image1->getSize() > $this->maxSize) {
                $user->delete();
                return redirect()->back()->with('failed', 'Ukuran foto terlalu besar!');
            }

            $image1->move(public_path($toPhoto), $namePhoto1);

            $armada->armada_driver_photo = $toPhoto . '/' . $namePhoto1;
        }

        $armada->save();
        return redirect()->back()->with('success', 'Berhasil menambah data armada!');
    }

    public function editArmada(Request $request) {
        $armada = Armada::find($request->armada_id);
        $armada->armada_driver = $request->armada_driver;
        $armada->armada_plat = $request->armada_plat;
        $armada->armada_id_gps = $request->armada_id_gps;
        $armada->armada_subdistinct = $request->armada_subdistinct;

        $toPhoto = '/image';
        if ($request->has('armada_driver_photo')) {
            $image1 = $request->file('armada_driver_photo');
            $namePhoto1 = time() . "_" . strtolower(str_replace(" ", "_", $request->nik)) . ".jpg";

            if ($image1->getSize() > $this->maxSize) {
                return redirect()->back()->with('failed', 'Ukuran foto terlalu besar!');
            }

            File::delete(public_path($armada->armada_driver_photo));

            $image1->move(public_path($toPhoto), $namePhoto1);

            $armada->armada_driver_photo = $toPhoto . '/' . $namePhoto1;
        }

        $armada->save();

        $user = User::find($armada->user_id);
        $user->nik = $request->username;
        if($request->password != null) {
            $user->password = Hash::make($request->password);
            $user->save();
        }
        return redirect()->back()->with('success', 'Berhasil mengubah data armada!');
    }

    public function deleteArmada($id) {
        $armada = Armada::find($id);
        $user = User::find($armada->user_id);
        $armada = Armada::find($id);
        
        File::delete(public_path($armada->armada_driver_photo));
        $armada->delete();
        $user->delete();
        return redirect()->back()->with('error', 'Berhasil menghapus data armada!');
    }

    public function transaction() {
        $armadas = Armada::all();
        $orders = Order::with(['tripay_channel', 'detailOrderSepithank.sepithank', 'customer', 'armada.kecamatan'])->orderBy('order_date', 'desc')->get();

        return view('administrator.my-transaksi', ['orders' => $orders, 'armadas' => $armadas]);
    }

    public function pickArmada(Request $request) {
        $order = Order::find($request->order);
        $order->armada_id = $request->armada_id;
        $order->order_status_job = 'on_queue';
        $order->save();
        return redirect()->back()->with('success', 'Berhasil memilih armada!');
    }

    public function rejectOrder($id) {
        $order = Order::find($id);
        $order->order_status_job = 'rejected';
        $order->save();
        return redirect()->back()->with('error', 'Berhasil menolak permintaan!');
    }

    public function doneOrder($id) {
        $order = Order::find($id);
        $order->order_status_job = 'done';
        $order->save();
        return redirect()->back()->with('success', 'Berhasil menyelesaikan permintaan!');
    }

    public function gps() {
        return view('administrator.my-gps');
    }

    public function ecosystem() {
        $customers = Customer::with(['user', 'sepithank'])->get();
        $nomenclatures = Nomenclature::all();
        return view('administrator.ecosystem-siyati', ['customers' => $customers, 'nomenclatures' => $nomenclatures]);
    }

    public function updateMember(Request $request) {
        $customer = Customer::find($request->customer);
        $customer->customer_name = $request->customer_name;
        $customer->customer_phone = $request->customer_phone;
        $customer->customer_address = $request->customer_address;
        $customer->customer_nomenklatur = $request->customer_nomenklatur;
        $customer->customer_subdistrict = $request->customer_subdistrict;
        $customer->customer_urban_village = $request->customer_urban_village;
        $customer->save();

        $user = User::find($customer->user_id);
        if($request->password != null) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        return redirect()->back()->with('success', 'Berhasil mengubah data member!');

    }

    public function deleteMember($id) {
        $customer = Customer::find($id);
        $user = User::find($customer->user_id);
        File::delete(public_path($customer->customer_photo));

        $orders = Order::where('customer_id', $id)->get();
        
        foreach($orders as $order) {
            $order->delete();
        }

        $customer->delete();
        $user->delete();
        return redirect()->back()->with('failed', 'Berhasil menghapus data member!');
    }

    public function exportMember() {
        
        $query = "SELECT b.nik, a.*, c.* FROM customers a inner join users b on a.user_id = b.user_id inner join sepithanks c on a.customer_id = c.customer_id";

        $datas = DB::select($query);
        $nameCsv = "data_customer_" . uniqid() . ".csv";

        $csvHeader = [
            'nik',
            'customer_name',
            'customer_phone',
            'customer_address',
            'customer_subdistrict',
            'customer_urban_village',
            'customer_vol',
            'customer_unit',
            'customer_nomenklatur',
            'customer_lat',
            'customer_long',
        ];

        $callback = function () use ($datas, $csvHeader) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $csvHeader);


            foreach ($datas as $data) {
                fputcsv($file, array($data->nik, $data->customer_name, $data->customer_phone, $data->customer_address, $data->customer_subdistrict, $data->customer_urban_village, $data->sepithank_vol, $data->sepithank_unit, $data->customer_nomenklatur, $data->customer_lat, $data->customer_long));
            }

            fclose($file);
        };

        $headersPHP = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=" . $nameCsv,
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        );

        return response()->stream($callback, 200, $headersPHP);

    }

    public function addKecamatan(Request $request) {
        $kecamatan = new Kecamatan();
        $kecamatan->kecamatan_id = $request->kecamatan_id;
        $kecamatan->nama = $request->nama;
        $kecamatan->save();
        return redirect()->back()->with('success', 'Berhasil menambah data kecamatan!');
    }

    public function addKelurahan(Request $request) {
        $kelurahan = new Kelurahan();
        $kelurahan->kelurahan_id = $request->kelurahan_id;
        $kelurahan->kecamatan_id = $request->kecamatan_id;
        $kelurahan->nama = $request->nama;
        $kelurahan->save();
        return redirect()->back()->with('success', 'Berhasil menambah data kelurahan!');
    }

    public function addNomenklatur(Request $request) {
        $nomenclature = new Nomenclature();
        $nomenclature->nomenclature_name = strtoupper($request->nomenclature_name);
        $nomenclature->save();
        return redirect()->back()->with('success', 'Berhasil menambah data tipe bangunan!');
    }

    public function editKecamatan(Request $request) {
        $kecamatan = Kecamatan::find($request->kecamatan);
        $kecamatan->kecamatan_id = $request->kecamatan_id;
        $kecamatan->nama = $request->nama;
        $kecamatan->save();
        return redirect()->back()->with('success', 'Berhasil mengubah data kecamatan!');
    }

    public function editKelurahan(Request $request) {
        $kelurahan = Kelurahan::find($request->kelurahan);
        $kelurahan->kelurahan_id = $request->kelurahan_id;
        $kelurahan->kecamatan_id = $request->kecamatan_id;
        $kelurahan->nama = $request->nama;
        $kelurahan->save();
        return redirect()->back()->with('success', 'Berhasil mengubah data kelurahan!');

    }

    public function editNomenklatur(Request $request) {
        $nomenclature = Nomenclature::find($request->nomenclature);
        $nomenclature->nomenclature_name = strtoupper($request->nomenclature_name);
        $nomenclature->save();
        return redirect()->back()->with('success', 'Berhasil mengubah data tipe bangunan!');
    }
    
    public function deleteKecamatan($id) {
        $kelurahan = Kelurahan::where('kecamatan_id', $id)->get();
        foreach($kelurahan as $k) {
            $k->delete();
        }
        $kelurahan = Kecamatan::find($id);
        $kelurahan->delete();

        return redirect()->back()->with('error', 'Berhasil menghapus data kecamatan!');

    }
    
    public function deleteKelurahan($id) {
        $kelurahan = Kelurahan::find($id);
        $kelurahan->delete();

        return redirect()->back()->with('error', 'Berhasil menghapus data kelurahan!');

    }

    public function deleteNomenklatur($id) {
        $nomenclatur = Nomenclature::find($id);
        $nomenclatur->delete();

        return redirect()->back()->with('error', 'Berhasil menghapus data tipe bangunan!');
    }

    public function checkPayment($invoice)
    {
        $order = Order::where('order_invoice', $invoice)->first();
        $checkTransaction = $this->apiController->getTransactionTripay($order);

        switch ($checkTransaction->data->status) {
            case 'PAID':
                $order->order_status_payment = 'payed';
                $order->save();
                return redirect()->back()->with('success', 'Pemesanan dengan invoice '. $order->order_invoice .' berhasil dibayar!');
            case 'EXPIRED':
                $order->order_status_payment = 'fail_pay';
                break;
            case 'FAILED':
                $order->order_status_payment = 'fail_pay';
                break;
            default:
                return redirect()->back()->with('error', 'Pemesanan dengan invoice '. $order->order_invoice .' belum dibayar!');
        }

        $order->save();
        return redirect()->back()->with('error', 'Pemesanan dengan invoice '. $order->order_invoice .' gagal dibayar! Silakan cek Tripay untuk informasi lebih lanjut');
    }

    public function filterMember(Request $request) {
        if($request->nomenclature == 'all') {
            $customers = Customer::with('user')->get();
        } else {
            $customers = Customer::with('user')->where('customer_nomenklatur', $request->nomenclature)->get();
        }

        return [
            'datas' => $customers
        ];
    }
}
