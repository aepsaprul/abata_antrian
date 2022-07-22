<?php

namespace App\Http\Controllers;

use App\Models\AntrianPengunjung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.index');
    }

    public function situmpurPengunjung()
    {
        $bulan_sekarang = date("Y-m");

        $pengunjung = AntrianPengunjung::select(DB::raw('count(*) AS total_pengunjung'), DB::raw('DAY(tanggal) AS tanggal_pengunjung'))
            ->where('tanggal', 'like', '%'.$bulan_sekarang.'%')
            ->groupBy('tanggal_pengunjung')
            ->get();

        $tanggal_pengunjung = [];
        $total_pengunjung = [];
        foreach ($pengunjung as $key => $value) {
            $tanggal_pengunjung[] = $value->tanggal_pengunjung;
            $total_pengunjung[] = $value->total_pengunjung;
        }

        return response()->json([
            'tanggal_pengunjung' => $tanggal_pengunjung,
            'total_pengunjung' => $total_pengunjung
        ]);
    }
}
