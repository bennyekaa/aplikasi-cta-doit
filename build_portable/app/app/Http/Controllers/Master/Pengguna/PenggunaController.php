<?php

namespace App\Http\Controllers\Master\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Master\Pengguna;
use App\Models\Master\Jabatan;
use App\Models\Master\Desa;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PenggunaTemplateExport;
use App\Imports\PenggunaImport;
class PenggunaController extends Controller
{
    public function index(){
        // Eager load jabatan and desa
        $data['pengguna'] = Pengguna::with(['jabatan', 'desa.kecamatan'])->where('role', '<>', 99)->get();
        session()->put('pengguna', url()->full());
        return view('master.pengguna.index', $data);
    }

    public function tambah(){
        $data['jabatan'] = Jabatan::all();
        $data['desa'] = Desa::with('kecamatan')->get();
        return view('master.pengguna.tambah', $data);
    }

    public function edit($id){
        $data['id_user'] = $id;
        $data['pengguna'] = Pengguna::find(decrypt($id));
        $data['jabatan'] = Jabatan::all();
        $data['desa'] = Desa::with('kecamatan')->get();
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

    public function template()
    {
        return Excel::download(new PenggunaTemplateExport, 'Template_Pengguna.xlsx');
    }

    public function import(Request $request)
    {
        try {
            $request->validate([
                'file_excel' => 'required|file'
            ]);

            Excel::import(new PenggunaImport, $request->file('file_excel'));

            return redirect(session('pengguna'))->with('success', 'Data berhasil diimport');
        } catch (Exception $e) {
            Log::info('Error Import: ' . $e->getMessage());
            return redirect(session('pengguna'))->with('error', 'Gagal import data: ' . $e->getMessage());
        }
    }

    public function proses(Request $request){
        try {
            if($request->fungsi == 'Tambah'){
                try {
                    $pengguna = new Pengguna();
                    $pengguna->id_user = Str::uuid();
                    $pengguna->username = $request->username;
                    $pengguna->password = Hash::make($request->password);
                    $pengguna->nama_lengkap = $request->nama_lengkap;
                    $pengguna->id_jabatan = $request->id_jabatan;
                    $pengguna->id_desa = $request->id_desa;
                    $pengguna->role = 1; // Default to Pengguna
                    $pengguna->aktif = 1; // Default to Aktif
                    $pengguna->created_by = session('id_user') ?? 'system';
                    $pengguna->updated_by = session('id_user') ?? 'system';
                    $pengguna->save();
                    return redirect(session('pengguna'))->with('success', 'Tambah Data Berhasil');
                } catch (Exception $e) {
                    Log::info('Error ' . $e->getMessage());
                    return redirect(session('pengguna'));
                }
            }else
            if($request->fungsi == 'Password'){
                try {
                    Pengguna::where('id_user', '=', $request->id_user)->update(['password' => Hash::make($request->password)]);

                    return redirect(session('pengguna'))->with('success', 'Berhasil Reset Password');
                } catch (Exception $e) {
                    Log::info('Error ' . $e->getMessage());
                    return redirect(session('pengguna'));
                }
            }else
            if($request->fungsi == 'Edit'){
                try {
                    $pengguna = Pengguna::find(decrypt($request->id_user));
                    $pengguna->username = $request->username;
                    $pengguna->nama_lengkap = $request->nama_lengkap;
                    $pengguna->id_jabatan = $request->id_jabatan;
                    $pengguna->id_desa = $request->id_desa;
                    $pengguna->save();
                    return redirect(session('pengguna'))->with('success', 'Edit Data Berhasil');
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
