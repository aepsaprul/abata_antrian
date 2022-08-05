<?php

namespace App\Http\Controllers;

use App\Models\AntrianPengunjung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->roles == "admin" || Auth::user()->karyawan->master_cabang_id == 1) {
            $cabang_id = 1;
        } else {
            $cabang_id = Auth::user()->karyawan->master_cabang_id;
        }

        $customer = AntrianPengunjung::select(DB::raw('nama_customer, telepon'), DB::raw('MAX(tanggal) AS tanggal_terakhir_pengunjung'), DB::raw('count(*) AS total'))
            ->where('master_cabang_id', $cabang_id)
            ->groupBy('nama_customer', 'telepon')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get();

        $customer_terakhir = AntrianPengunjung::where('master_cabang_id', $cabang_id)
            ->orderBy('id', 'desc')
            ->limit(100)
            ->get();

        return view('pages.dashboard.index', ['customer' => $customer, 'customer_terakhir' => $customer_terakhir]);
    }

    public function situmpurPengunjung()
    {
        if (Auth::user()->roles == "admin" || Auth::user()->karyawan->master_cabang_id == 1) {
            $cabang_id = 1;
        } else {
            $cabang_id = Auth::user()->karyawan->master_cabang_id;
        }

        // data pengunjung bulan ini--------------------------------------------------------------------
        $bulan_sekarang = date("Y-m");

        $pengunjung = AntrianPengunjung::select(DB::raw('count(*) AS total_pengunjung'), DB::raw('DAY(tanggal) AS tanggal_pengunjung'))
            ->where('master_cabang_id', $cabang_id)
            ->where('tanggal', 'like', '%'.$bulan_sekarang.'%')
            ->groupBy('tanggal_pengunjung')
            ->get();

        $tanggal_pengunjung = [];
        $total_pengunjung = [];
        foreach ($pengunjung as $key => $value) {
            $tanggal_pengunjung[] = $value->tanggal_pengunjung;
            $total_pengunjung[] = $value->total_pengunjung;
        }

        // data customer yang sering datang berdasarkan shift--------------------------------------------------------------
        $customer_shift_1 = AntrianPengunjung::select(DB::raw('COUNT(HOUR(tanggal)) AS total_pengunjung', 'tanggal'), DB::raw('DAY(tanggal) as tanggal_pengunjung'))
            ->where('master_cabang_id', $cabang_id)
            ->whereBetween(DB::raw('HOUR(tanggal)'), [8,14])
            ->where('tanggal', 'like', '%'.$bulan_sekarang.'%')
            ->groupBy('tanggal_pengunjung')
            ->get();

        $data_customer_shift_1 = [];
        $tanggal_customer_shift_1 = [];
        foreach ($customer_shift_1 as $key => $value) {
            $data_customer_shift_1[] = $value->total_pengunjung;
            $tanggal_customer_shift_1[] = $value->tanggal_pengunjung;
        }

        $customer_shift_2 = AntrianPengunjung::select(DB::raw('COUNT(HOUR(tanggal)) AS total_pengunjung', 'tanggal'), DB::raw('DAY(tanggal) as tanggal_pengunjung'))
            ->where('master_cabang_id', $cabang_id)
            ->whereBetween(DB::raw('HOUR(tanggal)'), [15,21])
            ->where('tanggal', 'like', '%'.$bulan_sekarang.'%')
            ->groupBy('tanggal_pengunjung')
            ->get();

        $data_customer_shift_2 = [];
        foreach ($customer_shift_2 as $key => $value) {
            $data_customer_shift_2[] = $value->total_pengunjung;
        }

        return response()->json([
            'tanggal_pengunjung' => $tanggal_pengunjung,
            'total_pengunjung' => $total_pengunjung,
            'pengunjung_shift_1' => $data_customer_shift_1,
            'tanggal_customer_shift_1' => $tanggal_customer_shift_1,
            'pengunjung_shift_2' => $data_customer_shift_2,
        ]);
    }
}
