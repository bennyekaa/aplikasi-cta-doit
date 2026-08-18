@extends('layout.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Detail Riwayat Ujian</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title font-weight-bold">Informasi Peserta</h3>
                                <div class="card-tools">
                                    <a href="{{ url('master/riwayat_ujian/cetak/' . encrypt($exam->id)) }}" target="_blank" class="btn btn-sm btn-secondary"><i class="fas fa-print"></i> Cetak</a>
                                    <a href="{{ url('master/riwayat_ujian/index') }}" class="btn btn-sm btn-danger"><i class="fas fa-arrow-left"></i> Kembali</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-sm table-borderless">
                                            <tr><th width="150">Nama Peserta</th><td>: {{ $exam->nama_peserta }}</td></tr>
                                            <tr><th>Username</th><td>: {{ $exam->username }}</td></tr>
                                            <tr><th>Modul Ujian</th><td>: {{ $exam->nama_modul }}</td></tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-sm table-borderless">
                                            <tr><th width="150">Waktu Mulai</th><td>: {{ $exam->waktu_mulai ? date('d M Y H:i:s', strtotime($exam->waktu_mulai)) : '-' }}</td></tr>
                                            <tr><th>Waktu Selesai</th><td>: {{ $exam->waktu_selesai ? date('d M Y H:i:s', strtotime($exam->waktu_selesai)) : '-' }}</td></tr>
                                            <tr><th>Nilai Akhir</th><td>: <span class="badge badge-success" style="font-size: 1rem;">{{ $exam->nilai ?? 0 }}</span></td></tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h3 class="card-title font-weight-bold text-white">Hasil Koreksi Jawaban</h3>
                            </div>
                            <div class="card-body">
                                @php $label_huruf = ['A', 'B', 'C', 'D', 'E']; @endphp
                                @foreach($answers as $ans)
                                    <div class="mb-4 p-3 border rounded">
                                        <div class="font-weight-bold mb-2">
                                            <span class="badge badge-primary">Soal No. {{ $ans->nomor_soal }}</span>
                                            @if($ans->jawaban_user == $ans->kunci)
                                                <span class="badge badge-success"><i class="fas fa-check"></i> Benar</span>
                                            @else
                                                <span class="badge badge-danger"><i class="fas fa-times"></i> Salah</span>
                                            @endif
                                        </div>
                                        <!-- Soal hidden to prevent leaking -->

                                            @php 
                                                $index_huruf = 0;
                                                $jawaban_peserta_huruf = '-';
                                                $kunci_jawaban_huruf = '-';
                                            @endphp
                                            @foreach($ans->pilihan_acak as $pilihan)
                                                @php
                                                    $opsi_teks = '';
                                                    if (strtoupper($pilihan) == 'A') $opsi_teks = $ans->opsi_a;
                                                    if (strtoupper($pilihan) == 'B') $opsi_teks = $ans->opsi_b;
                                                    if (strtoupper($pilihan) == 'C') $opsi_teks = $ans->opsi_c;
                                                    if (strtoupper($pilihan) == 'D') $opsi_teks = $ans->opsi_d;
                                                    if (strtoupper($pilihan) == 'E') $opsi_teks = $ans->opsi_e;
                                                    
                                                    // Jika user memilih ini
                                                    $is_user_choice = (strtoupper($ans->jawaban_user) == strtoupper($pilihan));
                                                    // Jika ini kunci yang benar
                                                    $is_correct_key = (strtoupper($ans->kunci) == strtoupper($pilihan));
                                                    
                                                    if ($is_correct_key) {
                                                        $kunci_jawaban_huruf = $label_huruf[$index_huruf];
                                                    } 
                                                    if ($is_user_choice) {
                                                        $jawaban_peserta_huruf = $label_huruf[$index_huruf];
                                                    }
                                                @endphp
                                                
                                                @if(!empty(strip_tags($opsi_teks)) || trim($opsi_teks) != '')
                                                    @php $index_huruf++; @endphp
                                                @endif
                                            @endforeach
                                        
                                        <div class="mt-3">
                                            <strong>Kunci Asli:</strong> {{ $kunci_jawaban_huruf }} <br>
                                            <strong>Jawaban Pengguna:</strong> {{ $jawaban_peserta_huruf }}
                                        </div>
                                        @if(!$ans->jawaban_user)
                                            <div class="mt-2 text-danger font-italic font-weight-bold">
                                                * Peserta tidak menjawab soal ini.
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
