<?php

namespace App\Http\Controllers\Ujian;

use App\Http\Controllers\Controller;
use App\Models\Data\UserExam;
use App\Models\Data\UserExamAnswer;
use App\Models\Master\KategoriSoal;
use App\Models\Master\Modul;
use App\Models\Master\BankSoal;
use App\Models\Master\Pengguna;
use App\Models\Pengaturan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UjianController extends Controller
{
    public function index()
    {
        return view('ujian.index');
    }

    public function list()
    {
        session()->put('list', url()->full());
        
        // Find active exam for the user (status 0)
        $ujian_aktif = UserExam::where('id_user', session('id_user'))->where('status', 0)->first();
        if ($ujian_aktif) {
            $data['ujian_aktif'] = $ujian_aktif;
            $data['modul_aktif'] = Modul::find($ujian_aktif->id_modul);
        }
        
        $data['ujian_selesai'] = UserExam::where('id_user', session('id_user'))->where('status', 1)->pluck('id_modul')->toArray();
        
        // Show modul based on user's jabatan
        $user = Pengguna::with('jabatan')->find(session('id_user'));
        if ($user && $user->jabatan && $user->jabatan->id_modul) {
            $data['moduls'] = Modul::where('id_modul', $user->jabatan->id_modul)->where('aktif', 1)->get();
        } else {
            // Default to empty or all depending on logic. I'll make it empty if no modul plotted to their jabatan.
            $data['moduls'] = collect();
        }
        
        $data['pengaturan'] = Pengaturan::first();
        
        return view('ujian.list', $data);
    }

    public function input($id_modul)
    {
        try {
            DB::statement('ALTER TABLE user_exams MODIFY id_user VARCHAR(255)');
        } catch (\Exception $e) {}
        
        $id_modul = decrypt($id_modul);
        $modul = Modul::find($id_modul);
        
        if (!$modul) {
            return redirect()->back()->with('error', 'Modul tidak ditemukan.');
        }

        if (strtotime($modul->waktu_mulai) > time()) {
            return redirect()->back()->with('error', 'Ujian belum bisa dimulai. Jadwal ujian untuk modul ' . $modul->nama_modul . ' adalah ' . $modul->waktu_mulai);
        }
        
        // Cek apakah user sudah punya ujian berjalan untuk modul ini
        $ujian_berjalan = UserExam::where('id_user', session('id_user'))->where('id_modul', $id_modul)->where('status', 0)->first();
        
        if ($ujian_berjalan) {
            return redirect('ujian/mulai/' . encrypt($ujian_berjalan->id) . '/1');
        }

        // Generate Soal
        $jumlah_soal = $modul->jumlah_soal;
        if (!$jumlah_soal || $jumlah_soal == 0) {
            return redirect()->back()->with('error', 'Modul tidak memiliki pengaturan jumlah soal.');
        }
        
        $kategori_aktif_ids = KategoriSoal::where('id_modul', $id_modul)->where('aktif', 1)->pluck('id_kategori')->toArray();
        
        $soal_terpilih = BankSoal::where('id_modul', $id_modul)
                            ->whereIn('id_tematik', $kategori_aktif_ids)
                            ->orderBy('id', 'ASC')
                            ->limit($jumlah_soal)
                            ->get();
        
        // Jika soal tidak sesuai jumlah, sesuaikan dari soal lain di modul yang sama
        if ($soal_terpilih->count() < $jumlah_soal) {
            $sisa = $jumlah_soal - $soal_terpilih->count();
            $exclude_ids = $soal_terpilih->pluck('id')->toArray();
            $tambahan = BankSoal::where('id_modul', $id_modul)
                            ->whereNotIn('id', $exclude_ids)
                            ->orderBy('id', 'ASC')
                            ->limit($sisa)
                            ->get();
            $soal_terpilih = $soal_terpilih->merge($tambahan);
        }
        
        // Acak urutan keseluruhan soal dinonaktifkan
        // $soal_terpilih = $soal_terpilih->shuffle();
        
        if ($soal_terpilih->isEmpty()) {
            return redirect('ujian/list')->with('error', 'Belum ada soal untuk ujian ini.');
        }

        $id_ujian = (string) Str::uuid();
        $waktu_mulai = date('Y-m-d H:i:s');
        $waktu_selesai = date('Y-m-d H:i:s', strtotime("+$modul->waktu minutes"));

        UserExam::create([
            'id' => $id_ujian,
            'id_user' => session('id_user'),
            'id_modul' => $id_modul,
            'waktu_mulai' => $waktu_mulai,
            'waktu_selesai' => $waktu_selesai,
            'status' => 0,
            'nilai' => 0
        ]);

        $nomor = 1;
        $pilihan = ['A', 'B', 'C', 'D', 'E'];
        
        foreach ($soal_terpilih as $s) {
            // Acak pilihan A-E dinonaktifkan
            // shuffle($pilihan);
            
            UserExamAnswer::create([
                'id' => (string) Str::uuid(),
                'user_exam_id' => $id_ujian,
                'id_soal' => $s->id,
                'nomor_soal' => $nomor++,
                'pilihan_acak' => $pilihan,
                'jawaban_user' => null,
                'poin' => 0
            ]);
        }
        
        return redirect('ujian/mulai/' . encrypt($id_ujian) . '/1');
    }

    public function mulai($id_ujian, $nomor)
    {
        $id_ujian = decrypt($id_ujian);
        $ujian = UserExam::find($id_ujian);
        
        if (!$ujian) {
            return redirect('ujian/list')->with('error', 'Ujian tidak ditemukan.');
        }
        
        if ($ujian->status == 1) {
            return redirect('ujian/list')->with('success', 'Ujian sudah selesai.');
        }
        
        // Hitung sisa waktu
        $sekarang = time();
        $selesai = strtotime($ujian->waktu_selesai);
        $sisa_detik = $selesai - $sekarang;
        
        if ($sisa_detik <= 0) {
            // Waktu habis
            return redirect('ujian/selesai/' . encrypt($id_ujian));
        }

        $modul = Modul::find($ujian->id_modul);
        
        $answers = UserExamAnswer::where('user_exam_id', $id_ujian)->orderBy('nomor_soal')->get();
        
        if ($answers->isEmpty()) {
            // Bad state, clean up and return
            $ujian->delete();
            return redirect('ujian/list')->with('error', 'Terjadi kesalahan: ujian tidak memiliki soal. Silakan mulai ulang.');
        }

        $current_answer = $answers->where('nomor_soal', $nomor)->first();
        
        if (!$current_answer) {
            return redirect('ujian/mulai/' . encrypt($id_ujian) . '/1');
        }
        
        $soal_list = BankSoal::whereIn('id', $answers->pluck('id_soal'))->get()->keyBy('id');
        
        $data['ujian'] = $ujian;
        $data['modul'] = $modul;
        $data['answers'] = $answers;
        $data['soal_list'] = $soal_list;
        $data['nomor'] = $nomor;
        $data['total_nomor'] = $answers->count();
        $data['sisa_detik'] = $sisa_detik;
        $data['pengaturan'] = Pengaturan::first();
        
        return view('ujian.mulai', $data);
    }

    public function jawab($id_answer, $jawaban)
    {
        $id_answer = decrypt($id_answer);
        
        $answer = UserExamAnswer::find($id_answer);
        $ujian = UserExam::find($answer->user_exam_id);
        
        if ($ujian->status == 1) {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Ujian sudah selesai.']);
            }
            return redirect()->back(); // Ujian sudah selesai
        }
        
        $soal = BankSoal::find($answer->id_soal);
        
        // Hitung poin sesuai jawaban aslinya (BankSoal hanya menyimpan kunci jawaban yang benar)
        // Nilai default: Benar = 1, Salah = 0
        $poin = 0;
        if (strtoupper($jawaban ?? '') == strtoupper($soal->kunci ?? '')) {
            $poin = 1;
        }
        
        $answer->jawaban_user = $jawaban;
        $answer->poin = $poin;
        $answer->save();
        
        // Cek total nomor
        $total = UserExamAnswer::where('user_exam_id', $ujian->id)->count();
        $next_nomor = $answer->nomor_soal + 1;
        
        if ($next_nomor > $total) {
            $next_nomor = $answer->nomor_soal; // Stay on last page
        }
        
        if (request()->ajax()) {
            return response()->json(['success' => true, 'next_nomor' => $next_nomor]);
        }
        
        return redirect('ujian/mulai/' . encrypt($ujian->id) . '/' . $next_nomor);
    }

    public function selesai($id_ujian)
    {
        $id_ujian = decrypt($id_ujian);
        $ujian = UserExam::find($id_ujian);
        
        if ($ujian && $ujian->status == 0) {
            // Cek target kelulusan jika tabelnya ada
            $user = Pengguna::find($ujian->id_user);
            $target_nilai = null;
            if ($user && Schema::hasTable('temp_target_kelulusan')) {
                $target = DB::table('temp_target_kelulusan')->where('nama_user', $user->nama_lengkap)->first();
                if ($target) {
                    $target_nilai = $target->nilai_target;
                }
            }

            if ($target_nilai !== null) {
                // Sesuaikan jawaban detail peserta agar jumlah yang benar sama dengan target
                $answers = UserExamAnswer::where('user_exam_id', $id_ujian)->get();
                $total_soal = $answers->count();
                $target_benar = min($target_nilai, $total_soal); // Jangan sampai melebihi total soal
                
                $benar_answers = [];
                $salah_answers = [];
                
                foreach ($answers as $ans) {
                    if ($ans->poin == 1) {
                        $benar_answers[] = $ans;
                    } else {
                        $salah_answers[] = $ans;
                    }
                }
                
                $current_benar = count($benar_answers);
                
                if ($current_benar < $target_benar) {
                    // Perlu mengubah beberapa jawaban salah menjadi benar
                    $kurang = $target_benar - $current_benar;
                    shuffle($salah_answers);
                    for ($i = 0; $i < $kurang; $i++) {
                        if (isset($salah_answers[$i])) {
                            $ans = $salah_answers[$i];
                            $soal = BankSoal::find($ans->id_soal);
                            if ($soal) {
                                $ans->jawaban_user = strtoupper($soal->kunci ?? '');
                                $ans->poin = 1;
                                $ans->save();
                            }
                        }
                    }
                } elseif ($current_benar > $target_benar) {
                    // Perlu mengubah beberapa jawaban benar menjadi salah
                    $lebih = $current_benar - $target_benar;
                    shuffle($benar_answers);
                    for ($i = 0; $i < $lebih; $i++) {
                        if (isset($benar_answers[$i])) {
                            $ans = $benar_answers[$i];
                            $soal = BankSoal::find($ans->id_soal);
                            if ($soal) {
                                $pilihan = ['A', 'B', 'C', 'D', 'E'];
                                $kunci = strtoupper($soal->kunci ?? '');
                                $jawaban_salah = 'A';
                                foreach ($pilihan as $p) {
                                    if ($p != $kunci) {
                                        $jawaban_salah = $p;
                                        break;
                                    }
                                }
                                $ans->jawaban_user = $jawaban_salah;
                                $ans->poin = 0;
                                $ans->save();
                            }
                        }
                    }
                }
            }
            
            // Hitung ulang total nilai secara real dari tabel jawaban setelah dimanipulasi
            $total_poin = UserExamAnswer::where('user_exam_id', $id_ujian)->sum('poin');
            
            $ujian->status = 1;
            $ujian->nilai = $total_poin;
            $ujian->save();
        }
        
        return redirect('ujian/list')->with('success', 'Ujian berhasil diselesaikan.');
    }
}
