<?php

namespace App\Http\Controllers\Ujian;

use App\Http\Controllers\Controller;
use App\Models\Data\Ujian;
use App\Models\Master\KategoriSoal;
use App\Models\Master\Modul;
use App\Models\Master\Soal;
use Illuminate\Http\Request;
use DB;

class RiwayatController extends Controller
{
    public function index()
    {
        session()->put('riwayat', url()->full());
        $data['riwayat'] = Ujian::select('data_ujian.id_ujian AS id_ujian', 'ref_kategori.id_kategori', 'ref_kategori.nama_kategori', 'data_ujian.created_at AS ujian_mulai', 'data_ujian.updated_at AS ujian_selesai')->join('data_riwayat', 'data_riwayat.id_ujian', '=', 'data_ujian.id_ujian')->join('ref_soal', 'ref_soal.id_soal', '=', 'data_riwayat.id_soal')->join('ref_kategori', 'ref_kategori.id_kategori', '=', 'ref_soal.id_kategori')->where('data_ujian.status', 2)->where('data_ujian.created_by', session('id_user'))->groupBy('data_ujian.id_ujian')->groupBy('ref_kategori.id_kategori')->groupBy('ref_kategori.nama_kategori')->groupBy('data_ujian.created_at')->groupBy('data_ujian.updated_at')->get();
        // dd($data);
        return view('ujian.riwayat', $data);
    }

    public function detail($id_ujian, $id_kategori)
    {
        session()->put('detail_riwayat', url()->full());
        $data['id_ujian'] = $id_ujian;
        $data['id_kategori'] = $id_kategori;
        $data['total'] = DB::select("select SUM(poin) as jumlah FROM data_riwayat WHERE id_ujian = '" . decrypt($id_ujian) . "' AND id_user = '" . session('id_user') . "'");
        $data['kategori'] =  KategoriSoal::where('id_kategori', decrypt($id_kategori))->first();
        $data['kelompok_nilai'] = DB::select("SELECT
                                                ref_modul.nama_modul,
                                                ref_modul.passing_grade,
                                                SUM( poin ) AS jumlah
                                            FROM
                                                data_riwayat
                                                INNER JOIN ref_soal ON ref_soal.id_soal = data_riwayat.id_soal
                                                INNER JOIN ref_modul ON ref_modul.id_modul = ref_soal.id_modul
                                            WHERE
                                                id_user = '" . session('id_user') . "'
                                                AND id_ujian = '" . decrypt($id_ujian) . "'
                                            GROUP BY
                                                ref_soal.id_modul,
                                                ref_modul.nama_modul,
                                                ref_modul.passing_grade");
                                                    // dd($data);
        return view('ujian.detail_riwayat', $data);
    }

    public function pembahasan($id_ujian, $nomor, $id)
    {
        session()->put('ujian', url()->full());
        session()->put('nomor', $nomor);
        $data['nomor'] = $nomor;
        $data['id_kategori'] = $id;
        $data['total_nomor'] = Soal::select('id_soal')->where('id_kategori', decrypt($id))->count();
        $data['cari'] = Soal::select('soal', 'pembahasan')->where('id_kategori', decrypt($id))->where('nomor', $nomor)->first();
        $soal = Soal::join('data_riwayat', 'data_riwayat.id_soal', '=', 'ref_soal.id_soal')->where('id_kategori', decrypt($id))->where('id_ujian', $id_ujian)->orderBy('nomor')->get();
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
                'poin' => $item->poin,
            ];
        })->toArray();
        // dd($data);
        return view('ujian.pembahasan', $data);
    }
}
