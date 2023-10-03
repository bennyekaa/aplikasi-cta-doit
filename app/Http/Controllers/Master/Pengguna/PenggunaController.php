<?php

namespace App\Http\Controllers\Master\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Master\Pengguna;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
        $data['pengguna'] = Pengguna::find(decrypt($id));
        return view('master.pengguna.edit', $data);
    }

    public function hapus($id){
        try {
            $pengguna = Pengguna::find(decrypt($id));
            $pengguna->delete();
            return redirect(session('pengguna'))->with('success', 'Berhasil Hapus');
        } catch (Exception $e) {
            Log::info('Error ' . $e->getMessage());
        }
    }

    public function status($id, $set){

    }

    public function password($id){
        $data['pengguna'] = Pengguna::find(decrypt($id));
        return view('master.pengguna.password', $data);
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
            if($request->fungsi == 'Password'){
                try {
                    Pengguna::where('id_user', '=', $request->id_user)->update(['password' => Hash::make($request->password)]);

                    return redirect(session('pengguna'))->with('success', 'Berhasil Reset Password');
                } catch (Exception $e) {
                    Log::info('Error ' . $e->getMessage());
                    return redirect(session('pengguna'));
                }
            }
        } catch (Exception $e) {
            Log::info('Error ' . $e->getMessage());
        }
    }
}
