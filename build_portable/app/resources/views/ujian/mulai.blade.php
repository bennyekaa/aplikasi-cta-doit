<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pengaturan->instansi ?? 'Aplikasi Ujian' }} - Ujian</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .timer-box { font-size: 24px; font-weight: bold; background: #343a40; color: #fff; padding: 10px 20px; border-radius: 5px; }
        .btn-jawaban { font-size: 24px; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; font-weight: bold; margin: 0 5px; }
        .nav-button { width: 45px; height: 45px; margin: 3px; font-weight: bold; padding: 0; display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0; }
    </style>
</head>
<body class="hold-transition layout-top-nav">
    <div class="wrapper">
        <div class="content-wrapper">
            <div class="content mt-4">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="card card-primary card-outline">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="m-0 font-weight-bold" id="judul-soal">{{ $modul->nama_modul }} - Soal No. {{ $nomor }}</h5>
                                    <div class="timer-box">
                                        <i class="far fa-clock"></i> <span id="minutes">00</span>:<span id="seconds">00</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @foreach($answers as $ans)
                                        @php
                                            $s = $soal_list[$ans->id_soal] ?? null;
                                        @endphp
                                        @if($s)
                                        <div id="soal-container-{{ $ans->nomor_soal }}" class="soal-container" style="display: {{ $ans->nomor_soal == $nomor ? 'block' : 'none' }};">
                                            <div class="soal-teks mb-4" style="font-size: 16px;">
                                                {!! $s->soal !!}
                                            </div>

                                            <div class="pilihan-ganda mb-4 mt-3">
                                                @php
                                                    $label_huruf = ['A', 'B', 'C', 'D', 'E'];
                                                    $index_huruf = 0;
                                                @endphp
                                                @foreach($ans->pilihan_acak as $pilihan)
                                                    @php
                                                        $opsi_teks = '';
                                                        if($pilihan == 'A') $opsi_teks = $s->opsi_a;
                                                        if($pilihan == 'B') $opsi_teks = $s->opsi_b;
                                                        if($pilihan == 'C') $opsi_teks = $s->opsi_c;
                                                        if($pilihan == 'D') $opsi_teks = $s->opsi_d;
                                                        if($pilihan == 'E') $opsi_teks = $s->opsi_e;
                                                    @endphp
                                                    @if(!empty(trim(strip_tags($opsi_teks))))
                                                        <button type="button" 
                                                           onclick="jawabSoal('{{ encrypt($ans->id) }}', '{{ $pilihan }}', {{ $ans->nomor_soal }}, this)"
                                                           class="btn btn-block text-left mb-2 btn-opsi btn-opsi-{{ $ans->nomor_soal }} {{ $ans->jawaban_user == $pilihan ? 'btn-danger active-opsi' : 'btn-default border' }}" style="white-space: normal;">
                                                            <span class="font-weight-bold mr-2">{{ $label_huruf[$index_huruf] }}.</span> {!! $opsi_teks !!}
                                                        </button>
                                                        @php $index_huruf++; @endphp
                                                    @endif
                                                @endforeach
                                            </div>

                                            <div class="d-flex justify-content-between mt-5">
                                                @if ($ans->nomor_soal > 1)
                                                    <button type="button" onclick="gantiSoal({{ $ans->nomor_soal - 1 }})" class="btn btn-primary px-4"><i class="fas fa-chevron-left"></i> SEBELUMNYA</button>
                                                @else
                                                    <div></div>
                                                @endif
                                                
                                                @if ($ans->nomor_soal < $total_nomor)
                                                    <button type="button" onclick="gantiSoal({{ $ans->nomor_soal + 1 }})" class="btn btn-primary px-4">SELANJUTNYA <i class="fas fa-chevron-right"></i></button>
                                                @else
                                                    <a href="javascript:void(0)" class="btn btn-success px-4" onclick="konfirmasiSelesai()"><i class="fas fa-check"></i> SELESAI UJIAN</a>
                                                @endif
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h5 class="m-0 font-weight-bold">Navigasi Soal</h5>
                                </div>
                                <div class="card-body p-2 d-flex flex-wrap justify-content-start" id="nav-container">
                                    @foreach($answers as $ans)
                                        @php
                                            $btnClass = 'btn-default border';
                                            if ($ans->nomor_soal == $nomor) {
                                                $btnClass = 'btn-primary';
                                            } elseif ($ans->jawaban_user) {
                                                $btnClass = 'btn-success';
                                            }
                                        @endphp
                                        <button type="button" onclick="gantiSoal({{ $ans->nomor_soal }})"
                                           id="nav-btn-{{ $ans->nomor_soal }}"
                                           class="btn {{ $btnClass }} nav-button" data-jawab="{{ $ans->jawaban_user ? '1' : '0' }}">
                                           {{ $ans->nomor_soal }}
                                        </button>
                                    @endforeach
                                </div>
                                <div class="card-footer text-center">
                                    <span class="badge badge-success px-2 py-1"><i class="fas fa-check"></i> Terjawab</span>
                                    <span class="badge badge-default border px-2 py-1">Belum Terjawab</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let remainingSeconds = {{ $sisa_detik }};
        const minutesElement = document.getElementById('minutes');
        const secondsElement = document.getElementById('seconds');
        
        let currentNomor = {{ $nomor }};
        let namaModul = "{{ $modul->nama_modul }}";
        let isTimeUp = false;

        function updateDisplay() {
            if (remainingSeconds <= 0 && !isTimeUp) {
                isTimeUp = true;
                minutesElement.textContent = "00";
                secondsElement.textContent = "00";
                Swal.fire({
                    title: 'Waktu Habis!',
                    text: 'Waktu ujian Anda telah habis.',
                    icon: 'warning',
                    confirmButtonText: 'Tutup Ujian',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then((result) => {
                    window.location.href = "{{ url('ujian/selesai') }}/{{ encrypt($ujian->id) }}";
                });
                return;
            } else if (remainingSeconds <= 0) {
                return;
            }
            
            const m = Math.floor(remainingSeconds / 60);
            const s = remainingSeconds % 60;
            minutesElement.textContent = m.toString().padStart(2, '0');
            secondsElement.textContent = s.toString().padStart(2, '0');
        }

        setInterval(() => {
            remainingSeconds--;
            updateDisplay();
        }, 1000);
        updateDisplay();
        
        function gantiSoal(nomor) {
            // Hide current
            $('.soal-container').hide();
            // Show new
            $('#soal-container-' + nomor).show();
            
            // Update title
            $('#judul-soal').text(namaModul + ' - Soal No. ' + nomor);
            
            // Update nav button classes
            $('.nav-button').each(function() {
                let btnNomor = parseInt($(this).text().trim());
                let sudahJawab = $(this).attr('data-jawab') == '1';
                
                if (btnNomor == nomor) {
                    $(this).removeClass('btn-default border btn-success').addClass('btn-primary');
                } else {
                    $(this).removeClass('btn-primary');
                    if (sudahJawab) {
                        $(this).addClass('btn-success');
                    } else {
                        $(this).addClass('btn-default border');
                    }
                }
            });
            
            currentNomor = nomor;
            window.scrollTo(0, 0);
        }
        
        function jawabSoal(id_answer, jawaban, nomor_soal, btnElement) {
            // Update UI immediately for snappiness
            $('.btn-opsi-' + nomor_soal).removeClass('btn-danger active-opsi').addClass('btn-default border');
            $(btnElement).removeClass('btn-default border').addClass('btn-danger active-opsi');
            
            // Mark nav button as answered data
            $('#nav-btn-' + nomor_soal).attr('data-jawab', '1');
            
            // Send AJAX
            $.ajax({
                url: "{{ url('ujian/jawab') }}/" + id_answer + "/" + jawaban,
                type: 'GET',
                success: function(res) {
                    if (res.success) {
                        // Jika mau otomatis pindah ke nomor selanjutnya, bisa pakai:
                        // if (res.next_nomor != nomor_soal) gantiSoal(res.next_nomor);
                    } else {
                        if (res.message) alert(res.message);
                    }
                },
                error: function(err) {
                    console.error("Gagal menyimpan jawaban", err);
                }
            });
        }
        
        function konfirmasiSelesai() {
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Anda akan mengakhiri ujian ini. Jawaban tidak dapat diubah lagi!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Selesai!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Konfirmasi Terakhir',
                        text: "Tindakan ini tidak bisa dibatalkan. Benar-benar selesai?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#28a745',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Benar-benar Selesai!',
                        cancelButtonText: 'Kembali'
                    }).then((result2) => {
                        if (result2.isConfirmed) {
                            window.location.href = "{{ url('ujian/selesai') }}/{{ encrypt($ujian->id) }}";
                        }
                    });
                }
            });
        }
    </script>
</body>
</html>
