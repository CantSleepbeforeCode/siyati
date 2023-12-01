<?php

use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Auth
Route::get('/', [AuthController::class, 'login']);
Route::get('/daftar', [AuthController::class, 'signUp']);
Route::get('/keluar', [AuthController::class, 'logout']);

Route::post('/masuk', [AuthController::class, 'login']);
Route::post('/daftar', [AuthController::class, 'signUp']);

Route::post('/send-location', [ApiController::class, 'sendLocation']);

// Customer
Route::get('/beranda', [CustomerController::class, 'home']);
Route::get('/permintaan', [CustomerController::class, 'request']);
Route::get('/pembayaran', [CustomerController::class, 'payment']);
Route::get('/laporan', [CustomerController::class, 'report']);
Route::get('/e-card-siyati', [CustomerController::class, 'ecard']);

Route::post('/ubah-profil', [AuthController::class, 'changeProfile']);
Route::post('/permintaan', [CustomerController::class, 'request']);
Route::post('/select-payment-virtual', [CustomerController::class, 'paymentVirtual']);

// Administrator
Route::get('/administrator/beranda', [AdministratorController::class, 'home']);
Route::get('/administrator/my-member', [AdministratorController::class, 'member']);
Route::get('/administrator/my-armada', [AdministratorController::class, 'armada']);
Route::get('/administrator/my-transaksi', [AdministratorController::class, 'transaction']);
Route::get('/administrator/my-gps', [AdministratorController::class, 'gps']);
Route::get('/administrator/ecosystem-siyati', [AdministratorController::class, 'ecosystem']);
Route::get('/administrator/delete-member/{id}', [AdministratorController::class, 'deleteMember']);
Route::get('/administrator/export-member', [AdministratorController::class, 'exportMember']);

Route::post('/administrator/update-member', [AdministratorController::class, 'updateMember']);
