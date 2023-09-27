<?php

namespace App\Http\Controllers\Master\Soal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\SoalImport;
use App\Models\Master\KategoriSoal;
use App\Models\Master\Soal;
use Exception;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class SoalController extends Controller
{
    public function index(){
        $data['soal'] = Soal::all();
        session()->put('soal', url()->full());
        return view('master.soal.index', $data);
    }

    public function add(){
        $data['kategori'] = KategoriSoal::all();
        return view('master.soal.add',$data);
    }

    public function import(Request $request)
    {
        try{
            // dd($request->all());
            // try {

            // linux
            // $path1 = $request->file('data_file')->store('temp');
            // $path = storage_path('app') . '/' . $path1;
            // \Excel::import(new DesaImport, $path);
            $kategori = $request->kategori;
            $file = $request->file('data_file')->getRealPath();
            Excel::import(new SoalImport($kategori), $file);

            return redirect(session('soal'))->with('success', 'Berhasil Import');

                //return redirect(session('desa'))\->with('success', 'Berhasil Import');
            // } catch (Exception $e) {
            //     return redirect(session('desa'))->with('error', $e->getMessage());
            // }
        }catch(Exception $e){
            Log::info('Error ' . $e->getMessage());
        }
    }
}
