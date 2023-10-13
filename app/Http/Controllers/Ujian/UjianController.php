<?php

namespace App\Http\Controllers\Ujian;

use App\Http\Controllers\Controller;
use App\Models\Data\Ujian;
use App\Models\Master\Jawaban;
use App\Models\Master\KategoriSoal;
use App\Models\Master\Soal;
use Carbon\Carbon;
use DateInterval;
use DateTime;
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
        session()->put('list', url()->full());
        $data['kategori'] = KategoriSoal::all()->sortByDesc('created_at');
        $data['ujian_aktif'] = Ujian::join('data_riwayat', 'data_riwayat.id_ujian', '=', 'data_ujian.id_ujian')->join('ref_soal', 'ref_soal.id_soal', '=', 'data_riwayat.id_soal')->join('ref_kategori', 'ref_kategori.id_kategori', '=', 'ref_soal.id_kategori')->where('data_ujian.created_by', session('id_user'))->where('data_ujian.status', 1)->first();
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
        $ujian->created_at = now()->format('Y-m-d H:i:s.u');
        // $ujian->created_at = date('Y-m-d H:i:s.U');
        $ujian->created_by = session('id_user');
        // $ujian->updated_at = now()->format('Y-m-d H:i:s.u');
        // $ujian->updated_by = session('id_user');
        $ujian->save();

        foreach ($soal as $s) {
            $item = [
                'id_jawaban' => (string)Str::uuid(),
                'id_user' => session('id_user'),
                'id_ujian' => $id_ujian,
                'id_soal' => $s->id_soal, // Hubungkan id_soal dengan id soal yang sesuai
                'created_at' => date('Y-m-d H:i:s.U'),
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

        // return view('ujian.mulai', $data);
        return redirect()->route('ujian.mulai', $data);
    }


    public function mulai($id, $nomor, $id_ujian)
    {
        session()->put('ujian', url()->full());
        session()->put('nomor', $nomor);
        $data['nomor'] = $nomor;
        $data['id_kategori'] = $id;
        $data['total_nomor'] = Soal::select('id_soal')->where('id_kategori', decrypt($id))->count();
        $data['cari'] = Soal::select('soal')->where('id_kategori', decrypt($id))->where('nomor', $nomor)->first();
        $soal = Soal::join('data_riwayat', 'data_riwayat.id_soal', '=', 'ref_soal.id_soal')->where('id_kategori', decrypt($id))->where('id_ujian', $id_ujian)->orderBy('nomor')->get();

        $data['waktumulai'] = Ujian::where('id_ujian', $id_ujian)->first();

        // if (session('ujian') == 'ada') {
        //     $waktumulai = $data['waktumulai']->created_at;
        //     $waktuupdate = $data['waktumulai']->updated_at;

        //     $waktuObjekAwal = \DateTime::createFromFormat('Y-m-d H:i:s', $waktumulai);
        //     $waktuObjekSelesai = clone $waktuObjekAwal;
        //     $waktuObjekSelesai->add(new \DateInterval('PT110M')); // Tambahkan 110 menit

        //     $data['mulai'] = $waktuObjekAwal->format('H:i:s'); // Format waktu mulai
        //     $data['selesai'] = $waktuObjekSelesai->format('H:i:s'); // Format waktu selesai

        //     // Hitung selisih waktu antara waktu selesai dan waktu saat ini
        //     $waktuSaatIni = now();
        //     $selisih = $waktuSaatIni->diff($waktuObjekSelesai);

        //     // Ambil selisih dalam menit
        //     $data['selisih_menit_1'] = $selisih->days * 24 * 60 + $selisih->h * 60 + $selisih->i;

        //     // Ambil selisih dalam detik
        //     $data['selisih_detik_1'] = $selisih->days * 24 * 60 * 60 + $selisih->h * 60 * 60 + $selisih->i * 60 + $selisih->s;

        //     // Hitung sisa waktu terakhir dengan mempertimbangkan updated_at
        //     $waktuObjekUpdate = \DateTime::createFromFormat('Y-m-d H:i:s', $waktuupdate);
        //     $selisihTerakhir = $waktuObjekSelesai->getTimestamp() - $waktuObjekUpdate->getTimestamp();
        //     $data['sisa_waktu_terakhir'] = 110 * 60 - $selisihTerakhir;

        //     // Hitung sisa waktu terakhir dalam menit
        //     $data['selisih_menit'] = floor($data['sisa_waktu_terakhir'] / 60);

        //     // Hitung sisa waktu terakhir dalam detik
        //     $data['selisih_detik'] = $data['sisa_waktu_terakhir'] % 60;
        // } else {
            if ($data['waktumulai']) {
                $waktumulai = $data['waktumulai']->created_at;
                $waktuObjekAwal = \DateTime::createFromFormat('Y-m-d H:i:s', $waktumulai);
                $waktuObjekSelesai = clone $waktuObjekAwal;
                $waktuObjekSelesai->add(new \DateInterval('PT110M')); // Tambahkan 110 menit

                $data['mulai'] = $waktuObjekAwal->format('H:i:s'); // Format waktu mulai
                $data['selesai'] = $waktuObjekSelesai->format('H:i:s'); // Format waktu selesai

            // Hitung selisih waktu antara waktu selesai dan waktu saat ini
                date_default_timezone_set('Asia/Jakarta');
                $waktuSaatIni = now();
                $selisih = $waktuSaatIni->diff($waktuObjekSelesai);

                // Ambil selisih dalam menit
                $data['selisih_menit'] = $selisih->days * 24 * 60 + $selisih->h * 60 + $selisih->i;

                // Ambil selisih dalam detik
                $data['selisih_detik'] = $selisih->days * 24 * 60 * 60 + $selisih->h * 60 * 60 + $selisih->i * 60 + $selisih->s;
            }
        // }

        $data['id_ujian'] = $id_ujian;
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

        // dd($data);
        $ujian = Ujian::find($id_ujian);
        $ujian->status = 1;
        $ujian->updated_by = session('id_user');
        $ujian->updated_at = $this->waktu;
        // $ujian->updated_at = date('Y-m-d H:i:s.U');
        $ujian->save();
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
        $ujian = Ujian::find(decrypt($id_ujian));
        $ujian->updated_by = session('id_user');
        $ujian->updated_at = date('Y-m-d H:i:s.U');
        $jawab->jawaban = $huruf;
        $jawab->updated_by = session('id_user');
        $jawab->updated_at = date('Y-m-d H:i:s.U');
        $jawab->save();
        $ujian->save();

        return redirect(session('ujian'));
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

    public function selesai($idUjian)
    {
        $ujian = Ujian::find($idUjian);
        $ujian->status = 2;
        $ujian->updated_at = date('Y-m-d H:i:s.U');
        $ujian->updated_by = session('id_user');
        $ujian->save();
        session()->put('ujian', 'kosong');

        return redirect(url('ujian/list'));
    }

    public function updatewaktu(Request $request)
    {
        $id_ujian = $request->input('id_ujian');

        DB::table('data_ujian')->where('id_ujian', $id_ujian)->update(['updated_at' => date('Y-m-d H:i:s.U'),  'updated_by' => session('id_user')]);

        // Beri respons yang sesuai jika diperlukan
        return response()->json(['status' => 'Berhasil menyimpan ujian']);
    }
}
