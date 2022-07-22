<?php

use App\Http\Controllers\AccessController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DisplayCustomerController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\NavigasiController;
use App\Http\Controllers\PageCustomerController;
use App\Http\Controllers\SitumpurController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function() {
    return redirect()->route('login');
});

Auth::routes([
    'register' => false
]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::get('access', [AccessController::class, 'index'])->name('access'); // backup

    // dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('dashboard/situmpur_pengunjung', [DashboardController::class, 'situmpurPengunjung'])->name('dashboard.situmpur_pengunjung');

    // master
        // navgasi
        Route::get('master/navigasi', [NavigasiController::class, 'index'])->name('navigasi.index');
        Route::post('master/navigasi/main_store', [NavigasiController::class, 'mainStore'])->name('navigasi.main_store');
        Route::get('master/navigasi/{id}/main_edit', [NavigasiController::class, 'mainEdit'])->name('navigasi.main_edit');
        Route::post('master/navigasi/main_update', [NavigasiController::class, 'mainUpdate'])->name('navigasi.main_update');
        Route::get('master/navigasi/{id}/main_delete_btn', [NavigasiController::class, 'mainDeleteBtn'])->name('navigasi.main_delete_btn');
        Route::post('master/navigasi/main_delete', [NavigasiController::class, 'mainDelete'])->name('navigasi.main_delete');

        // navigasi sub
        Route::get('master/navigasi/sub_create', [NavigasiController::class, 'subCreate'])->name('navigasi.sub_create');
        Route::post('master/navigasi/sub_store', [NavigasiController::class, 'subStore'])->name('navigasi.sub_store');
        Route::get('master/navigasi/{id}/sub_edit', [NavigasiController::class, 'subEdit'])->name('navigasi.sub_edit');
        Route::post('master/navigasi/sub_update', [NavigasiController::class, 'subUpdate'])->name('navigasi.sub_update');
        Route::get('master/navigasi/{id}/sub_delete_btn', [NavigasiController::class, 'subDeleteBtn'])->name('navigasi.sub_delete_btn');
        Route::post('master/navigasi/sub_delete', [NavigasiController::class, 'subDelete'])->name('navigasi.sub_delete');

        // navigasi tombol
        Route::get('master/navigasi/tombol_create', [NavigasiController::class, 'tombolCreate'])->name('navigasi.tombol_create');
        Route::post('master/navigasi/tombol_store', [NavigasiController::class, 'tombolStore'])->name('navigasi.tombol_store');
        Route::get('master/navigasi/{id}/tombol_edit', [NavigasiController::class, 'tombolEdit'])->name('navigasi.tombol_edit');
        Route::post('master/navigasi/tombol_update', [NavigasiController::class, 'tombolUpdate'])->name('navigasi.tombol_update');
        Route::get('master/navigasi/{id}/tombol_delete_btn', [NavigasiController::class, 'tombolDeleteBtn'])->name('navigasi.tombol_delete_btn');
        Route::post('master/navigasi/tombol_delete', [NavigasiController::class, 'tombolDelete'])->name('navigasi.tombol_delete');

        // user
        Route::get('master/user', [UserController::class, 'index'])->name('user.index');
        Route::get('master/user/create', [UserController::class, 'create'])->name('user.create');
        Route::post('master/user/store', [UserController::class, 'store'])->name('user.store');
        Route::get('master/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::post('master/user/update', [UserController::class, 'update'])->name('user.update');
        Route::get('master/user/{id}/access', [UserController::class, 'access'])->name('user.access');
        Route::post('master/user/access_store', [UserController::class, 'accessStore'])->name('user.access_store');
        Route::post('master/user/delete', [UserController::class, 'delete'])->name('user.delete');

    // customer
    Route::get('customer', [CustomerController::class, 'index'])->name('customer.index');
    Route::get('customer/create', [CustomerController::class, 'create'])->name('customer.create');
    Route::post('customer/store', [CustomerController::class, 'store'])->name('customer.store');
    Route::get('customer/{id}/edit', [CustomerController::class, 'edit'])->name('customer.edit');
    Route::post('customer/update', [CustomerController::class, 'update'])->name('customer.update');
    Route::get('customer/{id}/delete_btn', [CustomerController::class, 'deleteBtn'])->name('customer.delete_btn');
    Route::post('customer/delete', [CustomerController::class, 'delete'])->name('customer.delete');

    // situmpur
        // customer
        Route::get('situmpur/page_customer', [SitumpurController::class, 'customer'])->name('situmpur_customer');
        Route::get('situmpur/page_customer/{id}/form', [SitumpurController::class, 'customerForm'])->name('situmpur_customer.form');
        Route::post('situmpur/page_customer/search', [SitumpurController::class, 'customerSearch'])->name('situmpur_customer.search');
        Route::post('situmpur/page_customer/store', [SitumpurController::class, 'customerStore'])->name('situmpur.customer.store');
        Route::get('situmpur/reset_antrian', [SitumpurController::class, 'resetAntrian'])->name('situmpur_reset_antrian');

        // desain
        Route::get('situmpur/page_desain', [SitumpurController::class, 'desain'])->name('situmpur_desain');
        Route::get('situmpur/page_desain/nomor', [SitumpurController::class, 'desainNomor'])->name('situmpur_desain.nomor');
        Route::get('situmpur/page_desain/{id}/on', [SitumpurController::class, 'desainOn'])->name('situmpur_desain.on');
        Route::get('situmpur/page_desain/{id}/off', [SitumpurController::class, 'desainOff'])->name('situmpur_desain.off');
        Route::get('situmpur/page_desain/{nomor}/panggil', [SitumpurController::class, 'desainPanggil'])->name('situmpur_desain.panggil');
        Route::get('situmpur/page_desain/{nomor}/jenis/{nama_jenis}', [SitumpurController::class, 'desainUpdate'])->name('situmpur_desain.update');
        Route::get('situmpur/page_desain/{nomor}/batal', [SitumpurController::class, 'desainBatal'])->name('situmpur_desain.batal');
        Route::get('situmpur/page_desain/{nomor}/mulai', [SitumpurController::class, 'desainMulai'])->name('situmpur_desain.mulai');
        Route::get('situmpur/page_desain/mulai/counter', [SitumpurController::class, 'desainMulaiCounter'])->name('situmpur_desain.mulai.counter');
        Route::get('situmpur/page_desain/{nomor}/selesai', [SitumpurController::class, 'desainSelesai'])->name('situmpur_desain.selesai');

        // display
        Route::get('situmpur/page_display', [SitumpurController::class, 'display'])->name('situmpur_display');
});
