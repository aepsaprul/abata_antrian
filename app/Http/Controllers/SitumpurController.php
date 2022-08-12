<?php

namespace App\Http\Controllers;

use App\Events\SitumpurCustomerDesain;
use App\Events\SitumpurCustomerDisplay;
use App\Events\SitumpurDesainPanggil;
use App\Events\SitumpurDesainSelesai;
use App\Events\SitumpurDesainStatus;
use App\Models\AntrianPengunjung;
use App\Models\AntrianSementara;
use App\Models\AntrianUser;
use App\Models\Karyawan;
use App\Models\MasterCustomer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SitumpurController extends Controller
{
    // customer
    public function customer()
    {
        return view('pages.situmpur.customer');
    }

    public function customerForm($id)
    {
        if ($id == '3') {
            $nomors = AntrianSementara::where('jabatan', 'cs')->where('cabang_id', Auth::user()->karyawan->master_cabang_id)->where('keterangan', 'simpan')->orderBy('id', 'desc')->first();
            $count_nomor_panggil = count(AntrianSementara::where('jabatan', 'cs')->where('cabang_id', Auth::user()->karyawan->master_cabang_id)->where('keterangan', 'simpan')->where('status','!=', '0')->get());
            $count_nomor_all = count(AntrianSementara::where('jabatan', 'cs')->where('cabang_id', Auth::user()->karyawan->master_cabang_id)->where('keterangan', 'simpan')->get());

            return view('pages.situmpur.formCs', [
                'customer_filter_id' => $id,
                'nomors' => $nomors,
                'count_nomor_panggil' => $count_nomor_panggil,
                'count_nomor_all' => $count_nomor_all
            ]);
        } else {
            if (Auth::user()->roles == "admin" || Auth::user()->karyawan->master_cabang_id == 1) {
                $nomors = AntrianSementara::where('cabang_id', 1)->orderBy('id', 'desc')->first();
                $count_nomor_panggil = count(AntrianSementara::where('cabang_id', 1)->where('status','!=', '0')->get());
                $count_nomor_all = count(AntrianSementara::where('cabang_id', 1)->get());
            } else {
                $nomors = AntrianSementara::where('cabang_id', Auth::user()->karyawan->master_cabang_id)->orderBy('id', 'desc')->first();
                $count_nomor_panggil = count(AntrianSementara::where('cabang_id', Auth::user()->karyawan->master_cabang_id)->where('status','!=', '0')->get());
                $count_nomor_all = count(AntrianSementara::where('cabang_id', Auth::user()->karyawan->master_cabang_id)->get());
            }

            return view('pages.situmpur.formDesain', [
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

        if (Auth::user()->roles == "admin" || Auth::user()->karyawan->master_cabang_id == 1) {
            $antrian_sementara->cabang_id = 1;
            $cabang_id = 1;
        } else {
            $antrian_sementara->cabang_id = Auth::user()->karyawan->master_cabang_id;
            $cabang_id = Auth::user()->karyawan->master_cabang_id;
        }

        $antrian_sementara->keterangan = "desain";
        $antrian_sementara->save();

        $nomor_antrian = $request->nomor_antrian;
        $nama = $request->nama_customer;
        $telepon = $request->telepon;
        $customer_filter_id = $request->customer_filter_id;
        $total_antrian = count(AntrianSementara::where('cabang_id', $cabang_id)->get());

        event(new SitumpurCustomerDesain($cabang_id, $nomor_antrian, $nama, $telepon, $customer_filter_id));
        event(new SitumpurCustomerDisplay($cabang_id, $total_antrian));

        return redirect()->route('situmpur_customer');
    }

    public function resetAntrian()
    {
        if (Auth::user()->roles == "admin" || Auth::user()->karyawan->master_cabang_id == 1) {
            AntrianSementara::where('cabang_id', 1)->delete();
        } else {
            AntrianSementara::where('cabang_id', Auth::user()->karyawan->master_cabang_id)->delete();
        }

        return redirect()->route('situmpur_customer');
    }

    // desain
    public function desain()
    {
        $antrian_user = AntrianUser::where('karyawan_id', Auth::user()->master_karyawan_id)->first();

        return view('pages.situmpur.desain', ['antrian_user' => $antrian_user]);
    }

    public function desainNomor()
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

        return response()->json([
            'success' => 'Success',
            'data' => $nomors
        ]);
    }

    public function desainOn($id)
    {
        if (Auth::user()->roles == "admin" || Auth::user()->karyawan->master_cabang_id == 1) {
            $cabang_id = 1;
            $desain_nomor = 1;
            $status = "on";
            $nama_desain = Auth::user()->name;
        } else {
            $antrian_user = AntrianUser::where('karyawan_id', $id)->first();
            $antrian_user->status = "on";
            $antrian_user->save();

            $cabang_id = Auth::user()->karyawan->master_cabang_id;
            $desain_nomor = $antrian_user->nomor;
            $status = "on";
            $nama_desain = Auth::user()->karyawan->nama_panggilan;
        }

        event(new SitumpurDesainStatus($cabang_id, $desain_nomor, $status, $nama_desain));

        return redirect()->route('situmpur_desain');
    }

    public function desainOff($id)
    {
        if (Auth::user()->roles == "admin" || Auth::user()->karyawan->master_cabang_id == 1) {
            $cabang_id = 1;
            $desain_nomor = 1;
            $status = "off";
            $nama_desain = "";
        } else {
            $antrian_user = AntrianUser::where('karyawan_id', $id)->first();
            $antrian_user->status = "off";
            $antrian_user->save();

            $cabang_id = Auth::user()->karyawan->master_cabang_id;
            $desain_nomor = $antrian_user->nomor;
            $status = "off";
            $nama_desain = "";
        }

        event(new SitumpurDesainStatus($cabang_id, $desain_nomor, $status, $nama_desain));

        return redirect()->route('situmpur_desain');
    }

    public function desainPanggil($nomor)
    {
        if (Auth::user()->roles == "admin" || Auth::user()->karyawan->master_cabang_id == 1) {
            $karyawan_id = 0;
            $cabang_id = 1;
        } else {
            $karyawan_id = Auth::user()->master_karyawan_id;
            $cabang_id = Auth::user()->karyawan->master_cabang_id;
        }

        $antrian_sementara = AntrianSementara::where('cabang_id', $cabang_id)->where('keterangan', 'desain')->where('nomor_antrian', $nomor)->first();
        $antrian_sementara->status = 1;
        $antrian_sementara->karyawan_id = $karyawan_id;
        $antrian_sementara->cabang_id = $cabang_id;
        $antrian_sementara->save();

        $antrian_user = AntrianUser::where('karyawan_id', Auth::user()->master_karyawan_id)->first();

        if (Auth::user()->roles == "admin" || Auth::user()->karyawan->master_cabang_id == 1) {
            $cabang_id = 1;
            event(new SitumpurDesainPanggil($cabang_id, 1, $nomor));
        } else {
            $cabang_id = Auth::user()->karyawan->master_cabang_id;
            event(new SitumpurDesainPanggil($cabang_id, $antrian_user->nomor, $nomor));
        }

        return redirect()->route('situmpur_desain');
    }

    public function desainUpdate(Request $request)
    {
        if (Auth::user()->roles == "admin" || Auth::user()->karyawan->master_cabang_id == 1) {
            $cabang_id = 1;
        } else {
            $cabang_id = Auth::user()->karyawan->master_cabang_id;
        }

        if ($request->nama_jenis == "desain") {
            $antrian_sementara = AntrianSementara::where('cabang_id', $cabang_id)->where('keterangan', 'desain')->where('nomor_antrian', $request->nomor)->first();
            $antrian_sementara->customer_filter_id = 4;
            $antrian_sementara->save();
        } else {
            $antrian_sementara = AntrianSementara::where('cabang_id', $cabang_id)->where('keterangan', 'desain')->where('nomor_antrian', $request->nomor)->first();
            $antrian_sementara->customer_filter_id = 5;
            $antrian_sementara->save();
        }

        return redirect()->route('situmpur_desain');
    }

    public function desainMulai($nomor)
    {
        if (Auth::user()->roles == "admin" || Auth::user()->karyawan->master_cabang_id == 1) {
            $cabang_id = 1;
            $karyawan_id = 0;
        } else {
            $cabang_id = Auth::user()->karyawan->master_cabang_id;
            $karyawan_id = Auth::user()->master_karyawan_id;
        }

        $antrian_sementara = AntrianSementara::where('cabang_id', $cabang_id)->where('keterangan', 'desain')->where('nomor_antrian', $nomor)->where('status', 1)->first();
        $antrian_sementara->status = 2;
        $antrian_sementara->mulai = Carbon::now();
        $antrian_sementara->karyawan_id = $karyawan_id;
        $antrian_sementara->save();

        return redirect()->route('situmpur_desain');
    }

    // public function desainMulaiCounter(Request $request)
    // {
    //     $dataCounter = AntrianSementara::where('keterangan', 'desain')->where('nomor_antrian', $request->nomor)->first();

    //     return response()->json([
    //         'dataCounter' => $dataCounter
    //     ]);
    // }

    public function desainSelesai($nomor)
    {
        $antrian_user = AntrianUser::where('karyawan_id', Auth::user()->master_karyawan_id)->first();
        $keterangan = "";

        if (Auth::user()->roles == "admin" || Auth::user()->karyawan->master_cabang_id == 1) {
            $karyawan_id = 0;
            $cabang_id = 1;
            $antrian_user_nomor = 1;
        } else {
            $karyawan_id = Auth::user()->master_karyawan_id;
            $cabang_id = Auth::user()->karyawan->master_cabang_id;
            $antrian_user_nomor = $antrian_user->nomor;
        }

        $antrian_sementara = AntrianSementara::where('cabang_id', $cabang_id)->where('keterangan', 'desain')->where('nomor_antrian', $nomor)->where('status', 2)->first();
        $antrian_sementara->status = 3;
        $antrian_sementara->selesai = Carbon::now();
        $antrian_sementara->keterangan = "simpan";
        $antrian_sementara->save();

        $pengunjung = new AntrianPengunjung;
        $pengunjung->nomor_antrian = $nomor;
        $pengunjung->nama_customer = $antrian_sementara->nama_customer;
        $pengunjung->telepon = $antrian_sementara->telepon;
        $pengunjung->customer_filter_id = $antrian_sementara->customer_filter_id;
        $pengunjung->jabatan = "desain";
        $pengunjung->mulai = $antrian_sementara->mulai;
        $pengunjung->selesai = Carbon::now();
        $pengunjung->master_karyawan_id = $karyawan_id;
        $pengunjung->master_cabang_id = $cabang_id;
        $pengunjung->status = 3;
        $pengunjung->tanggal = Carbon::now();
        $pengunjung->save();

        event(new SitumpurDesainSelesai($cabang_id, $antrian_user_nomor, $keterangan));

        return redirect()->route('situmpur_desain');
    }

    public function desainBatal($nomor)
    {
        $antrian_user = AntrianUser::where('karyawan_id', Auth::user()->master_karyawan_id)->first();
        $keterangan = "";

        if (Auth::user()->roles == "admin" || Auth::user()->karyawan->master_cabang_id == 1) {
            $karyawan_id = 0;
            $cabang_id = 1;
            $antrian_user_nomor = 1;
        } else {
            $karyawan_id = Auth::user()->master_karyawan_id;
            $cabang_id = Auth::user()->karyawan->master_cabang_id;
            $antrian_user_nomor = $antrian_user->nomor;
        }

        $antrian_sementara = AntrianSementara::where('cabang_id', $cabang_id)->where('keterangan', 'desain')->where('nomor_antrian', $nomor)->where('status', 1)->first();
        $antrian_sementara->status = 4;
        $antrian_sementara->keterangan = "simpan";
        $antrian_sementara->save();

        $pengunjung = new AntrianPengunjung;
        $pengunjung->nomor_antrian = $nomor;
        $pengunjung->nama_customer = $antrian_sementara->nama_customer;
        $pengunjung->telepon = $antrian_sementara->telepon;
        $pengunjung->customer_filter_id = $antrian_sementara->customer_filter_id;
        $pengunjung->jabatan = "desain";
        $pengunjung->master_karyawan_id = $karyawan_id;
        $pengunjung->master_cabang_id = $cabang_id;
        $pengunjung->status = 4;
        $pengunjung->tanggal = Carbon::now();
        $pengunjung->save();

        event(new SitumpurDesainSelesai($cabang_id, $antrian_user_nomor, $keterangan));

        return redirect()->route('situmpur_desain');
    }

    // display
    public function display()
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

        // dd($antrian_user);

        $data_antrian_terakhir = AntrianSementara::where('keterangan', 'simpan')->where('cabang_id', $cabang_id)->orderBy('id', 'desc')->first();
        if ($data_antrian_terakhir) {
            $antrian_terakhir = $data_antrian_terakhir->nomor_antrian;
        } else {
            $antrian_terakhir = 0;
        }

        $data_total_antrian = AntrianSementara::where('cabang_id', $cabang_id)->orderBy('id', 'desc')->first();
        if ($data_total_antrian) {
            $total_antrian = $data_total_antrian->nomor_antrian;
        } else {
            $total_antrian = 0;
        }

        $antrian_sementara = AntrianSementara::where('keterangan', 'desain')
            ->where('cabang_id', $cabang_id)
            ->where('status', 1)
            ->orWhere('status', 2)
            ->get();

            // dd($antrian_sementara);

        return view('pages.situmpur.display', [
            'antrian_users' => $antrian_user,
            'antrian_terakhir' => $antrian_terakhir,
            'total_antrian' => $total_antrian,
            'antrian_sementaras' => $antrian_sementara
        ]);
    }
}
