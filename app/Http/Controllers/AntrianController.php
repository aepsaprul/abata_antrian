<?php

namespace App\Http\Controllers;

use App\Models\AntrianNotif;
use App\Models\AntrianPanggil;
use App\Models\AntrianPengunjung;
use App\Models\AntrianSementara;
use App\Models\AntrianUser;
use App\Models\MasterCustomer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AntrianController extends Controller
{
  public function tanggal()
  {
    $antrian = AntrianSementara::first();
    if ($antrian != null) {
      $tanggal = $antrian->created_at->format('d');
    } else {
      $tanggal = 0;
    }
    

    return response()->json([
      'status' => $tanggal
    ]);
  }
  
  // customer
  public function customer()
  {
    return view('pages.antrian.customer');
  }

  public function customerPbg()
  {
    return view('pages.antrian.customerPbg');
  }

  public function customerForm($id)
  {
    if ($id == '3') {
      if (Auth::user()->roles == "admin" || Auth::user()->karyawan->master_cabang_id == 1) {
        $nomors = AntrianSementara::where('cabang_id', 1)->where('jabatan', 'cs')->where('keterangan', '!=', 'desain')->orderBy('id', 'desc')->first();
        $count_nomor_panggil = count(AntrianSementara::where('cabang_id', 1)->where('jabatan', 'cs')->where('keterangan', '!=', 'desain')->where('status','!=', '0')->get());
        $count_nomor_all = count(AntrianSementara::where('cabang_id', 1)->where('jabatan', 'cs')->where('keterangan', '!=', 'desain')->get());
      } else {
        $nomors = AntrianSementara::where('cabang_id', Auth::user()->karyawan->master_cabang_id)->where('jabatan', 'cs')->where('keterangan', '!=', 'desain')->orderBy('id', 'desc')->first();
        $count_nomor_panggil = count(AntrianSementara::where('cabang_id', Auth::user()->karyawan->master_cabang_id)->where('jabatan', 'cs')->where('keterangan', '!=', 'desain')->where('status','!=', '0')->get());
        $count_nomor_all = count(AntrianSementara::where('cabang_id', Auth::user()->karyawan->master_cabang_id)->where('jabatan', 'cs')->where('keterangan', '!=', 'desain')->get());
      }
      return view('pages.antrian.formCs', [
        'customer_filter_id' => $id,
        'nomors' => $nomors,
        'count_nomor_panggil' => $count_nomor_panggil,
        'count_nomor_all' => $count_nomor_all
      ]);
    } else {
      if (Auth::user()->roles == "admin" || Auth::user()->karyawan->master_cabang_id == 1) {
        $nomors = AntrianSementara::where('cabang_id', 1)->where('jabatan', 'desain')->where('keterangan', '!=', 'cs')->orderBy('id', 'desc')->first();
        $count_nomor_panggil = count(AntrianSementara::where('cabang_id', 1)->where('jabatan', 'desain')->where('keterangan', '!=', 'cs')->where('status','!=', '0')->get());
        $count_nomor_all = count(AntrianSementara::where('cabang_id', 1)->where('jabatan', 'desain')->where('keterangan', '!=', 'cs')->get());
      } else {
        $nomors = AntrianSementara::where('cabang_id', Auth::user()->karyawan->master_cabang_id)->where('jabatan', 'desain')->where('keterangan', '!=', 'cs')->orderBy('id', 'desc')->first();
        $count_nomor_panggil = count(AntrianSementara::where('cabang_id', Auth::user()->karyawan->master_cabang_id)->where('jabatan', 'desain')->where('keterangan', '!=', 'cs')->where('status','!=', '0')->get());
        $count_nomor_all = count(AntrianSementara::where('cabang_id', Auth::user()->karyawan->master_cabang_id)->where('jabatan', 'desain')->where('keterangan', '!=', 'cs')->get());
      }

      return view('pages.antrian.formDesain', [
        'customer_filter_id' => $id,
        'nomors' => $nomors,
        'count_nomor_panggil' => $count_nomor_panggil,
        'count_nomor_all' => $count_nomor_all
      ]);
    }
  }

  public function customerFormPbg($id)
  {
    if ($id == '3') {
      if (Auth::user()->roles == "admin" || Auth::user()->karyawan->master_cabang_id == 1) {
        $nomors = AntrianSementara::where('cabang_id', 1)->where('jabatan', 'cs')->where('keterangan', '!=', 'desain')->orderBy('id', 'desc')->first();
        $count_nomor_panggil = count(AntrianSementara::where('cabang_id', 1)->where('jabatan', 'cs')->where('keterangan', '!=', 'desain')->where('status','!=', '0')->get());
        $count_nomor_all = count(AntrianSementara::where('cabang_id', 1)->where('jabatan', 'cs')->where('keterangan', '!=', 'desain')->get());
      } else {
        $nomors = AntrianSementara::where('cabang_id', Auth::user()->karyawan->master_cabang_id)->where('jabatan', 'cs')->where('keterangan', '!=', 'desain')->orderBy('id', 'desc')->first();
        $count_nomor_panggil = count(AntrianSementara::where('cabang_id', Auth::user()->karyawan->master_cabang_id)->where('jabatan', 'cs')->where('keterangan', '!=', 'desain')->where('status','!=', '0')->get());
        $count_nomor_all = count(AntrianSementara::where('cabang_id', Auth::user()->karyawan->master_cabang_id)->where('jabatan', 'cs')->where('keterangan', '!=', 'desain')->get());
      }
      return view('pages.antrian.formCsPbg', [
        'customer_filter_id' => $id,
        'nomors' => $nomors,
        'count_nomor_panggil' => $count_nomor_panggil,
        'count_nomor_all' => $count_nomor_all
      ]);
    } else {
      if (Auth::user()->roles == "admin" || Auth::user()->karyawan->master_cabang_id == 1) {
        $nomors = AntrianSementara::where('cabang_id', 1)->where('jabatan', 'desain')->where('keterangan', '!=', 'cs')->orderBy('id', 'desc')->first();
        $count_nomor_panggil = count(AntrianSementara::where('cabang_id', 1)->where('jabatan', 'desain')->where('keterangan', '!=', 'cs')->where('status','!=', '0')->get());
        $count_nomor_all = count(AntrianSementara::where('cabang_id', 1)->where('jabatan', 'desain')->where('keterangan', '!=', 'cs')->get());
      } else {
        $nomors = AntrianSementara::where('cabang_id', Auth::user()->karyawan->master_cabang_id)->where('jabatan', 'desain')->where('keterangan', '!=', 'cs')->orderBy('id', 'desc')->first();
        $count_nomor_panggil = count(AntrianSementara::where('cabang_id', Auth::user()->karyawan->master_cabang_id)->where('jabatan', 'desain')->where('keterangan', '!=', 'cs')->where('status','!=', '0')->get());
        $count_nomor_all = count(AntrianSementara::where('cabang_id', Auth::user()->karyawan->master_cabang_id)->where('jabatan', 'desain')->where('keterangan', '!=', 'cs')->get());
      }

      return view('pages.antrian.formDesainPbg', [
        'customer_filter_id' => $id,
        'nomors' => $nomors,
        'count_nomor_panggil' => $count_nomor_panggil,
        'count_nomor_all' => $count_nomor_all
      ]);
    }
  }

  public function customerSearch(Request $request) {
    $customers = MasterCustomer::where('telepon', 'like', '%' . $request->value . '%')
      ->limit(5)
      ->get();

    return response()->json([
      'success' => 'berhasil ambil data',
      'customers' => $customers
    ]);
  }

  public function customerStore(Request $request)
  {
    $data_customer = count(MasterCustomer::where('telepon', $request->telepon)->get());
    if ($data_customer == 0) {
      $customers = new MasterCustomer;
      $customers->nama_customer = $request->nama_customer;
      $customers->telepon = $request->telepon;

      if (Auth::user()->roles == "admin" || Auth::user()->karyawan->master_cabang_id == 1) {
        $customers->master_cabang_id = 1;
      } else {
        $customers->master_cabang_id = Auth::user()->karyawan->master_cabang_id;
      }

      $customers->save();
    }

    $antrian_sementara = new AntrianSementara;
    $antrian_sementara->nomor_antrian = $request->nomor_antrian;
    $antrian_sementara->nama_customer = $request->nama_customer;
    $antrian_sementara->telepon = $request->telepon;
    $antrian_sementara->customer_filter_id = $request->customer_filter_id;
    $sisa_antrian = $request->sisa_antrian;

    if (Auth::user()->roles == "admin" || Auth::user()->karyawan->master_cabang_id == 1) {
      $antrian_sementara->cabang_id = 1;
      $cabang_id = 1;
    } else {
      $antrian_sementara->cabang_id = Auth::user()->karyawan->master_cabang_id;
      $cabang_id = Auth::user()->karyawan->master_cabang_id;
    }

    $antrian_notif = new AntrianNotif;
    
    if ($request->customer_filter_id == '3') {
      $antrian_sementara->jabatan = "cs";
      $antrian_sementara->keterangan = "cs";
      $nomor_antrian_e = "C" . $request->nomor_antrian;
      
      $antrian_notif->jabatan = "cs";
    } else {
      $antrian_sementara->jabatan = "desain";
      $antrian_sementara->keterangan = "desain";
      $nomor_antrian_e = "D" . $request->nomor_antrian;
      
      $antrian_notif->jabatan = "desain";
    }
    
    $antrian_notif->customer_filter_id = $request->customer_filter_id;
    $antrian_notif->cabang_id = $cabang_id;
    $antrian_notif->save();

    $antrian_sementara->save();

    if (Auth::user()->karyawan) {
      if (Auth::user()->karyawan->master_cabang_id == 5) {
        // $url = "http://localhost/test/escpos/vendor/mike42/escpos-php/example/barcode.php?nomor_antrian=".$request->nomor_antrian."&sisa_antrian=".$request->sisa_antrian;
        $url = "http://localhost/posprint/vendor/mike42/escpos-php/example/barcode.php?nomor_antrian=" . $nomor_antrian_e . "&sisa_antrian=" . $sisa_antrian;
        return Redirect::to($url);
      } else {
        return redirect()->route('antrian_customer');
      }
    } else {
      return redirect()->route('antrian_customer');
    }
  }

  public function resetAntrian()
  {
    if (Auth::user()->roles == "admin" || Auth::user()->karyawan->master_cabang_id == 1) {
      AntrianSementara::where('cabang_id', 1)->delete();
    } else {
      AntrianSementara::where('cabang_id', Auth::user()->karyawan->master_cabang_id)->delete();
    }

    return response()->json([
      'status' => 200
    ]);
  }

  // cs
  public function cs()
  {
    $antrian_user = AntrianUser::where('karyawan_id', Auth::user()->master_karyawan_id)->first();

    return view('pages.antrian.cs', ['antrian_user' => $antrian_user]);
  }

  public function csList()
  {
    if (Auth::user()->roles == "admin" || Auth::user()->karyawan->master_cabang_id == 1) {
      $nomors = AntrianSementara::with('karyawan')
        ->where('keterangan', 'cs')
        ->where('cabang_id', 1)
        ->where('status', '!=', '3')
        ->get();
    } else {
      $nomors = AntrianSementara::with('karyawan')
        ->where('keterangan', 'cs')
        ->where('cabang_id', Auth::user()->karyawan->master_cabang_id)
        ->where('status', '!=', '3')
        ->get();
    }

    return view('pages.antrian.csList', ['nomors' => $nomors]);
  }

  public function csStatus($id, $status)
  {
    if ($status == "on") {
      $antrian_user = AntrianUser::where('karyawan_id', $id)->first();
      $antrian_user->status = "on";
      $antrian_user->save();
    } else {
      $antrian_user = AntrianUser::where('karyawan_id', $id)->first();
      $antrian_user->status = "off";
      $antrian_user->save();
    }

    return redirect()->route('antrian_cs');
  }

  public function csAksi(Request $request)
  {
    if (Auth::user()->roles == "admin" || Auth::user()->karyawan->master_cabang_id == 1) {
      $karyawan_id = 0;
      $cabang_id = 1;
    } else {
      $karyawan_id = Auth::user()->master_karyawan_id;
      $cabang_id = Auth::user()->karyawan->master_cabang_id;
    }

    if ($request->aksi == "panggil") {
      $panggil_data = new AntrianPanggil;
      $panggil_data->jabatan = "cs";
      $panggil_data->nomor = 1;
      $panggil_data->antrian = $request->nomor;
      $panggil_data->cabang_id = $cabang_id;
      $panggil_data->save();
    }
    
    if ($request->aksi == "panggil") {
      $antrian_sementara = AntrianSementara::where('cabang_id', $cabang_id)->where('keterangan', 'cs')->where('nomor_antrian', $request->nomor)->first();
      $antrian_sementara->status = 1;
      $antrian_sementara->karyawan_id = $karyawan_id;
      $antrian_sementara->cabang_id = $cabang_id;
    } elseif ($request->aksi == "mulai") {
      $antrian_sementara = AntrianSementara::where('cabang_id', $cabang_id)->where('keterangan', 'cs')->where('nomor_antrian', $request->nomor)->where('status', 1)->first();
      $antrian_sementara->status = 2;
      $antrian_sementara->mulai = Carbon::now();
      $antrian_sementara->karyawan_id = $karyawan_id;
    } elseif ($request->aksi == "selesai") {
      $antrian_sementara = AntrianSementara::where('cabang_id', $cabang_id)->where('keterangan', 'cs')->where('nomor_antrian', $request->nomor)->where('status', 2)->first();
      $antrian_sementara->status = 3;
      $antrian_sementara->selesai = Carbon::now();
      $antrian_sementara->keterangan = "simpan";
    } elseif ($request->aksi == "batal") {
      $antrian_sementara = AntrianSementara::where('cabang_id', $cabang_id)->where('keterangan', 'cs')->where('nomor_antrian', $request->nomor)->where('status', 1)->first();
      $antrian_sementara->status = 4;
      $antrian_sementara->keterangan = "simpan";
    } else {
      $antrian_sementara = AntrianSementara::where('cabang_id', $cabang_id)->where('keterangan', 'cs')->where('nomor_antrian', $request->nomor)->where('status', 2)->first();
      $antrian_sementara->status = 0;
      $antrian_sementara->selesai = Carbon::now();
      $antrian_sementara->keterangan = "cs_to_desain";
    }      
    $antrian_sementara->save();

    $pengunjung = new AntrianPengunjung;
    $pengunjung->nomor_antrian = $request->nomor;
    $pengunjung->nama_customer = $antrian_sementara->nama_customer;
    $pengunjung->telepon = $antrian_sementara->telepon;
    $pengunjung->customer_filter_id = $antrian_sementara->customer_filter_id;
    $pengunjung->jabatan = "cs";
    $pengunjung->master_karyawan_id = $karyawan_id;
    $pengunjung->master_cabang_id = $cabang_id;
    $pengunjung->tanggal = Carbon::now();

    if ($request->aksi == "selesai") {
      $pengunjung->mulai = $antrian_sementara->mulai;
      $pengunjung->selesai = Carbon::now();
      $pengunjung->status = 3;
      $pengunjung->save();
    } else {
      $pengunjung->status = 4;
      $pengunjung->save();
    }      

    return response()->json([
      'status' => 200
    ]);
  }

  public function notif()
  {
    $notif = AntrianNotif::get();
    $cabang_id = Auth::user()->karyawan->master_cabang_id;

    return response()->json([
      'notifs' => $notif,
      'cabang_id' => $cabang_id
    ]);
  }

  public function notifDelete()
  {
    AntrianNotif::truncate();

    return response()->json([
      'status' => 200
    ]);
  }

  // desain
  public function desain()
  {
    $antrian_user = AntrianUser::where('karyawan_id', Auth::user()->master_karyawan_id)->first();

    return view('pages.antrian.desain', ['antrian_user' => $antrian_user]);
  }

  public function desainList()
  {
    if (Auth::user()->roles == "admin" || Auth::user()->karyawan->master_cabang_id == 1) {
      $nomors = AntrianSementara::with('karyawan')
        ->where('keterangan', 'desain')
        ->where('cabang_id', 1)
        ->where('status', '!=', '3')
        ->get();
    } else {
      $nomors = AntrianSementara::with('karyawan')
        ->where('keterangan', 'desain')
        ->where('cabang_id', Auth::user()->karyawan->master_cabang_id)
        ->where('status', '!=', '3')
        ->get();
    }

    return view('pages.antrian.desainList', ['nomors' => $nomors]);
  }

  public function desainStatus($id, $status)
  {
    $antrian_user = AntrianUser::where('karyawan_id', $id)->first();
    if ($status == "on") {
        $antrian_user->status = "on";
    } else {
        $antrian_user->status = "off";
    }
    $antrian_user->save();

    return redirect()->route('antrian_desain');
  }

  public function desainAksi(Request $request)
  {
    if (Auth::user()->roles == "admin" || Auth::user()->karyawan->master_cabang_id == 1) {
      $karyawan_id = 0;
      $cabang_id = 1;
    } else {
      $karyawan_id = Auth::user()->master_karyawan_id;
      $cabang_id = Auth::user()->karyawan->master_cabang_id;
    }

    $antrian_user = AntrianUser::where('karyawan_id', Auth::user()->master_karyawan_id)->first();

    if ($request->aksi == "panggil") {
      $panggil_data = new AntrianPanggil;
      $panggil_data->jabatan = "desain";
      $panggil_data->nomor = $antrian_user->nomor;
      $panggil_data->antrian = $request->nomor;
      $panggil_data->cabang_id = $cabang_id;
      $panggil_data->save();
    }

    if ($request->aksi == "panggil") {
      $antrian_sementara = AntrianSementara::where('cabang_id', $cabang_id)->where('keterangan', 'desain')->where('nomor_antrian', $request->nomor)->first();
      $antrian_sementara->status = 1;
      $antrian_sementara->karyawan_id = $karyawan_id;
      $antrian_sementara->cabang_id = $cabang_id;
    } elseif ($request->aksi == "desain") {
      $antrian_sementara = AntrianSementara::where('cabang_id', $cabang_id)->where('keterangan', 'desain')->where('nomor_antrian', $request->nomor)->first();
      $antrian_sementara->customer_filter_id = 4;
    } elseif ($request->aksi == "edit") {
      $antrian_sementara = AntrianSementara::where('cabang_id', $cabang_id)->where('keterangan', 'desain')->where('nomor_antrian', $request->nomor)->first();
      $antrian_sementara->customer_filter_id = 5;
    } elseif ($request->aksi == "mulai") {
      $antrian_sementara = AntrianSementara::where('cabang_id', $cabang_id)->where('keterangan', 'desain')->where('nomor_antrian', $request->nomor)->where('status', 1)->first();
      $antrian_sementara->status = 2;
      $antrian_sementara->mulai = Carbon::now();
      $antrian_sementara->karyawan_id = $karyawan_id;
    } elseif ($request->aksi == "selesai") {
      $antrian_sementara = AntrianSementara::where('cabang_id', $cabang_id)->where('keterangan', 'desain')->where('nomor_antrian', $request->nomor)->where('status', 2)->first();
      $antrian_sementara->status = 3;
      $antrian_sementara->selesai = Carbon::now();
      $antrian_sementara->keterangan = "simpan";
    } else {
      $antrian_sementara = AntrianSementara::where('cabang_id', $cabang_id)->where('keterangan', 'desain')->where('nomor_antrian', $request->nomor)->where('status', 1)->first();
      $antrian_sementara->status = 4;
      $antrian_sementara->keterangan = "simpan";
    }
    $antrian_sementara->save();

    $pengunjung = new AntrianPengunjung;
    $pengunjung->nomor_antrian = $request->nomor;
    $pengunjung->nama_customer = $antrian_sementara->nama_customer;
    $pengunjung->telepon = $antrian_sementara->telepon;
    $pengunjung->customer_filter_id = $antrian_sementara->customer_filter_id;
    $pengunjung->jabatan = "desain";
    $pengunjung->master_karyawan_id = $karyawan_id;
    $pengunjung->master_cabang_id = $cabang_id;
    $pengunjung->tanggal = Carbon::now();

    if ($request->aksi == "selesai") {
      $pengunjung->mulai = $antrian_sementara->mulai;
      $pengunjung->selesai = Carbon::now();
      $pengunjung->status = 3;
      $pengunjung->save();
    } else {
      $pengunjung->status = 4;
      $pengunjung->save();
    }
    
    return response()->json([
      'status' => 200
    ]);
  }

  // display
  public function display()
  {
    return view('pages.antrian.display');
  }
  public function displayList()
  {
    if (Auth::user()->roles == "admin" || Auth::user()->karyawan->master_cabang_id == 1) {
      $cabang_id = 1;
      $total_antrian = count(AntrianSementara::where('cabang_id', $cabang_id)->orderBy('id', 'desc')->get());
      $total_antrian_cs = 0;
    } else {
      $cabang_id = Auth::user()->karyawan->master_cabang_id;

      if ($cabang_id == 5) {
        $total_antrian = count(AntrianSementara::where('cabang_id', $cabang_id)->where('jabatan', 'desain')->orderBy('id', 'desc')->get());
        $total_antrian_cs = count(AntrianSementara::where('cabang_id', $cabang_id)->where('jabatan', 'cs')->orderBy('id', 'desc')->get());
      } else {
        $total_antrian = count(AntrianSementara::where('cabang_id', $cabang_id)->orderBy('id', 'desc')->get());
        $total_antrian_cs = 0;
      }
    }

    $data_antrian_terakhir = AntrianSementara::where('keterangan', 'simpan')->where('jabatan', 'desain')->where('cabang_id', $cabang_id)->orderBy('id', 'desc')->first();
    if ($data_antrian_terakhir) {
        $antrian_terakhir = $data_antrian_terakhir->nomor_antrian;
    } else {
        $antrian_terakhir = 0;
    }

    $data_antrian_terakhir_cs = AntrianSementara::where('keterangan', 'simpan')->where('jabatan', 'cs')->where('cabang_id', $cabang_id)->orderBy('id', 'desc')->first();
    if ($data_antrian_terakhir_cs) {
      $antrian_terakhir_cs = $data_antrian_terakhir_cs->nomor_antrian;
    } else {
      $antrian_terakhir_cs = 0;
    }

    return view('pages.antrian.displayListTotal', [
      'antrian_terakhir' => $antrian_terakhir,
      'antrian_terakhir_cs' => $antrian_terakhir_cs,
      'total_antrian' => $total_antrian,
      'total_antrian_cs' => $total_antrian_cs
    ]);
  }

  public function displayListDesain()
  {
    if (Auth::user()->roles == "admin" || Auth::user()->karyawan->master_cabang_id == 1) {
      $cabang_id = 1;
    } else {
      $cabang_id = Auth::user()->karyawan->master_cabang_id;
    }

    $antrian_user = AntrianUser::with('karyawan')
      ->where('jabatan', 'desain')
      ->orderBy('nomor', 'asc')
      ->get();

    $antrian_user_cs = User::with(['karyawan', 'antrianUser'])
      ->get();


    $antrian_sementara = AntrianSementara::where('cabang_id', $cabang_id)
      ->where('status', 1)
      ->orWhere('status', 2)
      ->where('keterangan', 'desain')
      ->get();

    $antrian_sementara_cs = AntrianSementara::where('cabang_id', $cabang_id)
      ->where('keterangan', 'cs')
      ->get();

    return view('pages.antrian.displayListDesain', [
      'antrian_users' => $antrian_user,
      'antrian_user_cs' => $antrian_user_cs,
      'antrian_sementaras' => $antrian_sementara,
      'antrian_sementara_cs' => $antrian_sementara_cs
    ]);
  }

  public function displayPanggil()
  {
    $panggil = AntrianPanggil::get();
    $cabang_id = Auth::user()->karyawan->master_cabang_id;

    return response()->json([
      'panggils' => $panggil,
      'cabang_id' => $cabang_id
    ]);
  }

  public function displayPanggilDelete()
  {
    AntrianPanggil::truncate();

    return response()->json([
      'status' => 200
    ]);
  }

  // cs to desain
  public function csToDesainList()
  {
    if (Auth::user()->roles == "admin" || Auth::user()->karyawan->master_cabang_id == 1) {
      $nomors = AntrianSementara::with('karyawan')
        ->where('keterangan', 'cs_to_desain')
        ->where('cabang_id', 1)
        ->where('status', '!=', '3')
        ->get();
    } else {
      $nomors = AntrianSementara::with('karyawan')
        ->where('keterangan', 'cs_to_desain')
        ->where('cabang_id', Auth::user()->karyawan->master_cabang_id)
        ->where('status', '!=', '3')
        ->get();
    }

    return view('pages.antrian.csToDesainList', ['nomors' => $nomors]);
  }

  public function csToDesainAksi(Request $request)
  {
    if (Auth::user()->roles == "admin" || Auth::user()->karyawan->master_cabang_id == 1) {
      $karyawan_id = 0;
      $cabang_id = 1;
    } else {
      $karyawan_id = Auth::user()->master_karyawan_id;
      $cabang_id = Auth::user()->karyawan->master_cabang_id;
    }

    if ($request->aksi == "panggil") {
      $antrian_sementara = AntrianSementara::where('cabang_id', $cabang_id)->where('keterangan', 'cs_to_desain')->where('nomor_antrian', $request->nomor)->first();
      $antrian_sementara->status = 1;
      $antrian_sementara->karyawan_id = $karyawan_id;
      $antrian_sementara->cabang_id = $cabang_id;
    } elseif ($request->aksi == "mulai") {
      $antrian_sementara = AntrianSementara::where('cabang_id', $cabang_id)->where('keterangan', 'cs_to_desain')->where('nomor_antrian', $request->nomor)->where('status', 1)->first();
      $antrian_sementara->status = 2;
      $antrian_sementara->mulai = Carbon::now();
      $antrian_sementara->karyawan_id = $karyawan_id;
    } elseif ($request->aksi == "selesai") {
      $antrian_sementara = AntrianSementara::where('cabang_id', $cabang_id)->where('keterangan', 'cs_to_desain')->where('nomor_antrian', $request->nomor)->where('status', 2)->first();
      $antrian_sementara->status = 3;
      $antrian_sementara->selesai = Carbon::now();
      $antrian_sementara->keterangan = "simpan";
    } else {
      $antrian_sementara = AntrianSementara::where('cabang_id', $cabang_id)->where('keterangan', 'cs_to_desain')->where('nomor_antrian', $request->nomor)->where('status', 1)->first();
      $antrian_sementara->status = 4;
      $antrian_sementara->keterangan = "simpan";
    }
    $antrian_sementara->save();

    $pengunjung = new AntrianPengunjung;
    $pengunjung->nomor_antrian = $request->nomor;
    $pengunjung->nama_customer = $antrian_sementara->nama_customer;
    $pengunjung->telepon = $antrian_sementara->telepon;
    $pengunjung->customer_filter_id = $antrian_sementara->customer_filter_id;
    $pengunjung->jabatan = "desain";
    $pengunjung->master_karyawan_id = $karyawan_id;
    $pengunjung->master_cabang_id = $cabang_id;
    $pengunjung->tanggal = Carbon::now();

    if ($request->aksi == "selesai") {
      $pengunjung->mulai = $antrian_sementara->mulai;
      $pengunjung->selesai = Carbon::now();
      $pengunjung->status = 3;
      $pengunjung->save();
    } else {
      $pengunjung->status = 4;
      $pengunjung->save();
    }
  }
}
