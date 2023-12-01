<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;

class AdministratorController extends Controller
{
    protected $apiController;
    public function __construct(ApiController $apiController)
    {
        $this->apiController = $apiController;
        $this->middleware(function ($request, $next) {
            if (Auth::guest()) {
                Redirect::to("/")->send();
            }

            if (Auth::user()->level != 'administrator') {
                Redirect::to("/logout")->send();
            }

            return $next($request);
        });
    }

    public function home() {
        $orderOrdered = Order::where('order_status', 'ordered')->count();
        $orderProcess = Order::where('order_status', 'process')->count();
        $orderFailed = Order::where('order_status', 'failed')->count();
        $orderDone = Order::where('order_status', 'done')->count();
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

        return view('administrator.home', ['orderOrdered' => $orderOrdered, 'orderProcess' => $orderProcess, 'orderFailed' => $orderFailed, 'orderDone' => $orderDone, 'dailyOrders' => $dailyOrders, 'orders' => $orders]);
    }

    public function member() {
        $customers = Customer::with('user')->get();
        return view('administrator.my-member', ['customers' => $customers]);
    }

    public function armada() {
        return view('administrator.my-armada');
    }

    public function transaction() {
        return view('administrator.my-transaksi');
    }

    public function gps() {
        return view('administrator.my-gps');
    }

    public function ecosystem() {
        return view('administrator.ecosystem-siyati');
    }

    public function updateMember(Request $request) {
        $customer = Customer::find($request->customer);
        $customer->customer_name = $request->customer_name;
        $customer->customer_phone = $request->customer_phone;
        $customer->customer_address = $request->customer_address;
        $customer->customer_nomenklatur = $request->customer_nomenklatur;
        $customer->customer_subdistrict = $request->customer_subdistrict;
        $customer->customer_urban_village = $request->customer_urban_village;
        $customer->customer_vol = $request->customer_vol;
        $customer->customer_unit = $request->customer_unit;
        $customer->save();

        return redirect()->back()->with('success', 'Berhasil mengubah data member!');

    }

    public function deleteMember($id) {
        $customer = Customer::find($id);
        $user = User::find($customer->user_id);
        File::delete(public_path($customer->customer_photo));
        $customer->delete();
        $user->delete();
        return redirect()->back()->with('failed', 'Berhasil menghapus data member!');
    }

    public function exportMember() {
        
        $query = "SELECT b.nik, a.* FROM customers a inner join users b on a.user_id = b.user_id";

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
                fputcsv($file, array($data->nik, $data->customer_name, $data->customer_phone, $data->customer_address, $data->customer_subdistrict, $data->customer_urban_village, $data->customer_vol, $data->customer_unit, $data->customer_nomenklatur, $data->customer_lat, $data->customer_long));
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
}
