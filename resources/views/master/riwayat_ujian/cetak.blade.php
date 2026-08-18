<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Riwayat Ujian - {{ $exam->nama_peserta }}</title>
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('assets/dist/css/adminlte.min.css')}}">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{asset('assets/plugins/fontawesome-free/css/all.min.css')}}">
    <style>
        body {
            background-color: #fff;
            color: #000;
        }
        .cetak-container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
        }
        .kop-surat {
            text-align: center;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .kop-surat h2 {
            margin: 0;
            font-weight: bold;
        }
        .kop-surat p {
            margin: 0;
        }
        table.info-table {
            width: 100%;
            margin-bottom: 20px;
        }
        table.info-table th {
            text-align: left;
            width: 150px;
        }
        .soal-box {
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 15px;
            page-break-inside: avoid;
        }
        .bg-success-print {
            background-color: #d4edda !important;
            border: 1px solid #c3e6cb !important;
            color: #155724 !important;
        }
        .bg-danger-print {
            background-color: #f8d7da !important;
            border: 1px solid #f5c6cb !important;
            color: #721c24 !important;
        }
        @media print {
            body { margin: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="cetak-container">
        <div class="no-print text-center mb-3">
            <button onclick="window.print()" class="btn btn-primary"><i class="fas fa-print"></i> Print Dokumen</button>
            <button onclick="window.close()" class="btn btn-default">Tutup</button>
        </div>
        
        <div class="kop-surat">
            <h2>HASIL KOREKSI UJIAN (CAT)</h2>
            <p>{{ session('instansi', 'SISTEM UJIAN CAT') }}</p>
        </div>

        <div class="row">
            <div class="col-6">
                <table class="info-table">
                    <tr><th>Nama Peserta</th><td>: {{ $exam->nama_peserta }}</td></tr>
                    <tr><th>Username</th><td>: {{ $exam->username }}</td></tr>
                    <tr><th>Modul Ujian</th><td>: {{ $exam->nama_modul }}</td></tr>
                </table>
            </div>
            <div class="col-6">
                <table class="info-table">
                    <tr><th>Waktu Mulai</th><td>: {{ $exam->waktu_mulai ? date('d M Y H:i:s', strtotime($exam->waktu_mulai)) : '-' }}</td></tr>
                    <tr><th>Waktu Selesai</th><td>: {{ $exam->waktu_selesai ? date('d M Y H:i:s', strtotime($exam->waktu_selesai)) : '-' }}</td></tr>
                    <tr><th>Nilai Akhir</th><td>: <b>{{ $exam->nilai ?? 0 }}</b></td></tr>
                </table>
            </div>
        </div>

        <h4 class="mt-4 mb-3">Rincian Jawaban</h4>
        
        @php $label_huruf = ['A', 'B', 'C', 'D', 'E']; @endphp
        @foreach($answers as $ans)
            <div class="soal-box">
                <div class="mb-2">
                    <strong>Soal No. {{ $ans->nomor_soal }}</strong> 
                    @if($ans->jawaban_user == $ans->kunci)
                        <span style="color: green; font-weight: bold; margin-left:10px;">[ BENAR ]</span>
                    @else
                        <span style="color: red; font-weight: bold; margin-left:10px;">[ SALAH ]</span>
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
                            
                            $is_user_choice = (strtoupper($ans->jawaban_user) == strtoupper($pilihan));
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
                
                <div style="margin-top: 10px;">
                    <strong>Kunci Asli:</strong> {{ $kunci_jawaban_huruf }} <br>
                    <strong>Jawaban Pengguna:</strong> {{ $jawaban_peserta_huruf }}
                </div>
                @if(!$ans->jawaban_user)
                    <div class="mt-2" style="color:red; font-style:italic;">
                        * Peserta tidak menjawab soal ini.
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</body>
</html>
