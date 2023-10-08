<?php

namespace App\Http\Controllers\Ujian;

use App\Http\Controllers\Controller;
use App\Models\Data\Ujian;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function index(){
        $data['riwayat'] = Ujian::select('*','ref_kategori.nama_kategori','data_ujian.created_at AS ujian_mulai', 'data_ujian.updated_at AS ujian_selesai')->join('data_riwayat', 'data_riwayat.id_ujian', '=', 'data_ujian.id_ujian')->join('ref_soal', 'ref_soal.id_soal', '=', 'data_riwayat.id_soal')->join('ref_kategori', 'ref_kategori.id_kategori', '=', 'ref_soal.id_kategori')->where('data_ujian.status', 2)->where('data_ujian.created_by', session('id_user'))->limit(1)->get();
        return view('ujian.riwayat', $data);
    }
}
