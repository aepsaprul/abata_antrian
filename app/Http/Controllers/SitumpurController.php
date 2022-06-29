<?php

namespace App\Http\Controllers;

use App\Models\AntrianSementara;
use App\Models\MasterCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SitumpurController extends Controller
{
    public function customer()
    {
        return view('pages.situmpur.customer');
    }

    public function customerForm($id)
    {
        if ($id == '3') {
            $nomors = AntrianSementara::where('jabatan', 'cs')->where('keterangan', 'simpan')->orderBy('id', 'desc')->first();
            $count_nomor_panggil = count(AntrianSementara::where('jabatan', 'cs')->where('keterangan', 'simpan')->where('status','!=', '0')->get());
            $count_nomor_all = count(AntrianSementara::where('jabatan', 'cs')->where('keterangan', 'simpan')->get());

            return view('pages.situmpur.formCs', [
                'customer_filter_id' => $id,
                'nomors' => $nomors,
                'count_nomor_panggil' => $count_nomor_panggil,
                'count_nomor_all' => $count_nomor_all
            ]);
        } else {
            $nomors = AntrianSementara::where('jabatan', 'desain')->where('keterangan', 'simpan')->orderBy('id', 'desc')->first();
            $count_nomor_panggil = count(AntrianSementara::where('jabatan', 'desain')->where('keterangan', 'simpan')->where('status','!=', '0')->get());
            $count_nomor_all = count(AntrianSementara::where('jabatan', 'desain')->where('keterangan', 'simpan')->get());

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

            $nomor_antrian = $request->nomor_antrian;
            $nama = $request->nama_customer;
            $telepon = $request->telepon;
            $customer_filter_id = $request->customer_filter_id;
            $antrian_total = $request->nomor_antrian;

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
            $antrian_sementara->karyawan_id = Auth::user()->master_karyawan_id;
            $antrian_sementara->cabang_id = Auth::user()->karyawan->master_cabang_id;
            $antrian_sementara->save();

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
}
