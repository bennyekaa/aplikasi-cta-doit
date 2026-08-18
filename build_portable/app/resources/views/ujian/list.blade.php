@extends('layout.ujian.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-12 text-center">
                        <h1 class="m-0 font-weight-bold">DASHBOARD UJIAN</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container">
                <style>
                    .hover-card {
                        transition: all 0.3s ease;
                        border-radius: 12px;
                        border: none;
                        box-shadow: 0 4px 6px rgba(0,0,0,.1);
                    }
                    .hover-card:hover {
                        transform: translateY(-5px);
                        box-shadow: 0 12px 20px rgba(0,0,0,.15);
                    }
                    .logo-img {
                        max-height: 70px;
                        margin-bottom: 20px;
                        object-fit: contain;
                    }
                    .exam-title {
                        font-weight: 700;
                        font-size: 1.25rem;
                        color: #343a40;
                        margin-bottom: 25px;
                    }
                    .info-box-custom {
                        background-color: #f8f9fa;
                        border-radius: 8px;
                        padding: 15px;
                        margin-bottom: 25px;
                    }
                    .date-text {
                        font-size: 1.1rem;
                        font-weight: 600;
                        color: #007bff;
                        margin: 0;
                    }
                    .stat-item {
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        color: #6c757d;
                    }
                    .stat-value {
                        font-weight: 700;
                        font-size: 1.1rem;
                        color: #495057;
                    }
                </style>
                <div class="row">
                    <!-- Ujian Aktif (Berjalan) -->
                    @if (isset($ujian_aktif))
                    <div class="col-lg-12 mb-4">
                        <div class="card card-warning card-outline hover-card">
                            <div class="card-header border-0 bg-transparent pt-4 pb-0 text-center">
                                <h5 class="m-0 text-warning font-weight-bold"><i class="fas fa-exclamation-circle mr-2"></i>UJIAN SEDANG BERJALAN</h5>
                            </div>
                            <div class="card-body text-center pb-4">
                                <h3 class="font-weight-bold">{{ $modul_aktif->nama_modul }}</h3>
                                <p class="text-muted mb-4">Anda memiliki sesi ujian yang belum selesai.</p>
                                <a href="{{url('ujian/mulai')}}/{{encrypt($ujian_aktif->id)}}/1" class="btn btn-warning btn-lg px-5 shadow-sm rounded-pill font-weight-bold text-white">LANJUTKAN UJIAN</a>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Daftar Modul Ujian -->
                    <div class="col-lg-12">
                        <div class="card shadow-none bg-transparent">
                            <div class="card-header border-0 px-0 mb-2 text-center">
                                <h4 class="m-0 font-weight-bold text-dark w-100">DAFTAR UJIAN TERSEDIA</h4>
                            </div>
                            <div class="card-body p-0">
                                @if(session('error'))
                                    <div class="alert alert-danger rounded-lg shadow-sm">
                                        <i class="fas fa-exclamation-triangle mr-2"></i> {{ session('error') }}
                                    </div>
                                @endif
                                
                                @if(session('success'))
                                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            Swal.fire({
                                                title: 'Berhasil!',
                                                text: '{{ session('success') }}',
                                                icon: 'success',
                                                confirmButtonText: 'OK',
                                                timer: 3000,
                                                timerProgressBar: true
                                            });
                                        });
                                    </script>
                                @endif

                                <div class="row justify-content-center">
                                    @foreach ($moduls as $modul)
                                    <div class="col-md-6 col-lg-4 mb-4">
                                        <div class="card h-100 hover-card">
                                            <div class="card-body text-center p-4">
                                                @if(isset($pengaturan) && $pengaturan->logo)
                                                    <img src="{{ asset('uploads/logo/' . $pengaturan->logo) }}" alt="Logo" class="logo-img">
                                                @else
                                                    <img src="{{ asset('assets/dist/img/AdminLTELogo.png') }}" alt="Logo" class="logo-img">
                                                @endif
                                                
                                                <h4 class="exam-title">{{ $modul->nama_modul }}</h4>
                                                
                                                <div class="info-box-custom">
                                                    <div class="mb-1 text-muted"><i class="far fa-calendar-alt mr-1"></i> Jadwal Ujian</div>
                                                    <p class="date-text">{{ date('d M Y - H:i', strtotime($modul->waktu_mulai)) }}</p>
                                                </div>

                                                <div class="d-flex justify-content-around mb-4">
                                                    <div class="stat-item">
                                                        <i class="far fa-clock mb-1 text-primary" style="font-size: 1.2rem;"></i>
                                                        <span class="stat-value">{{ $modul->waktu }} Menit</span>
                                                    </div>
                                                    <div class="stat-item border-left pl-4">
                                                        <i class="fas fa-list-ol mb-1 text-info" style="font-size: 1.2rem;"></i>
                                                        <span class="stat-value">{{ $modul->jumlah_soal }} Soal</span>
                                                    </div>
                                                </div>

                                                <div class="mt-auto">
                                                    @if (strtotime($modul->waktu_mulai) > time())
                                                        <div class="pending-ujian" data-waktu="{{ strtotime($modul->waktu_mulai) }}">
                                                            <span class="btn btn-secondary btn-block rounded-pill py-2 font-weight-bold" style="cursor: not-allowed; opacity: 0.8;"><i class="fas fa-lock mr-2"></i>BELUM MULAI</span>
                                                            <small class="text-danger d-block mt-2 font-italic">Otomatis terbuka saat waktunya tiba</small>
                                                        </div>
                                                    @else
                                                        @if(isset($ujian_aktif) && $ujian_aktif->id_modul == $modul->id_modul)
                                                            <a href="{{url('ujian/mulai')}}/{{encrypt($ujian_aktif->id)}}/1" class="btn btn-warning btn-block rounded-pill py-2 font-weight-bold text-white shadow-sm"><i class="fas fa-play mr-2"></i>LANJUTKAN</a>
                                                        @elseif(isset($ujian_selesai) && in_array($modul->id_modul, $ujian_selesai))
                                                            <span class="btn btn-success btn-block rounded-pill py-2 font-weight-bold shadow-sm" style="cursor: default; opacity: 1;"><i class="fas fa-check-circle mr-2"></i>UJIAN SELESAI</span>
                                                        @else
                                                            <a href="{{url('ujian/input')}}/{{encrypt($modul->id_modul)}}" class="btn btn-primary btn-block rounded-pill py-2 font-weight-bold shadow-sm"><i class="fas fa-pen mr-2"></i>MULAI SEKARANG</a>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        setInterval(function() {
            // Get current timestamp in seconds
            var now = Math.floor(Date.now() / 1000);
            var pendings = document.querySelectorAll('.pending-ujian');
            var shouldReload = false;

            pendings.forEach(function(el) {
                var waktuMulai = parseInt(el.getAttribute('data-waktu'));
                if (now >= waktuMulai) {
                    shouldReload = true;
                }
            });

            if (shouldReload) {
                window.location.reload();
            }
        }, 1000);
    </script>
@endsection
