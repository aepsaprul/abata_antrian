<?php

namespace App\Http\Controllers;

use App\Models\MasterCustomer;
use App\Models\NavAccess;
use App\Models\NavButton;
use App\Models\NavSub;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index()
    {
        if (Auth::user()->master_karyawan_id != 0) {
            if (Auth::user()->karyawan->master_cabang_id == 1) {
                $customer = MasterCustomer::orderBy('id', 'desc')->limit(1000)->get();
            } else {
                $customer = MasterCustomer::where('master_cabang_id', Auth::user()->karyawan->master_cabang_id)
                    ->orderBy('id', 'desc')
                    ->limit(1000)
                    ->get();
            }
        } else {
            $customer = MasterCustomer::orderBy('id', 'desc')->limit(1000)->get();
        }

        $navigasi = NavAccess::with('navButton')
            ->whereHas('navButton.navSub', function ($query) {
                $query->where('aktif', 'customer');
            })
            ->where('karyawan_id', Auth::user()->master_karyawan_id)->get();

        $data_navigasi = [];
        foreach ($navigasi as $key => $value) {
            $data_navigasi[] = $value->navButton->title;
        }

        return view('pages.customer.index', [
            'customers' => $customer,
            'navigasi' => $navigasi,
            'data_navigasi' => $data_navigasi
        ]);
    }

    public function edit($id)
    {
        $customer = MasterCustomer::find($id);

        return response()->json([
            'customer' => $customer
        ]);
    }

    public function update(Request $request)
    {
        $customer = MasterCustomer::find($request->id);
        $customer->nama_customer = $request->nama;
        $customer->telepon = $request->telepon;
        $customer->save();

        return response()->json([
            'status' => 'true'
        ]);
    }

    public function deleteBtn($id)
    {
        $customer = MasterCustomer::find($id);

        return response()->json([
            'customer' => $customer
        ]);
    }

    public function delete(Request $request)
    {
        $customer = MasterCustomer::find($request->id);
        $customer->delete();

        return response()->json([
            'status' => 'true'
        ]);
    }
}
