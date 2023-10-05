<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Top Navigation</title>

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
                                        <span id="label">WAKTU: </span><span id="minutes">00</span>:<span
                                            id="seconds">00</span>
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
                                            <a href="#" class="btn btn-primary" style="width: 48%;">SELESAI</a>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        function startCountdown(duration) {
            var timer = duration,
                minutes, seconds;
            var idUjian = "{{$id_ujian}}";
            var countdownInterval = setInterval(function() {
                minutes = parseInt(timer / 60, 10);
                seconds = parseInt(timer % 60, 10);

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                document.getElementById("minutes").textContent = minutes;
                document.getElementById("seconds").textContent = seconds;

                // Simpan waktu yang berjalan di localStorage
                localStorage.setItem('countdownMinutes', minutes);
                localStorage.setItem('countdownSeconds', seconds);

                if (--timer < 0) {
                    clearInterval(countdownInterval); // Hentikan interval saat waktu habis
                    timer = duration;
                }
            }, 1000);

            // Menambahkan interval untuk mengupdate ke database setiap 2 menit
            setInterval(function() {
                saveCountdownToDatabase(idUjian, minutes, seconds);
            }, 1000 * 120); // Setiap 2 menit (120 detik)
        }

        function saveCountdownTime(idUjian, minutes, seconds) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/update-countdown-time', true);
            xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
            xhr.send(JSON.stringify({
                id_ujian: idUjian,
                minutes: minutes,
                seconds: seconds
            }));
        }

        function saveCountdownToDatabase(idUjian, minutes, seconds) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/update-countdown-time', true);
            xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
            xhr.send(JSON.stringify({
                _token: "{{ csrf_token() }}",
                id_ujian: idUjian,
                minutes: minutes,
                seconds: seconds
            }));
        }

        window.onload = function() {
            var storedMinutes = localStorage.getItem('countdownMinutes');
            var storedSeconds = localStorage.getItem('countdownSeconds');

            if (storedMinutes !== null && storedSeconds !== null) {
                var countdownSeconds = parseInt(storedMinutes) * 60 + parseInt(storedSeconds);
                startCountdown(countdownSeconds);
            } else {
                var countdownMinutes = 110; // Ubah sesuai dengan jumlah menit yang Anda inginkan
                var countdownSeconds = countdownMinutes * 60;
                startCountdown(countdownSeconds);
            }
        };
    </script>

    {{-- <script>
        // Ambil waktu sisa dari sesi jika tersedia
        var waktuSisa = parseInt("{{ session('waktu_sisa', 0) }}");


        // Fungsi untuk mengonversi total detik menjadi format waktu HH:MM:SS
        function formatWaktu(totalDetik) {
            var jam = Math.floor(totalDetik / 3600);
            var sisaDetik = totalDetik % 3600;
            var menit = Math.floor(sisaDetik / 60);
            var detik = sisaDetik % 60;
            return jam.toString().padStart(2, '0') + ':' + menit.toString().padStart(2, '0') + ':' + detik.toString()
                .padStart(2, '0');
        }

        // Fungsi untuk memperbarui waktu setiap detik
        function perbaruiWaktu() {
            document.getElementById('timer').textContent = formatWaktu(waktuSisa);
            waktuSisa--;

            // Saat waktu habis, tampilkan pesan "Waktu Habis"
            if (waktuSisa < 0) {
                document.getElementById('timer').textContent = "Waktu Habis";
                // Tambahkan tindakan lain yang diperlukan saat waktu habis di sini
            } else {
                setTimeout(perbaruiWaktu, 1000); // Perbarui setiap 1 detik
            }
        }

        // Panggil fungsi perbaruiWaktu saat halaman dimuat
        perbaruiWaktu();
    </script> --}}
    {{-- <script>
        // Fungsi untuk memulai waktu mundur
        function startCountdown(seconds) {
            var countdownInterval = setInterval(function() {
                seconds--;

                // Update tampilan waktu mundur
                var timerElement = document.getElementById('timer');
                if (timerElement) {
                    timerElement.textContent = formatTime(seconds);
                }

                // Cek jika waktu mundur sudah habis
                if (seconds <= 0) {
                    clearInterval(countdownInterval);
                    timerElement.textContent = "Waktu Habis";

                    // Tindakan lain yang perlu dilakukan saat waktu habis
                }
            }, 1000);
        }

        // Fungsi untuk mengatur tampilan waktu dalam format hh:mm:ss
        function formatTime(seconds) {
            var hours = Math.floor(seconds / 3600);
            var minutes = Math.floor((seconds % 3600) / 60);
            var remainingSeconds = seconds % 60;

            return hours.toString().padStart(2, '0') + ':' +
                minutes.toString().padStart(2, '0') + ':' +
                remainingSeconds.toString().padStart(2, '0');
        }

        // Mulai waktu mundur dengan total waktu dalam detik dari basis data
        startCountdown({{ $totalWaktuDetik }});
    </script> --}}
    {{-- <script>
        // Fungsi untuk mengatur timer
        // var idUjian = {{ $id_ujian }};
        function startTimer(duration) {
            var waktuUjian = "{{ $waktuawal->waktu }}";
            // var idUjian = {{ $id_ujian }};
            var timerElement = document.getElementById('timer');
            var minutesDisplay = document.getElementById('minutes');
            var secondsDisplay = document.getElementById('seconds');
            var timer = duration,
                minutes, seconds;

            setInterval(function() {
                minutes = parseInt(timer / 60, 10);
                seconds = parseInt(timer % 60, 10);

                minutes = minutes < 10 ? '0' + minutes : minutes;
                seconds = seconds < 10 ? '0' + seconds : seconds;

                minutesDisplay.textContent = minutes;
                secondsDisplay.textContent = seconds;

                if (--timer < 0) {
                    // Timer berakhir, tambahkan tindakan di sini
                    alert('Waktu ujian telah habis!');
                    // Redirect atau lakukan tindakan lain setelah timer berakhir
                    simpanUjian();
                    window.location.href = '/ujian.list';
                }

                // Simpan timer ke penyimpanan lokal
                localStorage.setItem('exam_timer', timer);
            }, 1000);
        }

        // Periksa apakah ada timer sebelumnya yang disimpan di penyimpanan lokal
        var storedTimer = localStorage.getItem('exam_timer');
        if (storedTimer) {
            startTimer(storedTimer);
        } else {
            // Jika tidak ada timer sebelumnya, mulai dengan durasi 2 jam (120 menit)
            startTimer(60 * waktuUjian); // 2 jam x 60 menit
            // startTimer(60 * waktuUjian); // 2 jam x 60 menit
            // simpanWaktuSaatIni();
            // Jika tidak ada timer sebelumnya, hitung durasi dari waktu awal hingga sekarang
            // var waktuAwalDetik = new Date($waktuawal->waktu).getTime() / 1000; // Konversi waktu awal menjadi detik
            // var sekarangDetik = Math.floor(Date.now() / 1000); // Waktu sekarang dalam detik
            // var durasiDetik = sekarangDetik - waktuAwalDetik;

            // // Hitung sisa waktu ujian (misalnya, 2 jam - waktu yang sudah berlalu)
            // var sisaWaktuDetik = (2 * 60 * 60) - durasiDetik; // 2 jam x 60 menit x 60 detik
            // startTimer(sisaWaktuDetik);
        }

        setInterval(simpanWaktuSaatIni, 180000);
        function simpanWaktuSaatIni() {
            var sekarang = Math.floor(Date.now() / 1000); // Waktu saat ini dalam detik
            localStorage.setItem('current_time', sekarang);

            $.ajax({
                url: '/simpan_waktu',
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    waktu_tersisa: sekarang,
                    id_ujian: idUjian
                },
                success: function(response) {
                    // Respons dari server (jika ada)
                    console.log('Waktu tersisa berhasil disimpan ke database');
                },
                error: function(error) {
                    // Tangani kesalahan jika terjadi
                    console.error('Gagal menyimpan waktu tersisa ke database');
                }
            });
        }

    </script>
    <script>
        function simpanWaktuTersisa(waktuTersisa, idUjian) {
            // Kirim permintaan POST ke server dengan data waktu sisa
            $.ajax({
                url: '/simpan_waktu',
                type: 'POST',
                data: {
                    waktu_tersisa: waktuTersisa,
                    id_ujian: idUjian
                },
                success: function(response) {
                    // Respons dari server (jika ada)
                    console.log('Waktu tersisa berhasil disimpan ke database');
                },
                error: function(error) {
                    // Tangani kesalahan jika terjadi
                    console.error('Gagal menyimpan waktu tersisa ke database');
                }
            });
        }
    </script>
    <script>
        function simpanUjian() {
            // Kirim permintaan POST ke server dengan data waktu sisa
            $.ajax({
                url: '/simpan_ujian',
                type: 'POST',
                data: {
                    id_ujian: "{{$id_ujian}}"
                },
                success: function(response) {
                    // Respons dari server (jika ada)
                    console.log('simpan berhasil disimpan ke database');
                },
                error: function(error) {
                    // Tangani kesalahan jika terjadi
                    console.error('Gagal menyimpan waktu tersisa ke database');
                }
            });
        }
    </script> --}}
    {{-- <script>
        // Mengambil waktu awal dari data yang dikirimkan dari controller
        var waktuAwal = "{{ $waktuawal }}"; // Format: "YYYY-MM-DD HH:MM:SS"
        // Fungsi untuk mengatur timer
        function startTimer(duration) {
            var timerElement = document.getElementById('timer');
            var minutesDisplay = document.getElementById('minutes');
            var secondsDisplay = document.getElementById('seconds');
            var timer = duration,
                minutes, seconds;

            setInterval(function() {
                minutes = parseInt(timer / 60, 10);
                seconds = parseInt(timer % 60, 10);

                minutes = minutes < 10 ? '0' + minutes : minutes;
                seconds = seconds < 10 ? '0' + seconds : seconds;

                minutesDisplay.textContent = minutes;
                secondsDisplay.textContent = seconds;

                if (--timer < 0) {
                    // Timer berakhir, tambahkan tindakan di sini
                    alert('Waktu ujian telah habis!');
                    // Redirect atau lakukan tindakan lain setelah timer berakhir
                    simpanUjian({{ $id_ujian }}, {{session('id_user')}});
                    window.location.href = '/ujian.list'; // Ganti dengan URL yang sesuai
                }

                // Simpan timer ke penyimpanan lokal
                localStorage.setItem('exam_timer', timer);
            }, 1000);
        }

        // Periksa apakah ada timer sebelumnya yang disimpan di penyimpanan lokal
        var storedTimer = localStorage.getItem('exam_timer');
        if (storedTimer) {
            startTimer(storedTimer);
        } else {
            // Jika tidak ada timer sebelumnya, hitung durasi dari waktu awal hingga sekarang
            var waktuAwalDetik = new Date(waktuAwal).getTime() / 1000; // Konversi waktu awal menjadi detik
            var sekarangDetik = Math.floor(Date.now() / 1000); // Waktu sekarang dalam detik
            var durasiDetik = sekarangDetik - waktuAwalDetik;

            // Hitung sisa waktu ujian (misalnya, 2 jam - waktu yang sudah berlalu)
            var sisaWaktuDetik = (2 * 60 * 60) - durasiDetik; // 2 jam x 60 menit x 60 detik
            startTimer(sisaWaktuDetik);
        }
    </script> --}}


</body>

</html>
