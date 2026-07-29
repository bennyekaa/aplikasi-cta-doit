<?php

namespace App\Http\Controllers\Register;

use App\Http\Controllers\Controller;
use App\Models\Master\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        $data['instansi'] = $this->pengaturan->instansi;
        session()->put('register', url()->full());
        return view('register.index', $data);
    }

    public function actionregister(Request $request)
    {
        $username = Pengguna::where('username', $request->username)->count();
        $email = Pengguna::where('email', $request->email)->count();
        $hp = Pengguna::where('telepon', $request->telepon)->count();
        if ($username > 0) {
            return redirect('register')->with('error', 'Username Sudah Terdaftar');
        } elseif ($email > 0) {
            return redirect('register')->with('error', 'Email Sudah Terdaftar');
        } elseif ($hp > 0) {
            return redirect('register')->with('error', 'Telepon/HP Sudah Terdaftar');
        } else {
            $pengguna = new Pengguna();
            $pengguna->id_user = Str::uuid();
            $pengguna->username = $request->username;
            $pengguna->nama_lengkap = $request->nama_lengkap;
            $pengguna->telepon = $request->telepon;
            $pengguna->email = $request->email;
            $pengguna->jk = $request->jk;
            $pengguna->alamat = $request->alamat;
            $pengguna->role = 1;
            $pengguna->password = Hash::make($request->password);
            $pengguna->created_at = $this->waktu;
            $pengguna->created_by = $pengguna->id_user;
            $pengguna->save();
            return redirect('login')->with('success', 'Silahkan Hubungi WA '.$this->pengaturan->nomor.' untuk verifikasi data');
        }
    }
}
