<?php

namespace App\Http\Controllers;

use App\Events\EventCsPanggil;
use App\Events\EventCsSelesai;
use App\Events\EventCsStatus;
use App\Events\EventCsToDesain;
use App\Events\EventCsToDesainPanggil;
use App\Events\EventCustomerDesain;
use App\Events\EventCustomerDisplay;
use App\Events\EventDesainPanggil;
use App\Events\EventDesainSelesai;
use App\Events\EventDesainStatus;
use App\Models\AntrianPengunjung;
use App\Models\AntrianSementara;
use App\Models\AntrianUser;
use App\Models\MasterCustomer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AntrianController extends Controller
{
    // customer
    public function customer()
    {
        return view('pages.antrian.customer');
    }

    public function customerPbg()
    {
        return view('pages.antrian.customerPbg');
    }

    public function customerForm($id)
    {
        if ($id == '3') {
            if (Auth::user()->roles == "admin" || Auth::user()->karyawan->master_cabang_id == 1) {
                $nomors = AntrianSementara::where('cabang_id', 1)->where('jabatan', 'cs')->where('keterangan', '!=', 'desain')->orderBy('id', 'desc')->first();
                $count_nomor_panggil = count(AntrianSementara::where('cabang_id', 1)->where('jabatan', 'cs')->where('keterangan', '!=', 'desain')->where('status','!=', '0')->get());
                $count_nomor_all = count(AntrianSementara::where('cabang_id', 1)->where('jabatan', 'cs')->where('keterangan', '!=', 'desain')->get());
            } else {
                $nomors = AntrianSementara::where('cabang_id', Auth::user()->karyawan->master_cabang_id)->where('jabatan', 'cs')->where('keterangan', '!=', 'desain')->orderBy('id', 'desc')->first();
                $count_nomor_panggil = count(AntrianSementara::where('cabang_id', Auth::user()->karyawan->master_cabang_id)->where('jabatan', 'cs')->where('keterangan', '!=', 'desain')->where('status','!=', '0')->get());
                $count_nomor_all = count(AntrianSementara::where('cabang_id', Auth::user()->karyawan->master_cabang_id)->where('jabatan', 'cs')->where('keterangan', '!=', 'desain')->get());
            }
            return view('pages.antrian.formCs', [
                'customer_filter_id' => $id,
                'nomors' => $nomors,
                'count_nomor_panggil' => $count_nomor_panggil,
                'count_nomor_all' => $count_nomor_all
            ]);
        } else {
            if (Auth::user()->roles == "admin" || Auth::user()->karyawan->master_cabang_id == 1) {
                $nomors = AntrianSementara::where('cabang_id', 1)->where('jabatan', 'desain')->where('keterangan', '!=', 'cs')->orderBy('id', 'desc')->first();
                $count_nomor_panggil = count(AntrianSementara::where('cabang_id', 1)->where('jabatan', 'desain')->where('keterangan', '!=', 'cs')->where('status','!=', '0')->get());
                $count_nomor_all = count(AntrianSementara::where('cabang_id', 1)->where('jabatan', 'desain')->where('keterangan', '!=', 'cs')->get());
            } else {
                $nomors = AntrianSementara::where('cabang_id', Auth::user()->karyawan->master_cabang_id)->where('jabatan', 'desain')->where('keterangan', '!=', 'cs')->orderBy('id', 'desc')->first();
                $count_nomor_panggil = count(AntrianSementara::where('cabang_id', Auth::user()->karyawan->master_cabang_id)->where('jabatan', 'desain')->where('keterangan', '!=', 'cs')->where('status','!=', '0')->get());
                $count_nomor_all = count(AntrianSementara::where('cabang_id', Auth::user()->karyawan->master_cabang_id)->where('jabatan', 'desain')->where('keterangan', '!=', 'cs')->get());
            }

            return view('pages.antrian.formDesain', [
                'customer_filter_id' => $id,
                'nomors' => $nomors,
                'count_nomor_panggil' => $count_nomor_panggil,
                'count_nomor_all' => $count_nomor_all
            ]);
        }
    }

    public function customerFormPbg($id)
    {
        if ($id == '3') {
            if (Auth::user()->roles == "admin" || Auth::user()->karyawan->master_cabang_id == 1) {
                $nomors = AntrianSementara::where('cabang_id', 1)->where('jabatan', 'cs')->where('keterangan', '!=', 'desain')->orderBy('id', 'desc')->first();
                $count_nomor_panggil = count(AntrianSementara::where('cabang_id', 1)->where('jabatan', 'cs')->where('keterangan', '!=', 'desain')->where('status','!=', '0')->get());
                $count_nomor_all = count(AntrianSementara::where('cabang_id', 1)->where('jabatan', 'cs')->where('keterangan', '!=', 'desain')->get());
            } else {
                $nomors = AntrianSementara::where('cabang_id', Auth::user()->karyawan->master_cabang_id)->where('jabatan', 'cs')->where('keterangan', '!=', 'desain')->orderBy('id', 'desc')->first();
                $count_nomor_panggil = count(AntrianSementara::where('cabang_id', Auth::user()->karyawan->master_cabang_id)->where('jabatan', 'cs')->where('keterangan', '!=', 'desain')->where('status','!=', '0')->get());
                $count_nomor_all = count(AntrianSementara::where('cabang_id', Auth::user()->karyawan->master_cabang_id)->where('jabatan', 'cs')->where('keterangan', '!=', 'desain')->get());
            }
            return view('pages.antrian.formCsPbg', [
                'customer_filter_id' => $id,
                'nomors' => $nomors,
                'count_nomor_panggil' => $count_nomor_panggil,
                'count_nomor_all' => $count_nomor_all
            ]);
        } else {
            if (Auth::user()->roles == "admin" || Auth::user()->karyawan->master_cabang_id == 1) {
                $nomors = AntrianSementara::where('cabang_id', 1)->where('jabatan', 'desain')->where('keterangan', '!=', 'cs')->orderBy('id', 'desc')->first();
                $count_nomor_panggil = count(AntrianSementara::where('cabang_id', 1)->where('jabatan', 'desain')->where('keterangan', '!=', 'cs')->where('status','!=', '0')->get());
                $count_nomor_all = count(AntrianSementara::where('cabang_id', 1)->where('jabatan', 'desain')->where('keterangan', '!=', 'cs')->get());
            } else {
                $nomors = AntrianSementara::where('cabang_id', Auth::user()->karyawan->master_cabang_id)->where('jabatan', 'desain')->where('keterangan', '!=', 'cs')->orderBy('id', 'desc')->first();
                $count_nomor_panggil = count(AntrianSementara::where('cabang_id', Auth::user()->karyawan->master_cabang_id)->where('jabatan', 'desain')->where('keterangan', '!=', 'cs')->where('status','!=', '0')->get());
                $count_nomor_all = count(AntrianSementara::where('cabang_id', Auth::user()->karyawan->master_cabang_id)->where('jabatan', 'desain')->where('keterangan', '!=', 'cs')->get());
            }

            return view('pages.antrian.formDesainPbg', [
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
        $sisa_antrian = $request->sisa_antrian;

        if (Auth::user()->roles == "admin" || Auth::user()->karyawan->master_cabang_id == 1) {
            $antrian_sementara->cabang_id = 1;
            $cabang_id = 1;
        } else {
            $antrian_sementara->cabang_id = Auth::user()->karyawan->master_cabang_id;
            $cabang_id = Auth::user()->karyawan->master_cabang_id;
        }

        if ($request->customer_filter_id == '3') {
            $antrian_sementara->jabatan = "cs";
            $antrian_sementara->keterangan = "cs";
            $nomor_antrian_e = "C" . $request->nomor_antrian;
        } else {
            $antrian_sementara->jabatan = "desain";
            $antrian_sementara->keterangan = "desain";
            $nomor_antrian_e = "D" . $request->nomor_antrian;
        }

        $antrian_sementara->save();

        $nomor_antrian = $request->nomor_antrian;
        $nama = $request->nama_customer;
        $telepon = $request->telepon;
        $customer_filter_id = $request->customer_filter_id;

        if ($request->customer_filter_id == '3') {
            $total_antrian = count(AntrianSementara::where('cabang_id', $cabang_id)->where('jabatan', 'cs')->get());
        } else {
            $total_antrian = count(AntrianSementara::where('cabang_id', $cabang_id)->where('jabatan', 'desain')->get());
        }

        event(new EventCustomerDesain($cabang_id, $nomor_antrian, $nama, $telepon, $customer_filter_id));
        event(new EventCustomerDisplay($cabang_id, $total_antrian, $customer_filter_id));

        if (Auth::user()->karyawan) {
          if (Auth::user()->karyawan->master_cabang_id == 5) {
            // $url = "http://localhost/test/escpos/vendor/mike42/escpos-php/example/barcode.php?nomor_antrian=".$request->nomor_antrian."&sisa_antrian=".$request->sisa_antrian;
            $url = "http://localhost/posprint/vendor/mike42/escpos-php/example/barcode.php?nomor_antrian=" . $nomor_antrian_e . "&sisa_antrian=" . $sisa_antrian;
            return Redirect::to($url);
          }
        } else {
            return redirect()->route('antrian_customer');
        }
    }

    public function resetAntrian()
    {
        if (Auth::user()->roles == "admin" || Auth::user()->karyawan->master_cabang_id == 1) {
            AntrianSementara::where('cabang_id', 1)->delete();
        } else {
            AntrianSementara::where('cabang_id', Auth::user()->karyawan->master_cabang_id)->delete();
        }

        if (Auth::user()->karyawan->master_cabang_id == 5) {
            return redirect()->route('antrian_cs');
        } else {
            return redirect()->route('antrian_customer');
        }
    }

    // cs
    public function cs()
    {
        $antrian_user = AntrianUser::where('karyawan_id', Auth::user()->master_karyawan_id)->first();

        return view('pages.antrian.cs', ['antrian_user' => $antrian_user]);
    }

    public function csNomor()
    {
        if (Auth::user()->roles == "admin" || Auth::user()->karyawan->master_cabang_id == 1) {
            $nomors = AntrianSementara::with('karyawan')
                ->where('keterangan', 'cs')
                ->where('cabang_id', 1)
                ->where('status', '!=', '3')
                ->get();
        } else {
            $nomors = AntrianSementara::with('karyawan')
                ->where('keterangan', 'cs')
                ->where('cabang_id', Auth::user()->karyawan->master_cabang_id)
                ->where('status', '!=', '3')
                ->get();
        }

        return response()->json([
            'success' => 'Success',
            'data' => $nomors
        ]);
    }

    public function csStatus($id, $status)
    {
        if ($status == "on") {
            if (Auth::user()->roles == "admin" || Auth::user()->karyawan->master_cabang_id == 1) {
                $cabang_id = 1;
                $status = "on";
                $nama_cs = Auth::user()->name;
            } else {
                $antrian_user = AntrianUser::where('karyawan_id', $id)->first();
                $antrian_user->status = "on";
                $antrian_user->save();

                $cabang_id = Auth::user()->karyawan->master_cabang_id;
                $status = "on";
                $nama_cs = Auth::user()->karyawan->nama_panggilan;
            }
        } else {
            if (Auth::user()->roles == "admin" || Auth::user()->karyawan->master_cabang_id == 1) {
                $cabang_id = 1;
                $status = "off";
                $nama_cs = "";
            } else {
                $antrian_user = AntrianUser::where('karyawan_id', $id)->first();
                $antrian_user->status = "off";
                $antrian_user->save();

                $cabang_id = Auth::user()->karyawan->master_cabang_id;
                $status = "off";
                $nama_cs = "";
            }
        }

        event(new EventCsStatus($cabang_id, $status, $nama_cs));

        return redirect()->route('antrian_cs');
    }

    public function csPanggil($nomor)
    {
        if (Auth::user()->roles == "admin" || Auth::user()->karyawan->master_cabang_id == 1) {
            $karyawan_id = 0;
            $cabang_id = 1;
        } else {
            $karyawan_id = Auth::user()->master_karyawan_id;
            $cabang_id = Auth::user()->karyawan->master_cabang_id;
        }

        $antrian_sementara = AntrianSementara::where('cabang_id', $cabang_id)->where('keterangan', 'cs')->where('nomor_antrian', $nomor)->first();
        $antrian_sementara->status = 1;
        $antrian_sementara->karyawan_id = $karyawan_id;
        $antrian_sementara->cabang_id = $cabang_id;
        $antrian_sementara->save();

        if (Auth::user()->roles == "admin" || Auth::user()->karyawan->master_cabang_id == 1) {
            $cabang_id = 1;
            event(new EventCsPanggil($cabang_id, $nomor));
        } else {
            $cabang_id = Auth::user()->karyawan->master_cabang_id;
            event(new EventCsPanggil($cabang_id, $nomor));
        }

        return redirect()->route('antrian_cs');
    }

    public function csMulai($nomor)
    {
        if (Auth::user()->roles == "admin" || Auth::user()->karyawan->master_cabang_id == 1) {
            $cabang_id = 1;
            $karyawan_id = 0;
        } else {
            $cabang_id = Auth::user()->karyawan->master_cabang_id;
            $karyawan_id = Auth::user()->master_karyawan_id;
        }

        $antrian_sementara = AntrianSementara::where('cabang_id', $cabang_id)->where('keterangan', 'cs')->where('nomor_antrian', $nomor)->where('status', 1)->first();
        $antrian_sementara->status = 2;
        $antrian_sementara->mulai = Carbon::now();
        $antrian_sementara->karyawan_id = $karyawan_id;
        $antrian_sementara->save();

        return redirect()->route('antrian_cs');
    }

    public function csSelesai($nomor)
    {
        $antrian_user = AntrianUser::where('karyawan_id', Auth::user()->master_karyawan_id)->first();
        $keterangan = "";

        if (Auth::user()->roles == "admin" || Auth::user()->karyawan->master_cabang_id == 1) {
            $karyawan_id = 0;
            $cabang_id = 1;
        } else {
            $karyawan_id = Auth::user()->master_karyawan_id;
            $cabang_id = Auth::user()->karyawan->master_cabang_id;
        }

        $antrian_sementara = AntrianSementara::where('cabang_id', $cabang_id)->where('keterangan', 'cs')->where('nomor_antrian', $nomor)->where('status', 2)->first();
        $antrian_sementara->status = 3;
        $antrian_sementara->selesai = Carbon::now();
        $antrian_sementara->keterangan = "simpan";
        $antrian_sementara->save();

        $pengunjung = new AntrianPengunjung;
        $pengunjung->nomor_antrian = $nomor;
        $pengunjung->nama_customer = $antrian_sementara->nama_customer;
        $pengunjung->telepon = $antrian_sementara->telepon;
        $pengunjung->customer_filter_id = $antrian_sementara->customer_filter_id;
        $pengunjung->jabatan = "cs";
        $pengunjung->mulai = $antrian_sementara->mulai;
        $pengunjung->selesai = Carbon::now();
        $pengunjung->master_karyawan_id = $karyawan_id;
        $pengunjung->master_cabang_id = $cabang_id;
        $pengunjung->status = 3;
        $pengunjung->tanggal = Carbon::now();
        $pengunjung->save();

        event(new EventCsSelesai($cabang_id, $keterangan));

        return redirect()->route('antrian_cs');
    }

    public function csBatal($nomor)
    {
        $keterangan = "";

        if (Auth::user()->roles == "admin" || Auth::user()->karyawan->master_cabang_id == 1) {
            $karyawan_id = 0;
            $cabang_id = 1;
        } else {
            $karyawan_id = Auth::user()->master_karyawan_id;
            $cabang_id = Auth::user()->karyawan->master_cabang_id;
        }

        $antrian_sementara = AntrianSementara::where('cabang_id', $cabang_id)->where('keterangan', 'cs')->where('nomor_antrian', $nomor)->where('status', 1)->first();
        $antrian_sementara->status = 4;
        $antrian_sementara->keterangan = "simpan";
        $antrian_sementara->save();

        $pengunjung = new AntrianPengunjung;
        $pengunjung->nomor_antrian = $nomor;
        $pengunjung->nama_customer = $antrian_sementara->nama_customer;
        $pengunjung->telepon = $antrian_sementara->telepon;
        $pengunjung->customer_filter_id = $antrian_sementara->customer_filter_id;
        $pengunjung->jabatan = "cs";
        $pengunjung->master_karyawan_id = $karyawan_id;
        $pengunjung->master_cabang_id = $cabang_id;
        $pengunjung->status = 4;
        $pengunjung->tanggal = Carbon::now();
        $pengunjung->save();

        event(new EventCsSelesai($cabang_id, $keterangan));

        return redirect()->route('antrian_cs');
    }

    public function csPindah($nomor)
    {
        $keterangan = "";

        if (Auth::user()->roles == "admin" || Auth::user()->karyawan->master_cabang_id == 1) {
            $karyawan_id = 0;
            $cabang_id = 1;
        } else {
            $karyawan_id = Auth::user()->master_karyawan_id;
            $cabang_id = Auth::user()->karyawan->master_cabang_id;
        }

        $antrian_sementara = AntrianSementara::where('cabang_id', $cabang_id)->where('keterangan', 'cs')->where('nomor_antrian', $nomor)->where('status', 2)->first();
        $antrian_sementara->status = 0;
        $antrian_sementara->selesai = Carbon::now();
        $antrian_sementara->keterangan = "cs_to_desain";
        $antrian_sementara->save();

        event(new EventCsSelesai($cabang_id, $keterangan));
        event(new EventCsToDesain($cabang_id, $nomor));

        return redirect()->route('antrian_cs');
    }

    // desain
    public function desain()
    {
        $antrian_user = AntrianUser::where('karyawan_id', Auth::user()->master_karyawan_id)->first();

        return view('pages.antrian.desain', ['antrian_user' => $antrian_user]);
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

    public function desainStatus($id, $status)
    {
        if (Auth::user()->roles == "admin" || Auth::user()->karyawan->master_cabang_id == 1) {
            $cabang_id = 1;
            $desain_nomor = 1;
            $nama_desain = Auth::user()->name;
        } else {
            $antrian_user = AntrianUser::where('karyawan_id', $id)->first();
            if ($status == "on") {
                $antrian_user->status = "on";
            } else {
                $antrian_user->status = "off";
            }
            $antrian_user->save();

            $cabang_id = Auth::user()->karyawan->master_cabang_id;
            $desain_nomor = $antrian_user->nomor;
            $nama_desain = Auth::user()->karyawan->nama_panggilan;
        }

        event(new EventDesainStatus($cabang_id, $desain_nomor, $status, $nama_desain));

        return redirect()->route('antrian_desain');
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
            event(new EventDesainPanggil($cabang_id, 1, $nomor));
        } else {
            $cabang_id = Auth::user()->karyawan->master_cabang_id;
            event(new EventDesainPanggil($cabang_id, $antrian_user->nomor, $nomor));
        }

        return redirect()->route('antrian_desain');
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

        return redirect()->route('antrian_desain');
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

        return redirect()->route('antrian_desain');
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

        event(new EventDesainSelesai($cabang_id, $antrian_user_nomor, $keterangan));

        return redirect()->route('antrian_desain');
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

        event(new EventDesainSelesai($cabang_id, $antrian_user_nomor, $keterangan));

        return redirect()->route('antrian_desain');
    }

    // display
    public function display()
    {
        if (Auth::user()->roles == "admin" || Auth::user()->karyawan->master_cabang_id == 1) {
            $cabang_id = 1;
            $total_antrian = count(AntrianSementara::where('cabang_id', $cabang_id)->orderBy('id', 'desc')->get());
            $total_antrian_cs = 0;
        } else {
            $cabang_id = Auth::user()->karyawan->master_cabang_id;

            if ($cabang_id == 5) {
                $total_antrian = count(AntrianSementara::where('cabang_id', $cabang_id)->where('jabatan', 'desain')->orderBy('id', 'desc')->get());
                $total_antrian_cs = count(AntrianSementara::where('cabang_id', $cabang_id)->where('jabatan', 'cs')->orderBy('id', 'desc')->get());
            } else {
                $total_antrian = count(AntrianSementara::where('cabang_id', $cabang_id)->orderBy('id', 'desc')->get());
                $total_antrian_cs = 0;
            }
        }

        $antrian_user = AntrianUser::with('karyawan')
        ->where('jabatan', 'desain')
        ->orderBy('nomor', 'asc')
        ->get();

        $antrian_user_cs = AntrianUser::with('karyawan')
        ->where('jabatan', 'cs')
        ->first();


        $data_antrian_terakhir = AntrianSementara::where('keterangan', 'simpan')->where('jabatan', 'desain')->where('cabang_id', $cabang_id)->orderBy('id', 'desc')->first();
        if ($data_antrian_terakhir) {
            $antrian_terakhir = $data_antrian_terakhir->nomor_antrian;
        } else {
            $antrian_terakhir = 0;
        }

        $data_antrian_terakhir_cs = AntrianSementara::where('keterangan', 'simpan')->where('jabatan', 'cs')->where('cabang_id', $cabang_id)->orderBy('id', 'desc')->first();
        if ($data_antrian_terakhir_cs) {
            $antrian_terakhir_cs = $data_antrian_terakhir_cs->nomor_antrian;
        } else {
            $antrian_terakhir_cs = 0;
        }

        $antrian_sementara = AntrianSementara::where('keterangan', 'desain')
            ->where('cabang_id', $cabang_id)
            ->where('status', 1)
            ->orWhere('status', 2)
            ->get();

        $antrian_sementara_cs = AntrianSementara::where('keterangan', 'cs')
            ->where('cabang_id', $cabang_id)
            ->where('status', 1)
            ->orWhere('status', 2)
            ->get();

        return view('pages.antrian.display', [
            'antrian_users' => $antrian_user,
            'antrian_user_cs' => $antrian_user_cs,
            'antrian_terakhir' => $antrian_terakhir,
            'antrian_terakhir_cs' => $antrian_terakhir_cs,
            'total_antrian' => $total_antrian,
            'total_antrian_cs' => $total_antrian_cs,
            'antrian_sementaras' => $antrian_sementara,
            'antrian_sementara_cs' => $antrian_sementara_cs
        ]);
    }

    // cs to desain
    public function csToDesainNomor()
    {
        if (Auth::user()->roles == "admin" || Auth::user()->karyawan->master_cabang_id == 1) {
            $nomors = AntrianSementara::with('karyawan')
                ->where('keterangan', 'cs_to_desain')
                ->where('cabang_id', 1)
                ->where('status', '!=', '3')
                ->get();
        } else {
            $nomors = AntrianSementara::with('karyawan')
                ->where('keterangan', 'cs_to_desain')
                ->where('cabang_id', Auth::user()->karyawan->master_cabang_id)
                ->where('status', '!=', '3')
                ->get();
        }

        return response()->json([
            'success' => 'Success',
            'data' => $nomors
        ]);
    }

    public function csToDesainPanggil($nomor)
    {
        if (Auth::user()->roles == "admin" || Auth::user()->karyawan->master_cabang_id == 1) {
            $karyawan_id = 0;
            $cabang_id = 1;
        } else {
            $karyawan_id = Auth::user()->master_karyawan_id;
            $cabang_id = Auth::user()->karyawan->master_cabang_id;
        }

        $antrian_sementara = AntrianSementara::where('cabang_id', $cabang_id)->where('keterangan', 'cs_to_desain')->where('nomor_antrian', $nomor)->first();
        $antrian_sementara->status = 1;
        $antrian_sementara->karyawan_id = $karyawan_id;
        $antrian_sementara->cabang_id = $cabang_id;
        $antrian_sementara->save();

        $antrian_user = AntrianUser::where('karyawan_id', Auth::user()->master_karyawan_id)->first();

        if (Auth::user()->roles == "admin" || Auth::user()->karyawan->master_cabang_id == 1) {
            $cabang_id = 1;
            event(new EventCsToDesainPanggil($cabang_id, 1, $nomor));
        } else {
            $cabang_id = Auth::user()->karyawan->master_cabang_id;
            event(new EventCsToDesainPanggil($cabang_id, $antrian_user->nomor, $nomor));
        }

        return redirect()->route('antrian_desain');
    }

    public function csToDesainMulai($nomor)
    {
        if (Auth::user()->roles == "admin" || Auth::user()->karyawan->master_cabang_id == 1) {
            $cabang_id = 1;
            $karyawan_id = 0;
        } else {
            $cabang_id = Auth::user()->karyawan->master_cabang_id;
            $karyawan_id = Auth::user()->master_karyawan_id;
        }

        $antrian_sementara = AntrianSementara::where('cabang_id', $cabang_id)->where('keterangan', 'cs_to_desain')->where('nomor_antrian', $nomor)->where('status', 1)->first();
        $antrian_sementara->status = 2;
        $antrian_sementara->mulai = Carbon::now();
        $antrian_sementara->karyawan_id = $karyawan_id;
        $antrian_sementara->save();

        return redirect()->route('antrian_desain');
    }

    public function csToDesainSelesai($nomor)
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

        $antrian_sementara = AntrianSementara::where('cabang_id', $cabang_id)->where('keterangan', 'cs_to_desain')->where('nomor_antrian', $nomor)->where('status', 2)->first();
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

        event(new EventDesainSelesai($cabang_id, $antrian_user_nomor, $keterangan));

        return redirect()->route('antrian_desain');
    }

    public function csToDesainBatal($nomor)
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

        $antrian_sementara = AntrianSementara::where('cabang_id', $cabang_id)->where('keterangan', 'cs_to_desain')->where('nomor_antrian', $nomor)->where('status', 1)->first();
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

        event(new EventDesainSelesai($cabang_id, $antrian_user_nomor, $keterangan));

        return redirect()->route('antrian_desain');
    }
}
