<?php

namespace App\Http\Controllers\Master\Kategori;

use App\Http\Controllers\Controller;
use App\Models\Master\KategoriSoal;
use App\Models\Master\Soal;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class KategoriController extends Controller
{
    public function index(){
        $data['kategori'] = KategoriSoal::all();
        session()->put('kategori', url()->full());
        return view('master.kategori.index', $data);
    }

    public function tambah(){
        return view('master.kategori.add');
    }

    public function edit($id){
        $data['id_kategori'] = $id;
        $data['kategori'] = KategoriSoal::find(decrypt($id));
        return view('master.kategori.edit', $data);
    }

    public function hapus($id){
        try {
            $soal = Soal::where('id_kategori', decrypt($id))->count();
            if ($soal > 0) {
                return redirect(session('kategori'))->with('error', 'Keterangan Sedang Digunakan');
            } else {
                $kategori = KategoriSoal::find(decrypt($id));
                $kategori->delete();
                return redirect(session('kategori'))->with('success', 'Berhasil Hapus');
            }
        } catch (Exception $e) {
            Log::info('Error ' . $e->getMessage());
        }
    }

    public function status($id, $set){
        try {
            $kategori = KategoriSoal::find(decrypt($id));
            $kategori->aktif = $set;
            $kategori->updated_by = session('id_user');
            $kategori->save();
            return redirect(session('kategori'))->with('success', 'Berhasil Ubah Status');
        } catch (Exception $e) {
            Log::info('Error ' . $e->getMessage());
        }
    }

    public function proses(Request $request){
        try {
            if ($request->fungsi == 'Tambah') {
                $kategori = new KategoriSoal();
                $kategori->id_kategori = Str::uuid();
                $kategori->nama_kategori = $request->nama_kategori_soal;
                $kategori->menit = $request->menit;
                $kategori->nilai_total = $request->nilai_total;
                $kategori->keterangan = $request->keterangan;
                $kategori->aktif = 1;
                $kategori->created_at = $this->waktu;
                $kategori->created_by = session('id_user');
                $kategori->save();
                return redirect(session('kategori'))->with('success', 'Berhasil Tambah');
            }else
            if($request->fungsi == 'Edit'){
                $kategori = KategoriSoal::find(decrypt($request->id_kategori));
                $kategori->nama_kategori = $request->nama_kategori;
                $kategori->menit = $request->menit;
                $kategori->nilai_total = $request->nilai_total;
                $kategori->keterangan = $request->keterangan;
                $kategori->aktif = 1;
                $kategori->updated_by = session('id_user');
                $kategori->save();
                return redirect(session('kategori'))->with('success', 'Berhasil Edit');
            }
        } catch (Exception $e) {
            Log::info('Error ' . $e->getMessage());
        }
    }
}
