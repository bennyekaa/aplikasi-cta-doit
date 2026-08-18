<?php

namespace App\Http\Controllers\Master\Jabatan;

use App\Http\Controllers\Controller;
use App\Models\Master\Jabatan;
use App\Models\Master\Modul;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class JabatanController extends Controller
{
    public function index()
    {
        $data['jabatan'] = Jabatan::with('modul')->orderBy('id_modul')->get();
        session()->put('jabatan', url()->full());
        return view('master.jabatan.index', $data);
    }

    public function tambah()
    {
        $data['modul'] = Modul::all();
        return view('master.jabatan.tambah', $data);
    }

    public function edit($id)
    {
        $data['id_jabatan'] = $id;
        $data['jabatan'] = Jabatan::find(decrypt($id));
        $data['modul'] = Modul::all();
        return view('master.jabatan.edit', $data);
    }

    public function hapus($id)
    {
        try {
            $jabatan = Jabatan::find(decrypt($id));
            $jabatan->delete();
            return redirect(session('jabatan'))->with('success', 'Berhasil Hapus Data');
        } catch (Exception $e) {
            Log::info('Error ' . $e->getMessage());
            return redirect(session('jabatan'))->with('error', 'Gagal Hapus Data');
        }
    }

    public function proses(Request $request)
    {
        try {
            if ($request->fungsi == 'Tambah') {
                $jabatan = new Jabatan();
                $jabatan->id_jabatan = Str::uuid();
                $jabatan->id_modul = $request->id_modul;
                $jabatan->kode_jabatan = $request->kode_jabatan;
                $jabatan->nama_jabatan = $request->nama_jabatan;
                $jabatan->save();
                return redirect(session('jabatan'))->with('success', 'Berhasil Tambah Data');
            } elseif ($request->fungsi == 'Edit') {
                $jabatan = Jabatan::find(decrypt($request->id_jabatan));
                $jabatan->id_modul = $request->id_modul;
                $jabatan->kode_jabatan = $request->kode_jabatan;
                $jabatan->nama_jabatan = $request->nama_jabatan;
                $jabatan->save();
                return redirect(session('jabatan'))->with('success', 'Berhasil Edit Data');
            }
        } catch (Exception $e) {
            Log::info('Error ' . $e->getMessage());
            return redirect(session('jabatan'))->with('error', 'Gagal Memproses Data');
        }
    }
}
