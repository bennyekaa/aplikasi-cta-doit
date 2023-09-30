<?php

namespace App\Http\Controllers\Master\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Master\Pengguna;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PenggunaController extends Controller
{
    public function index(){
        $data['pengguna'] = Pengguna::where('role', '<>', 0)->get();
        session()->put('pengguna', url()->full());
        return view('master.pengguna.index', $data);
    }

    public function tambah(){

    }

    public function edit($id){

    }

    public function hapus($id){

    }

    public function status($id, $set){

    }

    public function password($id){

    }

    public function jadwal($id){
        $data['id_user'] = $id;
        return view('master.pengguna.jadwal', $data);
    }

    public function proses(Request $request){
        try {
            if($request->fungsi == 'Jadwal'){
                $pengguna = Pengguna::find(decrypt($request->id_user));
                $pengguna->tanggal_aktif = $request->batas;
                $pengguna->updated_by = session('id_user');
                $pengguna->save();
                return redirect(session('pengguna'))->with('success', 'Atur Jadwal Sukses');
            }
        } catch (Exception $e) {
            Log::info('Error ' . $e->getMessage());
        }
    }
}
