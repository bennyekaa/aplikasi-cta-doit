<?php

namespace App\Http\Controllers\Ujian;

use App\Http\Controllers\Controller;
use App\Models\Data\Ujian;
use App\Models\Master\KategoriSoal;
use App\Models\Master\Soal;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class UjianController extends Controller
{
    public function index()
    {
        return view('ujian.index');
    }

    public function list()
    {
        $data['kategori'] = KategoriSoal::all()->sortByDesc('created_at');
        return view('ujian.list', $data);
    }

    public function detail($id)
    {
        $data['id_kategori'] = $id;
        $data['kategori'] = KategoriSoal::find(decrypt($id));
        // $data['soal'] = Soal::join('ref_kategori', 'ref_kategori.id_kategori', '=', 'ref_soal.id_kategori')->join('ref_modul', 'ref_modul.id_modul','=','ref_soal.id_modul')->where('ref_soal.id_kategori', decrypt($id))->get();
        return view('ujian.detail', $data);
    }

    public function input($id){
        $id_ujian = Str::uuid();
        $soal = Soal::where('id_kategori', decrypt($id))->get();
        $datas = [];
        // dd($hitung-$old_device);
        $ujian = new Ujian();
        $ujian->id_ujian = $id_ujian;
        $ujian->status = 0;
        $ujian->created_at = $this->waktu;
        $ujian->created_by = session('id_user');
        $ujian->save();

        foreach ($soal as $s) {
            $item = [
                'id_jawaban' => (string)Str::uuid(),
                'id_user' => session('id_user'),
                'id_ujian' => $id_ujian,
                'id_soal' => $s->id_soal, // Hubungkan id_soal dengan id soal yang sesuai
                'created_at' => $this->waktu,
                'created_by' => session('id_user'),
            ];
            array_push($datas, $item);
        }
        // dd($datas);
        DB::table('data_riwayat')->insert($datas);
        
        $data['id'] = $id;
        $data['id1'] = 1;
        $data['id2'] = $id_ujian;

        return redirect()->route('ujian.mulai', $data);
    }


    public function mulai($id, $nomor, $id_ujian)
    {
        $data['id_kategori'] = $id;
        $data['id_ujian'] = $id_ujian;
        $data['nomor'] = $nomor;
        session()->put('nomor', $nomor);
        $data['total_nomor'] = Soal::select('id_soal')->where('id_kategori', decrypt($id))->count();
        $data['cari'] = Soal::select('soal')->where('id_kategori', decrypt($id))->where('nomor', $nomor)->first();
        $soal = Soal::where('id_kategori', decrypt($id))->orderBy('nomor')->get();
        $data['daftarsoal'] = $soal->map(function ($item) {
            return [
                'id_soal' => $item->id_soal,
                'nomor_soal' => $item->nomor,
                'poin_a' => $item->poin_a,
                'poin_b' => $item->poin_b,
                'poin_c' => $item->poin_c,
                'poin_d' => $item->poin_d,
                'poin_e' => $item->poin_e,
            ];
        })->toArray();
        // dd($data);
        session()->put('ujian', url()->full());
        return view('ujian.mulai', $data);
    }

    public function jawab($id, $nomor, $jawab, $huruf)
    {
        // $data['jawaban'] = Soal::where('id_kategori', $id)->where('nomor', $nomor)->where($jawab)
    }
}
