<?php

namespace App\Http\Controllers\Beranda;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    public function index()
    {
        if(session('role') == 'ADMIN'){
            return view('beranda.index');
        }else{
            return redirect('ujian/list');
        }
    }
}
