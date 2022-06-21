<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user = User::get();

        return view('pages.user.index', ['users' => $user]);
    }

    public function create()
    {
        $karyawan = Karyawan::orderBy('master_cabang_id')->get();

        return response()->json([
            'karyawans' => $karyawan
        ]);
    }

    public function store(Request $request)
    {
        $karyawan = Karyawan::find($request->nama);

        $user = User::where('email', $karyawan->email)->first();

        if ($user) {
            $status = "false";
            $keterangan = "Data Sudah Ada";
        } else {
            $user = new User;
            $user->name = $karyawan->nama_lengkap;
            $user->email = $karyawan->email;
            $user->password = Hash::make("abataprinting");
            $user->master_karyawan_id = $karyawan->id;
            $user->save();

            $status = "true";
            $keterangan = "Sukses";
        }

        return response()->json([
            'status' => $status,
            'keterangan' => $keterangan
        ]);
    }
}
