<?php

use App\Http\Controllers\AccessController;
use App\Http\Controllers\AntrianController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DesignOfflineController;
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

    // antrian
        Route::get('antrian/tanggal', [AntrianController::class, 'tanggal'])->name('antrian.tanggal');
        // cs
        Route::get('antrian/page_cs', [AntrianController::class, 'cs'])->name('antrian_cs');
        Route::get('antrian/page_cs/list', [AntrianController::class, 'cslist'])->name('antrian_cs.list');
        Route::get('antrian/page_cs/nomor', [AntrianController::class, 'csNomor'])->name('antrian_cs.nomor');
        Route::get('antrian/page_cs/{id}/status/{status}', [AntrianController::class, 'csStatus'])->name('antrian_cs.status');
        // Route::get('antrian/page_cs/{nomor}/panggil', [AntrianController::class, 'csPanggil'])->name('antrian_cs.panggil');
        // Route::get('antrian/page_cs/{nomor}/jenis/{nama_jenis}', [AntrianController::class, 'csUpdate'])->name('antrian_cs.update');
        // Route::get('antrian/page_cs/{nomor}/batal', [AntrianController::class, 'csBatal'])->name('antrian_cs.batal');
        // Route::get('antrian/page_cs/{nomor}/mulai', [AntrianController::class, 'csMulai'])->name('antrian_cs.mulai');
        // Route::get('antrian/page_cs/mulai/counter', [AntrianController::class, 'csMulaiCounter'])->name('antrian_cs.mulai.counter');
        // Route::get('antrian/page_cs/{nomor}/selesai', [AntrianController::class, 'csSelesai'])->name('antrian_cs.selesai');
        // Route::get('antrian/page_cs/{nomor}/pindah', [AntrianController::class, 'csPindah'])->name('antrian_cs.pindah');
        Route::post('antrian/page_cs/aksi', [AntrianController::class, 'csAksi'])->name('antrian_cs.aksi');
        Route::get('antrian/notif', [AntrianController::class, 'notif'])->name('antrian.notif');
        Route::get('antrian/notif/delete', [AntrianController::class, 'notifDelete'])->name('antrian.notif.delete');

        // customer
        Route::get('antrian/page_customer', [AntrianController::class, 'customer'])->name('antrian_customer');
        Route::get('antrian/page_customer/{id}/form', [AntrianController::class, 'customerForm'])->name('antrian_customer.form');
        Route::post('antrian/page_customer/search', [AntrianController::class, 'customerSearch'])->name('antrian_customer.search');
        Route::post('antrian/page_customer/store', [AntrianController::class, 'customerStore'])->name('antrian.customer.store');
        Route::get('antrian/reset_antrian', [AntrianController::class, 'resetAntrian'])->name('antrian_reset_antrian');

        Route::get('antrian/page_customer_pbg', [AntrianController::class, 'customerPbg'])->name('antrian_customer_pbg');
        Route::get('antrian/page_customer_pbg/{id}/form', [AntrianController::class, 'customerFormPbg'])->name('antrian_customer_pbg.form');

        // desain
        Route::get('antrian/page_desain', [AntrianController::class, 'desain'])->name('antrian_desain');
        Route::get('antrian/page_desain/list', [AntrianController::class, 'desainlist'])->name('antrian_desain.list');
        Route::get('antrian/page_desain/nomor', [AntrianController::class, 'desainNomor'])->name('antrian_desain.nomor');
        Route::get('antrian/page_desain/{id}/status/{status}', [AntrianController::class, 'desainStatus'])->name('antrian_desain.status');
        // Route::get('antrian/page_desain/{nomor}/panggil', [AntrianController::class, 'desainPanggil'])->name('antrian_desain.panggil');
        // Route::get('antrian/page_desain/{nomor}/jenis/{nama_jenis}', [AntrianController::class, 'desainUpdate'])->name('antrian_desain.update');
        // Route::get('antrian/page_desain/{nomor}/batal', [AntrianController::class, 'desainBatal'])->name('antrian_desain.batal');
        // Route::get('antrian/page_desain/{nomor}/mulai', [AntrianController::class, 'desainMulai'])->name('antrian_desain.mulai');
        // Route::get('antrian/page_desain/mulai/counter', [AntrianController::class, 'desainMulaiCounter'])->name('antrian_desain.mulai.counter');
        // Route::get('antrian/page_desain/{nomor}/selesai', [AntrianController::class, 'desainSelesai'])->name('antrian_desain.selesai');
        Route::post('antrian/page_desain/aksi', [AntrianController::class, 'desainAksi'])->name('antrian_desain.aksi');

        // display
        Route::get('antrian/page_display', [AntrianController::class, 'display'])->name('antrian_display');
        Route::get('antrian/page_display/list', [AntrianController::class, 'displayList'])->name('antrian_display.list');
        Route::get('antrian/page_display/list/desain', [AntrianController::class, 'displayListDesain'])->name('antrian_display.list.desain');
        Route::get('antrian/page_display/panggil', [AntrianController::class, 'displayPanggil'])->name('antrian_display.panggil');
        Route::get('antrian/page_display/panggil/delete', [AntrianController::class, 'displayPanggilDelete'])->name('antrian_display.panggil.delete');

        // cs to desain
        Route::get('antrian/page_cs_to_desain/list', [AntrianController::class, 'csToDesainList'])->name('antrian_cs_to_desain.list');
        // Route::get('antrian/page_cs_to_desain/{nomor}/panggil', [AntrianController::class, 'csToDesainPanggil'])->name('antrian_cs_to_desain.panggil');
        // Route::get('antrian/page_cs_to_desain/{nomor}/mulai', [AntrianController::class, 'csToDesainMulai'])->name('antrian_cs_to_desain.mulai');
        // Route::get('antrian/page_cs_to_desain/{nomor}/selesai', [AntrianController::class, 'csToDesainSelesai'])->name('antrian_cs_to_desain.selesai');
        Route::post('antrian/page_cs_to_desain/aksi', [AntrianController::class, 'csToDesainAksi'])->name('antrian_cs_to_desain.aksi');

        // design offline
        Route::get('design_offline/customer', [DesignOfflineController::class, 'customer'])->name('design_offline.customer');
        Route::post('design_offline/customer/store', [DesignOfflineController::class, 'customerStore'])->name('design_offline.customer.store');
        Route::post('design_offline/customer/search', [DesignOfflineController::class, 'customerSearch'])->name('design_offline.customer.search');

        Route::get('design_offline/desain', [DesignOfflineController::class, 'desain'])->name('design_offline.desain');
        Route::get('design_offline/desain/data', [DesignOfflineController::class, 'desainData'])->name('design_offline.desain.data');
        Route::put('design_offline/desain/{id}/update', [DesignOfflineController::class, 'desainUpdate'])->name('design_offline.desain.update');
        Route::get('design_offline/desain/{id}/upload', [DesignOfflineController::class, 'desainUpload'])->name('design_offline.desain.upload');
});
