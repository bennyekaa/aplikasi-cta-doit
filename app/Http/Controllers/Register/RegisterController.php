<?php

namespace App\Http\Controllers\Register;

use App\Http\Controllers\Controller;
use App\Models\Master\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index(){
        return view('register.index');
    }

    public function actionregister(Request $request){
        $pengguna = new Pengguna();
        $pengguna->id_user = Str::uuid();
        $pengguna->username = $request->username;
        $pengguna->nama_lengkap = $request->nama_lengkap;
        $pengguna->telepon = $request->telepon;
        $pengguna->email = $request->email;
        $pengguna->jk = $request->jk;
        $pengguna->alamat = $request->alamat;
        $pengguna->password = Hash::make($request->password);
        $pengguna->created_at = $this->waktu;
        $pengguna->created_by = $pengguna->id_user;
        $pengguna->save();
        return redirect('login')->with('success', 'Silahkan Hubungi WA 08563498050 untuk verifikasi data');
    }
}
