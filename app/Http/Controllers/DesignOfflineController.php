<?php

namespace App\Http\Controllers;

use App\Models\KonsepSementara;
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
    $konsep_sementara = KonsepSementara::find($id);

    if ($request->status == "ambil") {
      $konsep_sementara->status_id = 1;
      $konsep_sementara->karyawan_id = Auth::user()->master_karyawan_id;
    } else if ($request->status == "approv") {
      $konsep_sementara->status_id = 2;
    } else if ($request->status == "revisi") {
      $konsep_sementara->status_id = 3;
    } else if ($request->status == "selesai") {
      $konsep_sementara->status_id = 4;
    } else {
      $konsep_sementara->status_id = 5;
      $konsep_sementara->gambar = $request->gambar;
    }
    
    $konsep_sementara->save();

    return response()->json([
      'status' => $request->all()
    ]);
  }

  public function desainUpload($id)
  {
    $konsep_sementara = KonsepSementara::with('customer')->find($id);

    return view('pages.design_offline.desain.upload', ['konsep_sementara' => $konsep_sementara]);
  }
}
