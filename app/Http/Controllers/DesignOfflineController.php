<?php

namespace App\Http\Controllers;

use App\Models\Konsep;
use App\Models\KonsepTimer;
use App\Models\MasterCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DesignOfflineController extends Controller
{
  public function customer()
  {
    $customer = MasterCustomer::get();

    return view('pages.design_offline.cutomer.index', ['customers' => $customer]);
  }

  public function customerSearch(Request $request)
  {
    $customer = MasterCustomer::where('nama_customer', 'like', '%' . $request->nama_konsumen . '%')->orderBy('id', 'desc')->limit(50)->get();

    return response()->json([
      'customers' => $customer
    ]);
  }

  public function customerStore(Request $request)
  {
    $konsep = new Konsep();
    $konsep->customer_id = $request->konsumen_id;
    $konsep->harga_desain = $request->harga_desain;
    $konsep->status_id = 0;
    $konsep->user_id = Auth::user()->id;

    if (Auth::user()->roles == "admin") {
      $konsep->cabang_id = 1;      
    } else {
      $konsep->cabang_id = Auth::user()->karyawan->master_cabang_id;
    }
    $konsep->save();

    return response()->json([
      'status' => $request->all()
    ]);
  }

  public function desain()
  {
    return view('pages.design_offline.desain.index');
  }

  public function desainData()
  {
    if (Auth::user()->roles == "admin") {
      $cabang = 1;      
    } else {
      $cabang = Auth::user()->karyawan->master_cabang_id;
    }
    
    $konsep = Konsep::with('customer')
      ->where('status_id', '!=', '5')
      ->where('cabang_id', $cabang)
      ->get();

    $konsep_timer = KonsepTimer::select('konsep_id', 'user_id')->groupByRaw('konsep_id, user_id')->get();

    return view('pages.design_offline.desain.konsepSementara', ['konseps' => $konsep, 'konsep_timers' => $konsep_timer]);
  }

  public function desainUpdate(Request $request, $id)
  {
    function waktu($tgl_awal, $tgl_akhir) {
      $pertama = strtotime($tgl_awal);
      $kedua = strtotime($tgl_akhir);
      $diff = $kedua - $pertama;
      $jam = floor($diff / (60 * 60));
      $sisa_detik = $diff - $jam * (60 * 60);
      $menit = floor($sisa_detik / 60);
      if ($jam < 10) {
        $jam_fix = '0'.$jam;
      } else {
        $jam_fix = $jam;
      }

      if ($menit < 10) {
        $menit_fix = '0'.$menit;
      } else {
        $menit_fix = $menit;
      }

      return $jam_fix . ":" . $menit_fix . ":00";
    }
    
    $konsep = Konsep::find($id);

    $default = strtotime('00:00:00'); // default detik
    $waktu_db = strtotime($konsep->waktu) - $default; // field waktu yg ada di DB di kurangi default
    $waktu_sekarang = strtotime(waktu($konsep->updated_at, date('Y-m-d H:i:s'))) - $default; // selisih waktu approv dan ambil konsep
    $waktu_total = $waktu_db + $waktu_sekarang; // field waktu DB di tambah selisih waktu (approve & ambil konsep)
    $h = floor($waktu_total / (60 * 60)); // hasil penjumlahan di jadikan jam
    $sisa_d = $waktu_total - $h * (60 * 60);
    $m = floor($sisa_d / 60); // sisa hasil penjumlahan dijadikan menit
    if ($h < 10) {$h_fix = '0'.$h;} else {$h_fix = $h;} // jam dibawah 10 tambah 0 didepan
    if ($m < 10) {$m_fix = '0'.$m;} else {$m_fix = $m;} // menit dibawah 10 tambah 0 didepan

    if ($request->status == "ambil") {
      $status_id = 1;
      $konsep->status_id = $status_id;
      $konsep->user_id = Auth::user()->id;
    } else if ($request->status == "approv") {
      $status_id = 2;
      $konsep->status_id = $status_id;
      $konsep->waktu = $h_fix . ':' . $m_fix . ':00';
    } else if ($request->status == "revisi") {
      $status_id = 3;
      $konsep->status_id = $status_id;
    } else if ($request->status == "selesai") {
      $status_id = 4;
      $konsep->status_id = $status_id;
    } else {
      $status_id = 5;
      $konsep->status_id = $status_id;
      $konsep->gambar = $request->gambar;
    }
    
    $konsep->save();

    $konsep_timer = new KonsepTimer;
    $konsep_timer->konsep_id = $id;
    $konsep_timer->status_id = $status_id;
    $konsep_timer->user_id = Auth::user()->id;
    $konsep_timer->save();

    return response()->json([
      'status' => $m
    ]);
  }

  public function desainUpload($id)
  {
    $konsep = Konsep::with('customer')->find($id);
    $konsep_timer = KonsepTimer::where('konsep_id', $konsep->id)->where('status_id', '4')->first();

    return view('pages.design_offline.desain.upload', ['konsep' => $konsep, 'konsep_timer' => $konsep_timer]);
  }
}
