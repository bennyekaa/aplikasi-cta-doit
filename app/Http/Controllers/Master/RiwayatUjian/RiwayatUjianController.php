<?php

namespace App\Http\Controllers\Master\RiwayatUjian;

use App\Http\Controllers\Controller;
use App\Models\Data\UserExam;
use App\Models\Data\UserExamAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RiwayatUjianController extends Controller
{
    public function index()
    {
        // Join with users and modul
        $exams = UserExam::join('ref_user', 'user_exams.id_user', '=', DB::raw('ref_user.id_user COLLATE utf8mb4_unicode_ci'))
            ->join('ref_modul', 'user_exams.id_modul', '=', DB::raw('ref_modul.id_modul COLLATE utf8mb4_unicode_ci'))
            ->select('user_exams.*', 'ref_user.nama_lengkap as nama_peserta', 'ref_user.username', 'ref_modul.nama_modul')
            ->orderBy('user_exams.created_at', 'desc')
            ->get();
            
        $data['exams'] = $exams;
        return view('master.riwayat_ujian.index', $data);
    }

    public function detail($id)
    {
        $id_exam = decrypt($id);
        $exam = UserExam::join('ref_user', 'user_exams.id_user', '=', DB::raw('ref_user.id_user COLLATE utf8mb4_unicode_ci'))
            ->join('ref_modul', 'user_exams.id_modul', '=', DB::raw('ref_modul.id_modul COLLATE utf8mb4_unicode_ci'))
            ->select('user_exams.*', 'ref_user.nama_lengkap as nama_peserta', 'ref_user.username', 'ref_modul.nama_modul')
            ->where('user_exams.id', $id_exam)
            ->first();

        if (!$exam) {
            return redirect('master/riwayat_ujian/index')->with('error', 'Data tidak ditemukan.');
        }

        $answers = UserExamAnswer::join('bank_soal', 'user_exam_answers.id_soal', '=', 'bank_soal.id')
            ->where('user_exam_answers.user_exam_id', $id_exam)
            ->select('user_exam_answers.*', 'bank_soal.soal', 'bank_soal.opsi_a', 'bank_soal.opsi_b', 'bank_soal.opsi_c', 'bank_soal.opsi_d', 'bank_soal.opsi_e', 'bank_soal.kunci')
            ->orderBy('user_exam_answers.nomor_soal', 'asc')
            ->get();

        $data['exam'] = $exam;
        $data['answers'] = $answers;

        return view('master.riwayat_ujian.detail', $data);
    }

    public function cetak($id)
    {
        $id_exam = decrypt($id);
        $exam = UserExam::join('ref_user', 'user_exams.id_user', '=', DB::raw('ref_user.id_user COLLATE utf8mb4_unicode_ci'))
            ->join('ref_modul', 'user_exams.id_modul', '=', DB::raw('ref_modul.id_modul COLLATE utf8mb4_unicode_ci'))
            ->select('user_exams.*', 'ref_user.nama_lengkap as nama_peserta', 'ref_user.username', 'ref_modul.nama_modul')
            ->where('user_exams.id', $id_exam)
            ->first();

        if (!$exam) {
            return redirect('master/riwayat_ujian/index')->with('error', 'Data tidak ditemukan.');
        }

        $answers = UserExamAnswer::join('bank_soal', 'user_exam_answers.id_soal', '=', 'bank_soal.id')
            ->where('user_exam_answers.user_exam_id', $id_exam)
            ->select('user_exam_answers.*', 'bank_soal.soal', 'bank_soal.opsi_a', 'bank_soal.opsi_b', 'bank_soal.opsi_c', 'bank_soal.opsi_d', 'bank_soal.opsi_e', 'bank_soal.kunci')
            ->orderBy('user_exam_answers.nomor_soal', 'asc')
            ->get();

        $data['exam'] = $exam;
        $data['answers'] = $answers;

        return view('master.riwayat_ujian.cetak', $data);
    }
}
