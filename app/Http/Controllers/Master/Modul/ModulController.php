<?php

namespace App\Http\Controllers\Master\Modul;

use App\Http\Controllers\Controller;
use App\Models\Master\Modul;
use App\Models\Master\Soal;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ModulController extends Controller
{
    public function index()
    {
        $data['modul'] = Modul::all();
        session()->put('modul', url()->full());
        return view('master.modul.index', $data);
    }

    public function tambah()
    {
        return view('master.modul.add');
    }

    public function edit($id)
    {
        $data['id_modul'] = $id;
        $data['modul'] = Modul::find(decrypt($id));
        return view('master.modul.edit', $data);
    }

    public function hapus($id)
    {
        try {
            $soal = Soal::where('id_modul', decrypt($id))->count();
            if ($soal > 0) {
                return redirect(session('modul'))->with('error', 'Modul Sedang Digunakan');
            } else {
                $modul = Modul::find(decrypt($id));
                $modul->delete();
                return redirect(session('modul'))->with('success', 'Berhasil Hapus');
            }
        } catch (Exception $e) {
            Log::info('Error ' . $e->getMessage());
        }
    }

    public function status($id, $set)
    {
        try {
            $modul = Modul::find(decrypt($id));
            $modul->aktif = $set;
            $modul->updated_by = session('id_user');
            $modul->save();
            return redirect(session('modul'))->with('success', 'Berhasil Ubah Status');
        } catch (Exception $e) {
            Log::info('Error ' . $e->getMessage());
        }
    }

    public function proses(Request $request)
    {
        try {
            if ($request->fungsi == 'Tambah') {
                $modul = new Modul();
                $modul->nama_modul = $request->nama_modul;
                $modul->waktu = $request->waktu;
                $modul->waktu_mulai = $request->waktu_mulai;
                $modul->jumlah_soal = $request->jumlah_soal;
                $modul->aktif = 1;
                $modul->created_at = $this->waktu;
                $modul->created_by = session('id_user');
                $modul->save();
                return redirect(session('modul'))->with('success', 'Berhasil Tambah');
            } else
            if ($request->fungsi == 'Edit') {
                $modul = Modul::find(decrypt($request->id_modul));
                $modul->nama_modul = $request->nama_modul;
                $modul->waktu = $request->waktu;
                $modul->waktu_mulai = $request->waktu_mulai;
                $modul->jumlah_soal = $request->jumlah_soal;
                $modul->aktif = 1;
                $modul->updated_by = session('id_user');
                $modul->save();
                return redirect(session('modul'))->with('success', 'Berhasil Edit');
            }
        } catch (Exception $e) {
            Log::info('Error ' . $e->getMessage());
        }
    }
}
