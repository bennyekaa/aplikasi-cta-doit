<?php

namespace App\Http\Controllers\Ujian;

use App\Http\Controllers\Controller;
use App\Models\Data\Ujian;
use App\Models\Master\Jawaban;
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

    public function input($id)
    {
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
        session()->put('kategori', $id);
        $data['id1'] = 1;
        $data['id2'] = $id_ujian;

        return redirect()->route('ujian.mulai', $data);
    }


    public function mulai($id, $nomor, $id_ujian)
    {
        session()->put('ujian', url()->full());
        session()->put('nomor', $nomor);
        $data['id_kategori'] = $id;
        $data['id_ujian'] = $id_ujian;
        $data['nomor'] = $nomor;
        $data['waktuawal'] = KategoriSoal::where('id_kategori', decrypt($id))->first();
        $data['total_nomor'] = Soal::select('id_soal')->where('id_kategori', decrypt($id))->count();
        $data['cari'] = Soal::select('soal')->where('id_kategori', decrypt($id))->where('nomor', $nomor)->first();
        $soal = Soal::join('data_riwayat', 'data_riwayat.id_soal', '=', 'ref_soal.id_soal')->where('id_kategori', decrypt($id))->where('id_ujian', $id_ujian)->orderBy('nomor')->get();
        $data['daftarsoal'] = $soal->map(function ($item) {
            return [
                'id_soal' => $item->id_soal,
                'nomor_soal' => $item->nomor,
                'poin_a' => $item->poin_a,
                'poin_b' => $item->poin_b,
                'poin_c' => $item->poin_c,
                'poin_d' => $item->poin_d,
                'poin_e' => $item->poin_e,
                'jawaban' => $item->jawaban,
            ];
        })->toArray();

        $ujian = Ujian::find($id_ujian);
        $ujian->status = 1;
        $ujian->updated_by = session('id_user');
        $ujian->save();

        // dd($data);
        return view('ujian.mulai', $data);
    }


    // public function jawab(Request $request)
    // {
    //     $jawab = Jawaban::where('id_soal', decrypt($request->idSekarang))->where('id_ujian', decrypt($request->id_ujian))->first();
    //     $jawab->poin = decrypt($request->poin);
    //     $jawab->jawaban = $request->answer;
    //     $jawab->updated_by = session('id_user');
    //     $jawab->save();
    // }
    public function jawab($id_ujian, $id_soal, $poin, $huruf)
    {
        $jawab = Jawaban::where('id_soal', decrypt($id_soal))->where('id_ujian', decrypt($id_ujian))->first();
        $jawab->poin = decrypt($poin);
        $jawab->jawaban = $huruf;
        $jawab->updated_by = session('id_user');
        $jawab->save();

        return redirect(session('ujian'));
    }

    public function simpanwaktu(Request $request)
    {
        $waktuTersisa = $request->input('waktu_tersisa');
        $id_ujian = $request->input('id_ujian');

        // Simpan waktu yang tersisa ke dalam database, misalnya dalam kolom 'waktu_sisa' di tabel 'ujian'
        // Gantilah ini sesuai dengan nama tabel dan kolom yang Anda gunakan
        DB::table('data_ujian')->where('id_ujian', $id_ujian)->update(['waktu' => $waktuTersisa]);

        // Beri respons yang sesuai jika diperlukan
        return response()->json(['status' => 'Berhasil menyimpan waktu tersisa']);
    }

    public function simpanujian(Request $request)
    {
        $id_ujian = $request->input('id_ujian');

        // Simpan waktu yang tersisa ke dalam database, misalnya dalam kolom 'waktu_sisa' di tabel 'ujian'
        // Gantilah ini sesuai dengan nama tabel dan kolom yang Anda gunakan
        DB::table('data_ujian')->where('id_ujian', $id_ujian)->update(['status' => 2]);

        // Beri respons yang sesuai jika diperlukan
        return response()->json(['status' => 'Berhasil menyimpan ujian']);
    }

    public function getCountdownTime($id_kategori)
    {
        $countdown = KategoriSoal::where('id_kategori', $id_kategori)->first();

        return response()->json([
            'minutes' => $countdown->menit,
            'seconds' => $countdown->detik,
        ]);
    }

    public function updateCountdownTime(Request $request)
    {
        $idUjian = $request->input('id_ujian');
        $minutes = $request->input('minutes');
        $seconds = $request->input('seconds');

        // Perbarui kolom 'menit' dan 'detik' pada model Ujian berdasarkan id_ujian
        Ujian::where('id_ujian', $idUjian)->update(['menit' => $minutes, 'detik' => $seconds]);

        return response()->json(['message' => 'Countdown time updated successfully']);
    }

}
