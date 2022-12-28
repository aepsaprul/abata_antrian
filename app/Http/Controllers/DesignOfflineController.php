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
    $konsep_sementara->status_id = 1;
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

  public function desainUpload()
  {
    return view('pages.design_offline.desain.upload');
  }
}
