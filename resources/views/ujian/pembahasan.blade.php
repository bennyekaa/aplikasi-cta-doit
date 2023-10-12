<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ORION SCHOOL</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="card card-primary card-outline">
                                <div class="card-header"
                                    style="display: flex; justify-content: space-between; align-items: center;">
                                    {{-- <div>
                                        <h5 class="m-0">SOAL</h5>
                                    </div> --}}
                                    <div id="countdown" style="font-size: 24px;">
                                        <span id="label">PEMBAHASAN</span>
                                    </div>



                                    <!-- Gantilah "10:00 AM" dengan waktu yang sesuai -->
                                </div>
                                <div class="card-body"
                                    style="display: flex; flex-direction: column; align-items: center; text-align: center;">
                                    <!-- Tampilkan gambar di sini -->
                                    <img src="{{ Storage::url($cari->soal) }}" alt="Soal Image"
                                        style="max-width: 75%; height: auto; margin-bottom: 10px; margin-top: 10px;">
                                    <img src="{{ Storage::url($cari->pembahasan) }}" alt="Soal Image"
                                        style="max-width: 75%; height: auto; margin-bottom: 10px; margin-top: 10px;">

                                    <!-- Tambahkan tombol a sampai e di bawah gambar -->
                                    <div style="display: flex; justify-content: space-around; width: 100%;">
                                        @php
                                            $nomorSoalSekarang = session('nomor'); // Ambil nomor soal saat ini dari session
                                            $soalSekarang = null;
                                            $idSekarang = null;
                                            $jawabanSekarang = null;

                                            // Cari soal yang sesuai dengan nomor saat ini dalam array $daftarsoal
                                            foreach ($daftarsoal as $soal) {
                                                if ($soal['nomor_soal'] == $nomorSoalSekarang) {
                                                    $soalSekarang = $soal;
                                                    $idSekarang = $soal['id_soal'];
                                                    $jawabanSekarang = $soal['jawaban'];
                                                    break; // Keluar dari perulangan setelah menemukan soal yang sesuai
                                                }
                                            }
                                        @endphp

                                        @if ($soalSekarang)
                                            <a href="#"
                                                class="btn {{ $jawabanSekarang === 'A' ? 'btn-danger disabled' : 'btn-default disabled' }}"
                                                style="font-size: 25px;">A</a>
                                            <a href="#"
                                                class="btn {{ $jawabanSekarang === 'B' ? 'btn-danger disabled' : 'btn-default disabled' }}"
                                                style="font-size: 25px;">B</a>
                                            <a href="#"
                                                class="btn {{ $jawabanSekarang === 'C' ? 'btn-danger disabled' : 'btn-default disabled' }}"
                                                style="font-size: 25px;">C</a>
                                            <a href="#"
                                                class="btn {{ $jawabanSekarang === 'D' ? 'btn-danger disabled' : 'btn-default disabled' }}"
                                                style="font-size: 25px;">D</a>
                                            <a href="#"
                                                class="btn {{ $jawabanSekarang === 'E' ? 'btn-danger disabled' : 'btn-default disabled' }}"
                                                style="font-size: 25px;">E</a>
                                        @endif
                                    </div>

                                    <div
                                        style="display: flex; justify-content: space-between; width: 100%; margin-top: 10px;">
                                        @if (Request::segment(4) == 1)
                                            <a href="{{ url('ujian/pembahasan') }}/{{ $id_ujian }}/{{ $nomor + 1 }}/{{ $id_kategori }}"
                                                class="btn btn-primary" style="width: 48%;">SELANJUTNYA</a>
                                        @elseif(Request::segment(4) == $total_nomor)
                                            <a href="{{session('detail_riwayat')}}" class="btn btn-primary" style="width: 48%;">KEMBALI</a>
                                        @else
                                            <a href="{{ url('ujian/pembahasan') }}/{{ $id_ujian }}/{{ $nomor - 1 }}/{{ $id_kategori }}"
                                                class="btn btn-primary" style="width: 48%;">SEBELUMNYA</a>
                                            <a href="{{ url('ujian/pembahasan') }}/{{ $id_ujian }}/{{ $nomor + 1 }}/{{ $id_kategori }}"
                                                class="btn btn-primary" style="width: 48%;">SELANJUTNYA</a>
                                        @endif
                                    </div>
                                </div>
                            </div><!-- /.card -->
                        </div>

                        <!-- /.col-md-6 -->
                        <div class="col-lg-3">
                            <!-- Bagian sebelah kanan untuk tombol nomor soal -->
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h5 class="m-0">Nomor Soal</h5>
                                </div>
                                <div class="card-body">
                                    <!-- Tampilkan tombol nomor soal di sini -->
                                    @php
                                        $jumlahSoal = count($daftarsoal);
                                        $nomorSoalSekarang = session('nomor');
                                    @endphp
                                    @for ($i = 1; $i <= $jumlahSoal; $i += 5)
                                        <div class="btn-group" style="width: 100%;">
                                            @for ($j = $i; $j <= min($i + 4, $jumlahSoal); $j++)
                                                @if (isset($daftarsoal[$j - 1]))
                                                    @php
                                                        $soal = $daftarsoal[$j - 1];
                                                        $jawaban = $soal['jawaban'];
                                                        $buttonClass = 'btn btn-light';
                                                        if ($j == $nomorSoalSekarang) {
                                                            $buttonClass = 'btn btn-primary'; // Nomor saat ini tetap aktif
                                                        } elseif ($jawaban !== null) {
                                                            $buttonClass = 'btn btn-warning'; // Nomor yang sudah terjawab berwarna kuning
                                                        }
                                                    @endphp
                                                    <a href="{{ url('ujian/pembahasan') }}/{{ $id_ujian }}/{{ $soal['nomor_soal'] }}/{{ $id_kategori }}"
                                                        class="{{ $buttonClass }}"
                                                        style="width: 40px; height: 40px; font-size: 15px; margin: 5px; padding: 5px;">{{ $j }}</a>
                                                @else
                                                    <span class="btn btn-light"
                                                        style="width: 40px; height: 40px; font-size: 15px; margin: 5px; padding: 5px;">{{ $j }}</span>
                                                @endif
                                            @endfor
                                        </div>
                                    @endfor
                                </div>

                            </div>
                        </div>

                        <!-- /.col-md-6 -->
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>

</body>

</html>
