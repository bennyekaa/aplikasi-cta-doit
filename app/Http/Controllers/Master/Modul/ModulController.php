<?php

namespace App\Http\Controllers\Master\Modul;

use App\Http\Controllers\Controller;
use App\Models\Master\Modul;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ModulController extends Controller
{
    public function index(){
        $data['modul'] = Modul::all();
        session()->put('modul', url()->full());
        return view('master.modul.index', $data);
    }

    public function tambah(){
        return view('master.modul.add');
    }

    public function edit($id){

    }

    public function hapus($id){

    }

    public function status($id,$set){

    }

    public function proses(Request $request){
        try {
            if($request->fungsi == 'Tambah'){
                $modul = new Modul();
                $modul->nama_modul = $request->nama_modul;
                $modul->keterangan = $request->keterangan;
                $modul->aktif = 1;
                $modul->created_at = $this->waktu;
                $modul->created_by = session('id_user');
                $modul->save();
                return redirect(session('modul'))->with('success', 'Berhasil Tambah');
            }
        } catch (Exception $e) {
            Log::info('Error ' . $e->getMessage());
        }
    }
}
