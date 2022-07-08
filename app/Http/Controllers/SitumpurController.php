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
            $nomors = AntrianSementara::where('cabang_id', Auth::user()->karyawan->master_cabang_id)->where('keterangan', 'desain')->orderBy('id', 'desc')->first();
            $count_nomor_panggil = count(AntrianSementara::where('cabang_id', Auth::user()->karyawan->master_cabang_id)->where('keterangan', 'desain')->where('status','!=', '0')->get());
            $count_nomor_all = count(AntrianSementara::where('cabang_id', Auth::user()->karyawan->master_cabang_id)->where('keterangan', 'desain')->get());

            return view('pages.situmpur.formDesain', [
                'customer_filter_id' => $id,
                'nomors' => $nomors,
                'count_nomor_panggil' => $count_nomor_panggil,
                'count_nomor_all' => $count_nomor_all
            ]);
        }
    }

    public function customerSearch(Request $request) {
        if (Auth::user()->master_karyawan_id != 0) {
            $customers = MasterCustomer::where('telepon', 'like', '%' . $request->value . '%')
                // ->where('master_cabang_id', Auth::user()->karyawan->masterCabang->id)
                ->limit(5)
                ->get();
        } else {
            $customers = MasterCustomer::where('telepon', 'like', '%' . $request->value . '%')
                ->limit(5)
                ->get();
        }

        return response()->json([
            'success' => 'berhasil ambil data',
            'customers' => $customers
        ]);
    }

    public function customerStore(Request $request)
    {
        if (Auth::user()->master_karyawan_id == 0) {
            return redirect()->route('situmpur_customer')->with('error', 'Hanya karyawan cabang yg bisa akses');
        } else {
            $data_customer = count(MasterCustomer::where('telepon', $request->telepon)->get());
            if ($data_customer == 0) {
                $customers = new MasterCustomer;
                $customers->nama_customer = $request->nama_customer;
                $customers->telepon = $request->telepon;
                $customers->master_cabang_id = Auth::user()->karyawan->masterCabang->id;
                $customers->save();
            }

            $antrian_sementara = new AntrianSementara;

            // if ($request->customer_filter_id == '3') {

            //     event(new PbgAntrianCustomerCs($nomor_antrian,$nama,$telepon,$customer_filter_id));
            //     event(new PbgAntrianCustomerDisplayCs($antrian_total));

            //     $antrianNomors = new PbgAntrianCsNomor;

            //     $antrianPengunjung = new AntrianPengunjung;
            //     $antrianPengunjung->jabatan = "cs";

            // } else {

            //     event(new PbgAntrianCustomerDesain($nomor_antrian,$nama,$telepon,$customer_filter_id));
            //     event(new PbgAntrianCustomerDisplayDesain($antrian_total));

            //     $antrianNomors = new PbgAntrianDesainNomor;

            //     $antrianPengunjung = new AntrianPengunjung;
            //     $antrianPengunjung->jabatan = "desain";

            // }

            $antrian_sementara->nomor_antrian = $request->nomor_antrian;
            $antrian_sementara->nama_customer = $request->nama_customer;
            $antrian_sementara->telepon = $request->telepon;
            $antrian_sementara->customer_filter_id = $request->customer_filter_id;
            $antrian_sementara->cabang_id = Auth::user()->karyawan->master_cabang_id;
            $antrian_sementara->keterangan = "desain";
            $antrian_sementara->save();

            $nomor_antrian = $request->nomor_antrian;
            $nama = $request->nama_customer;
            $telepon = $request->telepon;
            $customer_filter_id = $request->customer_filter_id;
            $antrian_menunggu = count(AntrianSementara::where('keterangan', 'desain')->where('cabang_id', 2)->where('status', 0)->get());

            event(new SitumpurCustomerDesain($nomor_antrian,$nama,$telepon,$customer_filter_id));
            event(new SitumpurCustomerDisplay($antrian_menunggu));

            // $antrianPengunjung->nomor_antrian = $request->nomor_antrian;
            // $antrianPengunjung->nama_customer = $request->nama_customer;
            // $antrianPengunjung->telepon = $request->telepon;
            // $antrianPengunjung->customer_filter_id = $request->customer_filter_id;
            // $antrianPengunjung->save();

            // $url = "http://localhost/test/escpos/vendor/mike42/escpos-php/example/barcode.php?nomor_antrian=".$request->nomor_antrian."&sisa_antrian=".$request->sisa_antrian;
            // return Redirect::to($url);
            return redirect()->route('situmpur_customer');
        }
    }

    public function resetAntrian()
    {
        AntrianSementara::truncate();

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
        if (Auth::user()->roles == "admin") {
            $nomors = AntrianSementara::with('karyawan')
                ->where('keterangan', 'desain')
                ->where('cabang_id', 2)
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
        $antrian_user = AntrianUser::where('karyawan_id', $id)->first();
        $antrian_user->status = "on";
        $antrian_user->save();

        $desain_nomor = $antrian_user->nomor;
        $status = "on";
        $nama_desain = Auth::user()->karyawan->nama_panggilan;

        event(new SitumpurDesainStatus($desain_nomor, $status, $nama_desain));


        return redirect()->route('situmpur_desain');
    }

    public function desainOff($id)
    {
        $antrian_user = AntrianUser::where('karyawan_id', $id)->first();
        $antrian_user->status = "off";
        $antrian_user->save();

        $desain_nomor = $antrian_user->nomor;
        $status = "off";
        $nama_desain = "";

        event(new SitumpurDesainStatus($desain_nomor, $status, $nama_desain));

        return redirect()->route('situmpur_desain');
    }

    public function desainPanggil($nomor)
    {
        $antrian_sementara = AntrianSementara::where('keterangan', 'desain')->where('nomor_antrian', $nomor)->first();
        $antrian_sementara->status = 1;
        if (Auth::user()->roles == "admin") {
            $antrian_sementara->karyawan_id = 0;
        } else {
            $antrian_sementara->karyawan_id = Auth::user()->master_karyawan_id;
        }
        $antrian_sementara->save();

        $antrian_user = AntrianUser::where('karyawan_id', Auth::user()->master_karyawan_id)->first();
        $antrian_menunggu = count(AntrianSementara::where('keterangan', 'desain')->where('cabang_id', 2)->where('status', 0)->get());

        if (Auth::user()->roles == "admin") {
            event(new SitumpurDesainPanggil(1, $nomor, $antrian_menunggu));
        } else {
            event(new SitumpurDesainPanggil($antrian_user->nomor, $nomor, $antrian_menunggu));
        }


        return redirect()->route('situmpur_desain');
    }

    public function desainUpdate(Request $request)
    {
        if ($request->nama_jenis == "desain") {
            $antrian_sementara = AntrianSementara::where('keterangan', 'desain')->where('nomor_antrian', $request->nomor)->first();
            $antrian_sementara->customer_filter_id = 4;
            $antrian_sementara->save();
        } else {
            $antrian_sementara = AntrianSementara::where('keterangan', 'desain')->where('nomor_antrian', $request->nomor)->first();
            $antrian_sementara->customer_filter_id = 5;
            $antrian_sementara->save();
        }

        return redirect()->route('situmpur_desain');
    }

    public function desainMulai($nomor)
    {
        $antrian_sementara = AntrianSementara::where('keterangan', 'desain')->where('nomor_antrian', $nomor)->where('status', 1)->first();
        $antrian_sementara->status = 2;
        $antrian_sementara->mulai = Carbon::now();
        if (Auth::user()->roles == "admin") {
            $antrian_sementara->karyawan_id = 0;
        } else {
            $antrian_sementara->karyawan_id = Auth::user()->master_karyawan_id;
        }

        $antrian_sementara->save();

        return redirect()->route('situmpur_desain');
    }

    public function desainMulaiCounter(Request $request)
    {
        $dataCounter = AntrianSementara::where('keterangan', 'desain')->where('nomor_antrian', $request->nomor)->first();

        return response()->json([
            'dataCounter' => $dataCounter
        ]);
    }

    public function desainSelesai($nomor)
    {
        $antrian_sementara = AntrianSementara::where('keterangan', 'desain')->where('nomor_antrian', $nomor)->where('status', 2)->first();
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
        if (Auth::user()->roles == "admin") {
            $pengunjung->master_karyawan_id = 0;
            $pengunjung->master_cabang_id = 2;
        } else {
            $pengunjung->master_karyawan_id = Auth::user()->master_karyawan_id;
            $pengunjung->master_cabang_id = Auth::user()->karyawan->master_cabang_id;
        }
        $pengunjung->status = 3;
        $pengunjung->tanggal = Carbon::now();
        $pengunjung->save();

        $antrian_user = AntrianUser::where('karyawan_id', Auth::user()->master_karyawan_id)->first();
        $keterangan = "-";
        if (Auth::user()->roles == "admin") {
            event(new SitumpurDesainSelesai(1,$keterangan));
        } else {
            event(new SitumpurDesainSelesai($antrian_user->nomor,$keterangan));
        }

        return redirect()->route('situmpur_desain');
    }

    public function desainBatal($nomor)
    {
        $antrian_sementara = AntrianSementara::where('keterangan', 'desain')->where('nomor_antrian', $nomor)->where('status', 1)->first();
        $antrian_sementara->status = 4;
        $antrian_sementara->keterangan = "simpan";
        $antrian_sementara->save();

        $pengunjung = new AntrianPengunjung;
        $pengunjung->nomor_antrian = $nomor;
        $pengunjung->nama_customer = $antrian_sementara->nama_customer;
        $pengunjung->telepon = $antrian_sementara->telepon;
        $pengunjung->customer_filter_id = $antrian_sementara->customer_filter_id;
        $pengunjung->jabatan = "desain";
        if (Auth::user()->roles == "admin") {
            $pengunjung->master_karyawan_id = 0;
            $pengunjung->master_cabang_id = 2;
        } else {
            $pengunjung->master_karyawan_id = Auth::user()->master_karyawan_id;
            $pengunjung->master_cabang_id = Auth::user()->karyawan->master_cabang_id;
        }
        $pengunjung->status = 4;
        $pengunjung->tanggal = Carbon::now();
        $pengunjung->save();

        return redirect()->route('situmpur_desain');
    }

    // display
    public function display()
    {
        $antrian_user = AntrianUser::with(['karyawan' => function ($query) {
            $query->where('master_cabang_id', 2);
        }])
        ->where('jabatan', 'desain')
        ->get();

        $antrian_terakhir = AntrianSementara::where('keterangan', 'desain')->where('status', 1)->orderBy('id', 'desc')->first();
        $antrian_menunggu = count(AntrianSementara::where('keterangan', 'desain')->where('cabang_id', 2)->where('status', 0)->get());
        $antrian_sementara = AntrianSementara::where('keterangan', 'desain')
            ->where('cabang_id', 2)
            ->where('status', 1)
            ->orWhere('status', 2)
            ->get();

            // dd($antrian_sementara);

        return view('pages.situmpur.display', [
            'antrian_users' => $antrian_user,
            'antrian_terakhir' => $antrian_terakhir,
            'antrian_menunggu' => $antrian_menunggu,
            'antrian_sementaras' => $antrian_sementara
        ]);
    }
}
