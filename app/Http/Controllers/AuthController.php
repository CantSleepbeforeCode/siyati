<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Stevebauman\Location\Facades\Location;

class AuthController extends Controller
{
    private $maxSize = 1048576;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::guest()) {
                if (Auth::user()->level == 'administrator') {
                    Redirect::to("/administrator/beranda")->send();
                }
                if (Auth::user()->level == 'staff') {
                    Redirect::to("/beranda")->send();
                }
            }

            return $next($request);
        });
    }

    public function login(Request $request)
    {
        if ($request->method() == 'GET') {
            return view('auth.login');
        } else if ($request->method() == 'POST') {
            $user = User::where('nik', $request->nik)->first();
            if (Auth::attempt(['nik' => $request->nik, 'password' => $request->password])) {
                if ($user->level == 'administrator') {
                    Auth::login($user);
                    return redirect('/administrator/beranda');
                } elseif ($user->level == 'customer') {
                    Auth::login($user);
                    return redirect('/beranda');
                } else {
                    return back()->with('error', 'Akun anda tidak dapat diidentifikasi, silahkan hubungi Admin!');
                }
            } else {
                return back()->with('error', 'NIK atau Password salah!');
            }
        }
    }

    public function signUp(Request $request)
    {
        if ($request->method() == 'GET') {
            return view('auth.register');
        } else if ($request->method() == 'POST') {
            $user = User::where('nik', $request->nik)->first();
            if ($user != null) {
                return back()->with('error', 'NIK anda telah terdaftar! Silahkan login menggunakan NIK yang telah terdaftar.');
            }

            $newUser = new User();
            $newUser->nik = $request->nik;
            $newUser->password = Hash::make($request->password);
            $newUser->level = 'customer';
            $newUser->save();

            $customer = new Customer();
            $customer->user_id = $newUser->user_id;
            $customer->customer_name = $request->customer_name;
            $customer->customer_phone = $request->customer_phone;
            $customer->customer_address = $request->customer_address;
            $customer->customer_subdistrict = $request->customer_subdistrict;
            $customer->customer_urban_village = $request->customer_urban_village;
            $customer->customer_vol = $request->customer_vol;
            $customer->customer_unit = $request->customer_unit;
            $customer->customer_nomenklatur = $request->customer_nomenklatur;

            $toPhoto = '/image';
            if ($request->has('customer_photo')) {
                $image1 = $request->file('customer_photo');
                $namePhoto1 = time() . "_" . strtolower(str_replace(" ", "_", $request->nik)) . ".jpg";

                if ($image1->getSize() > $this->maxSize) {
                    return redirect()->back()->with('failed', 'Ukuran foto terlalu besar!');
                }

                $image1->move(public_path($toPhoto), $namePhoto1);

                $customer->customer_photo = $toPhoto . '/' . $namePhoto1;
            }

            $customer->save();

            Auth::login($newUser);
            return redirect('/beranda');
        }
    }

    public function changeProfile(Request $request) {
        $customer = Customer::where('user_id', Auth::id())->first();
        $customer->customer_address = $request->customer_address;
        $customer->customer_subdistrict = $request->customer_subdistrict;
        $customer->customer_urban_village = $request->customer_urban_village;
        $customer->customer_vol = $request->customer_vol;
        $customer->customer_unit = $request->customer_unit;

        
        if ($request->has('customer_photo')) {
            $toPhoto = '/image';
            File::delete(public_path($customer->customer_photo));
            $image1 = $request->file('customer_photo');
            $namePhoto1 = time() . "_" . strtolower(str_replace(" ", "_", $request->product_name)) . "_1.jpg";

            if ($image1->getSize() > $this->maxSize) {
                return redirect()->back()->with('failed', 'Ukuran foto terlalu besar!');
            }

            $image1->move(public_path($toPhoto), $namePhoto1);

            $customer->customer_photo = $toPhoto . '/' . $namePhoto1;
        }

        $customer->save();
        return redirect()->back()->with('success', 'Berhasil mengubah data pribadi anda!');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
    
}
