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
                                        <span id="label">WAKTU: </span>
                                        <span id="minutes"></span> menit
                                        <span id="seconds"></span> detik
                                    </div>



                                    <!-- Gantilah "10:00 AM" dengan waktu yang sesuai -->
                                </div>
                                <div class="card-body"
                                    style="display: flex; flex-direction: column; align-items: center; text-align: center;">
                                    <!-- Tampilkan gambar di sini -->
                                    <img src="{{ Storage::url($cari->soal) }}" alt="Soal Image"
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
                                            <a href="{{ url('ujian/jawab') }}/{{ encrypt($id_ujian) }}/{{ encrypt($idSekarang) }}/{{ encrypt($soalSekarang['poin_a']) }}/A"
                                                class="btn {{ $jawabanSekarang === 'A' ? 'btn-danger' : 'btn-default' }}"
                                                style="font-size: 25px;">A</a>
                                            <a href="{{ url('ujian/jawab') }}/{{ encrypt($id_ujian) }}/{{ encrypt($idSekarang) }}/{{ encrypt($soalSekarang['poin_b']) }}/B"
                                                class="btn {{ $jawabanSekarang === 'B' ? 'btn-danger' : 'btn-default' }}"
                                                style="font-size: 25px;">B</a>
                                            <a href="{{ url('ujian/jawab') }}/{{ encrypt($id_ujian) }}/{{ encrypt($idSekarang) }}/{{ encrypt($soalSekarang['poin_c']) }}/C"
                                                class="btn {{ $jawabanSekarang === 'C' ? 'btn-danger' : 'btn-default' }}"
                                                style="font-size: 25px;">C</a>
                                            <a href="{{ url('ujian/jawab') }}/{{ encrypt($id_ujian) }}/{{ encrypt($idSekarang) }}/{{ encrypt($soalSekarang['poin_d']) }}/D"
                                                class="btn {{ $jawabanSekarang === 'D' ? 'btn-danger' : 'btn-default' }}"
                                                style="font-size: 25px;">D</a>
                                            <a href="{{ url('ujian/jawab') }}/{{ encrypt($id_ujian) }}/{{ encrypt($idSekarang) }}/{{ encrypt($soalSekarang['poin_e']) }}/E"
                                                class="btn {{ $jawabanSekarang === 'E' ? 'btn-danger' : 'btn-default' }}"
                                                style="font-size: 25px;">E</a>
                                        @endif
                                    </div>

                                    <div
                                        style="display: flex; justify-content: space-between; width: 100%; margin-top: 10px;">
                                        @if (Request::segment(4) == 1)
                                            <a href="{{ url('ujian/mulai') }}/{{ $id_kategori }}/{{ $nomor + 1 }}/{{ $id_ujian }}"
                                                class="btn btn-primary" style="width: 48%;">SELANJUTNYA</a>
                                        @elseif(Request::segment(4) == $total_nomor)
                                            <a href="{{url('ujian/selesai')}}/{{$id_ujian}}" class="btn btn-primary" style="width: 48%;">SELESAI</a>
                                        @else
                                            <a href="{{ url('ujian/mulai') }}/{{ $id_kategori }}/{{ $nomor - 1 }}/{{ $id_ujian }}"
                                                class="btn btn-primary" style="width: 48%;">SEBELUMNYA</a>
                                            <a href="{{ url('ujian/mulai') }}/{{ $id_kategori }}/{{ $nomor + 1 }}/{{ $id_ujian }}"
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
                                                    <a href="{{ url('ujian/mulai') }}/{{ $id_kategori }}/{{ $soal['nomor_soal'] }}/{{ $id_ujian }}"
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
    <script>
        // Fungsi untuk menginisialisasi dan memulai timer mundur
        function startCountdown(countdownId, initialSeconds) {
            let remainingSeconds = initialSeconds;
            const countdownElement = document.getElementById(countdownId);
            const minutesElement = document.getElementById('minutes');
            const secondsElement = document.getElementById('seconds');

            // Fungsi untuk memperbarui tampilan timer mundur
            function updateCountdownDisplay() {
                const minutes = Math.floor(remainingSeconds / 60);
                const seconds = remainingSeconds % 60;
                minutesElement.textContent = minutes.toString().padStart(2, '0');
                secondsElement.textContent = seconds.toString().padStart(2, '0');
            }

            // Memulai timer mundur dan mengupdate tampilan tiap detik
            const countdownInterval = setInterval(() => {
                remainingSeconds--;
                updateCountdownDisplay();

                // Hentikan timer mundur jika waktu habis
                if (remainingSeconds <= 0) {
                    countdownElement.textContent = "WAKTU HABIS"; // Tampilkan waktu habis
                    // Tambahkan logika untuk mengupdate status ujian ke 2 di sini
                    const idUjian = '{{ $id_ujian }}'; // Ganti dengan cara Anda mendapatkan ID ujian
                    updateStatusUjian(idUjian); // Panggil fungsi untuk mengupdate status ujian
                    clearInterval(countdownInterval); // Hentikan timer mundur
                }
            }, 1000); // 1000 ms = 1 detik

            // Panggil fungsi updateCountdownDisplay untuk menampilkan waktu awal
            updateCountdownDisplay();

        }

        // Panggil fungsi startCountdown dengan id elemen dan waktu awal dalam detik
        startCountdown('countdown', {{ $selisih_detik }});

        function updateStatusUjian(idUjian) {
            $.ajax({
                type: "POST",
                url: "{{ url('simpan_ujian') }}", // Ganti dengan URL Anda
                data: {
                    _token: "{{ csrf_token() }}",
                    id_ujian: idUjian
                },
                success: function(response) {
                    // Tindakan yang perlu Anda lakukan setelah status ujian diperbarui
                    console.log("Status ujian diperbarui menjadi 2.");
                },
                error: function(error) {
                    console.error("Gagal mengupdate status ujian:", error);
                }
            });
        }

    </script>

</body>

</html>
