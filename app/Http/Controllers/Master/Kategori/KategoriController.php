<?php

namespace App\Http\Controllers\Master\Kategori;

use App\Http\Controllers\Controller;
use App\Models\Master\KategoriSoal;
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

    }

    public function hapus($id){

    }

    public function status($id, $set){

    }

    public function proses(Request $request){
        try {
            if ($request->fungsi == 'Tambah') {
                $kategori = new KategoriSoal();
                $kategori->id_kategori_soal = Str::uuid();
                $kategori->nama_kategori_soal = $request->nama_kategori_soal;
                $kategori->keterangan = $request->keterangan;
                $kategori->aktif = 1;
                $kategori->created_at = $this->waktu;
                $kategori->created_by = session('id_user');
                $kategori->save();
                return redirect(session('kategori'))->with('success', 'Berhasil Tambah');
            }
        } catch (Exception $e) {
            Log::info('Error ' . $e->getMessage());
        }
    }
}
