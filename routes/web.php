<?php

use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ArmadaController;
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
Route::get('/', [AuthController::class, 'portal']);
Route::get('/masuk', [AuthController::class, 'login']);
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
Route::get('/septic-tank', [CustomerController::class, 'sepithank']);
Route::get('/hapus-sepithank/{id}', [CustomerController::class, 'deleteSepithank']);
Route::get('/selesaikan-permintaan/{id}', [CustomerController::class, 'doneOrder']);

Route::post('/ubah-profil', [AuthController::class, 'changeProfile']);
Route::post('/permintaan', [CustomerController::class, 'request']);
Route::post('/select-payment-virtual', [CustomerController::class, 'paymentVirtual']);
Route::post('/tambah-sepithank', [CustomerController::class, 'addSepithank']);
Route::post('/edit-sepithank', [CustomerController::class, 'editSepithank']);

// Administrator
Route::get('/administrator/beranda', [AdministratorController::class, 'home']);
Route::get('/administrator/master-data', [AdministratorController::class, 'masterData']);
Route::get('/administrator/my-member', [AdministratorController::class, 'member']);
Route::get('/administrator/my-armada', [AdministratorController::class, 'armada']);
Route::get('/administrator/my-transaksi', [AdministratorController::class, 'transaction']);
Route::get('/administrator/my-gps', [AdministratorController::class, 'gps']);
Route::get('/administrator/ecosystem-siyati', [AdministratorController::class, 'ecosystem']);
Route::get('/administrator/delete-member/{id}', [AdministratorController::class, 'deleteMember']);
Route::get('/administrator/export-member', [AdministratorController::class, 'exportMember']);
Route::get('/administrator/hapus-kecamatan/{id}', [AdministratorController::class, 'deleteKecamatan']);
Route::get('/administrator/hapus-kelurahan/{id}', [AdministratorController::class, 'deleteKelurahan']);
Route::get('/administrator/hapus-nomenklatur/{id}', [AdministratorController::class, 'deleteNomenklatur']);
Route::get('/administrator/hapus-armada/{id}', [AdministratorController::class, 'deleteArmada']);
Route::get('/administrator/tolak-permintaan/{id}', [AdministratorController::class, 'rejectOrder']);
Route::get('/administrator/selesaikan-permintaan/{id}', [AdministratorController::class, 'doneOrder']);
Route::get('/administrator/cek-pembayaran/{invoice}', [AdministratorController::class, 'checkPayment']);

Route::post('/administrator/update-member', [AdministratorController::class, 'updateMember']);
Route::post('/administrator/tambah-kecamatan', [AdministratorController::class, 'addKecamatan']);
Route::post('/administrator/tambah-kelurahan', [AdministratorController::class, 'addKelurahan']);
Route::post('/administrator/tambah-nomenklatur', [AdministratorController::class, 'addNomenklatur']);
Route::post('/administrator/ubah-kecamatan', [AdministratorController::class, 'editKecamatan']);
Route::post('/administrator/ubah-kelurahan', [AdministratorController::class, 'editKelurahan']);
Route::post('/administrator/ubah-nomenklatur', [AdministratorController::class, 'editNomenklatur']);
Route::post('/administrator/tambah-armada', [AdministratorController::class, 'addArmada']);
Route::post('/administrator/ubah-armada', [AdministratorController::class, 'editArmada']);
Route::post('/administrator/pilih-driver', [AdministratorController::class, 'pickArmada']);

// Armada
Route::get('/armada/beranda', [ArmadaController::class, 'home']);
Route::get('/armada/berangkat/{id}', [ArmadaController::class, 'onTheWay']);
Route::get('/armada/bekerja/{id}', [ArmadaController::class, 'doTheWork']);

Route::post('/armada/upload-bukti-pengerjaan', [ArmadaController::class, 'proofOfWork']);
