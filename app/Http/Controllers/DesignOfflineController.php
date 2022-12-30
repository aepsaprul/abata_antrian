<?php

namespace App\Http\Controllers;

use App\Models\KonsepSementara;
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
    $konsep_sementara = new KonsepSementara;
    $konsep_sementara->customer_id = $request->konsumen_id;
    $konsep_sementara->harga_desain = $request->harga_desain;
    $konsep_sementara->status_id = 0;
    $konsep_sementara->karyawan_id = Auth::user()->master_karyawan_id;

    if (Auth::user()->roles == "admin") {
      $konsep_sementara->cabang_id = 1;      
    } else {
      $konsep_sementara->cabang_id = Auth::user()->karyawan->master_cabang_id;
    }
    $konsep_sementara->save();

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
    $konsep_sementara = KonsepSementara::with('customer')
      ->where('status_id', '!=', '5')
      ->get();

    return view('pages.design_offline.desain.konsepSementara', ['konsep_sementaras' => $konsep_sementara]);
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
    
    $konsep_sementara = KonsepSementara::find($id);

    $default = strtotime('00:00:00'); // default detik
    $waktu_db = strtotime($konsep_sementara->waktu) - $default; // field waktu yg ada di DB di kurangi default
    $waktu_sekarang = strtotime(waktu($konsep_sementara->updated_at, date('Y-m-d H:i:s'))) - $default; // selisih waktu approv dan ambil konsep
    $waktu_total = $waktu_db + $waktu_sekarang; // field waktu DB di tambah selisih waktu (approve & ambil konsep)
    $h = floor($waktu_total / (60 * 60)); // hasil penjumlahan di jadikan jam
    $m = intval($waktu_total / 60); // sisa hasil penjumlahan dijadikan menit
    if ($h < 10) {$h_fix = '0'.$h;} else {$h_fix = $h;} // jam dibawah 10 tambah 0 didepan
    if ($m < 10) {$m_fix = '0'.$m;} else {$m_fix = $m;} // menit dibawah 10 tambah 0 didepan

    if ($request->status == "ambil") {
      $status_id = 1;
      $konsep_sementara->status_id = $status_id;
      $konsep_sementara->karyawan_id = Auth::user()->master_karyawan_id;
    } else if ($request->status == "approv") {
      $status_id = 2;
      $konsep_sementara->status_id = $status_id;
      $konsep_sementara->waktu = $h_fix . ':' . $m_fix . ':00';
    } else if ($request->status == "revisi") {
      $status_id = 3;
      $konsep_sementara->status_id = $status_id;
    } else if ($request->status == "selesai") {
      $status_id = 4;
      $konsep_sementara->status_id = $status_id;
    } else {
      $status_id = 5;
      $konsep_sementara->status_id = $status_id;
      $konsep_sementara->gambar = $request->gambar;
    }
    
    $konsep_sementara->save();

    $konsep_timer = new KonsepTimer;
    $konsep_timer->konsep_id = $id;
    $konsep_timer->status_id = $status_id;
    $konsep_timer->karyawan_id = Auth::user()->master_karyawan_id;
    $konsep_timer->save();

    return response()->json([
      'status' => $request->all()
    ]);
  }

  public function desainUpload($id)
  {
    $konsep_sementara = KonsepSementara::with('customer')->find($id);
    $konsep_timer = KonsepTimer::where('konsep_id', $konsep_sementara->id)->where('status_id', '4')->first();

    return view('pages.design_offline.desain.upload', ['konsep_sementara' => $konsep_sementara, 'konsep_timer' => $konsep_timer]);
  }
}
