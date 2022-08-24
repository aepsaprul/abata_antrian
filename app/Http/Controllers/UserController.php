<?php

namespace App\Http\Controllers;

use App\Models\AntrianUser;
use App\Models\Karyawan;
use App\Models\NavAccess;
use App\Models\NavButton;
use App\Models\NavMain;
use App\Models\NavSub;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // $user = User::with('antrianUser')->orderBy('id', 'desc')->get();
        $user = User::with('antrianUser')->where('master_karyawan_id', '!=', 0)->orderBy('id', 'desc')->get();
        $antrian_user = AntrianUser::get();

        $navigasi = NavAccess::with('navButton')
            ->whereHas('navButton.navSub', function ($query) {
                $query->where('aktif', 'master/user');
            })
            ->where('karyawan_id', Auth::user()->master_karyawan_id)->get();

        $data_navigasi = [];
        foreach ($navigasi as $key => $value) {
            $data_navigasi[] = $value->navButton->title;
        }

        return view('pages.master.user.index', [
            'users' => $user,
            'antrian_users' => $antrian_user,
            'navigasi' => $navigasi,
            'data_navigasi' => $data_navigasi
        ]);
    }

    public function create()
    {
        $karyawan = Karyawan::with(['jabatan', 'cabang'])
            ->where('status', 'Aktif')
            ->orderBy('master_cabang_id')
            ->get();

        return response()->json([
            'karyawans' => $karyawan
        ]);
    }

    public function store(Request $request)
    {
        $data_request = explode("_", $request->nama);
        // $karyawan = Karyawan::find($request->nama);
        $id = $data_request[0];
        $name = $data_request[1];
        $email = $data_request[2];

        $user = User::where('email', $email)->first();

        if ($user) {
            $status = "false";
            $keterangan = "Data Sudah Ada";
        } else {
            $user = new User;
            $user->name = $name;
            $user->email = $email;
            $user->password = Hash::make("abataprinting");
            $user->master_karyawan_id = $id;
            $user->save();

            $antrian_user = new AntrianUser;
            $antrian_user->karyawan_id = $id;
            $antrian_user->save();

            $status = "true";
            $keterangan = "Sukses";
        }

        return response()->json([
            'status' => $status,
            'keterangan' => $keterangan
        ]);
    }

    public function access($id)
    {
        $user = User::find($id);

        $nav_access = NavAccess::where('karyawan_id', $user->master_karyawan_id)->get();

        $nav_button = NavButton::get();
        $nav_sub = NavSub::get();
        $nav_main = NavMain::with(['navSub', 'navSub.navButton', 'navButton'])
            ->get();

        $button = NavButton::with('navSub')
            ->select(DB::raw('count(sub_id) as total'), DB::raw('count(main_id) as mainid'), 'sub_id')
            ->groupBy('sub_id')
            ->get();

        $total_main = NavButton::with('navSub')
            ->select(DB::raw('count(main_id) as total_main'), 'main_id')
            ->groupBy('main_id')
            ->get();

        return response()->json([
            'karyawan_id' => $user->master_karyawan_id,
            'nav_access' => $nav_access,
            'nav_buttons' => $nav_button,
            'buttons' => $button,
            'total_main' => $total_main,
            'nav_subs' => $nav_sub,
            'nav_mains' => $nav_main
        ]);
    }

    public function accessStore(Request $request)
    {
        $nav_access = NavAccess::where('karyawan_id', $request->karyawan_id);

        if ($nav_access) {
            $nav_access->delete();

            foreach ($request->data_navigasi as $key => $value) {
                $nav_access = new NavAccess;
                $nav_access->karyawan_id = $request->karyawan_id;
                $nav_access->nav_button_id = $value;
                $nav_access->save();
            }
        } else {
            foreach ($request->data_navigasi as $key => $value) {
                $nav_access = new NavAccess;
                $nav_access->karyawan_id = $request->karyawan_id;
                $nav_access->nav_button_id = $value;
                $nav_access->save();
            }
        }

        return response()->json([
            'status' => $request->all()
        ]);
    }

    public function edit($id)
    {
        $user = User::find($id);
        $antrian_user = AntrianUser::where('karyawan_id', $user->master_karyawan_id)->first();

        return response()->json([
            'user' => $user,
            'antrian_user' => $antrian_user
        ]);
    }

    public function update(Request $request)
    {
        $user = User::find($request->id);

        $antrian_user = AntrianUser::where('karyawan_id', $user->master_karyawan_id)->first();
        $antrian_user->jabatan = $request->jabatan;
        $antrian_user->nomor = $request->nomor;
        $antrian_user->save();

        return response()->json([
            'status' => 'true'
        ]);
    }

    public function delete(Request $request)
    {
        $user = User::find($request->id);

        $antrian_user = AntrianUser::where('karyawan_id', $user->master_karyawan_id)->first();
        $antrian_user->delete();

        $nav_access = NavAccess::where('karyawan_id', $user->master_karyawan_id);
        $nav_access->delete();

        $user->delete();

        return response()->json([
            'status' => 'true'
        ]);
    }
}
