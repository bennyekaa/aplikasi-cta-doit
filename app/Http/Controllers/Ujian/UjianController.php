<?php

namespace App\Http\Controllers\Ujian;

use App\Http\Controllers\Controller;
use App\Models\Master\KategoriSoal;
use Illuminate\Http\Request;

class UjianController extends Controller
{
    public function list(){
        $data['kategori'] = KategoriSoal::all();
        return view('ujian.list', $data);
    }

    public function detail(){
        return view('ujian.detail');
    }

    public function index(){
        return view('ujian.index');
    }
}
