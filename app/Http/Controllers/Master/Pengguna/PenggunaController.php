<?php

namespace App\Http\Controllers\Master\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Master\Pengguna;
use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    public function index(){
        $data['pengguna'] = Pengguna::where('username', '<>', 'admin')->get();
        return view('master.pengguna.index', $data);
    }

    public function jadwal($id){
        $data['id_user'] = $id;
        return view('master.pengguna.jadwal', $data);
    }
}
