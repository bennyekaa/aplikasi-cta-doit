<?php

namespace App\Http\Controllers\Ujian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UjianController extends Controller
{
    public function index(){
        return view('ujian.index');
    }
}
