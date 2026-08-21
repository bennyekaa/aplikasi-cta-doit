<?php

namespace App\Http\Controllers\Beranda;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Master\Pengguna;
use App\Models\Master\Desa;
use App\Models\Master\Kecamatan;
use App\Models\Master\BankSoal;

class BerandaController extends Controller
{
    public function index()
    {
        if(session('role') == 'ADMIN'){
            $data['total_pengguna'] = Pengguna::count();
            $data['total_desa'] = Desa::count();
            $data['total_kecamatan'] = Kecamatan::count();
            $data['total_soal'] = BankSoal::count();
            
            $data['desa'] = Desa::whereNotNull('latitude')->whereNotNull('longitude')->get();
            $data['kecamatan'] = Kecamatan::whereNotNull('latitude')->whereNotNull('longitude')->get();
            
            return view('beranda.index', $data);
        }else{
            return redirect('ujian/list');
        }
    }
}
