<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{$instansi}} | Log in</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            @if(isset($logo) && $logo != '')
                <img src="{{ asset('uploads/logo/' . $logo) }}" alt="Logo" style="max-height: 120px; margin-bottom: 15px;">
            @else
                <img src="{{ asset('assets/dist/img/logo_kabupaten_trenggalek.png') }}" alt="Logo Kabupaten Trenggalek" style="max-height: 120px; margin-bottom: 15px;">
            @endif
            <br>
            <a href="#" style="{{ isset($pengaturan->font_type) ? 'font-family: '.$pengaturan->font_type.';' : '' }} {{ isset($pengaturan->font_size) ? 'font-size: '.$pengaturan->font_size.'px;' : '' }}"><b>{{$instansi}}</b></a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                @php
                    $isSeb = strpos(request()->userAgent(), 'SEB') !== false || strpos(request()->userAgent(), 'SafeExamBrowser') !== false;
                    $isLocalhost = in_array(request()->ip(), ['127.0.0.1', '::1']);
                @endphp

                @if($isSeb || $isLocalhost)
                    <p class="login-box-msg">Masukkan Akun Anda</p>

                    <form action="{{url('actionlogin')}}" method="post">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="username" placeholder="Username">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" name="password" placeholder="Password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- /.col -->
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block">LOGIN</button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>
                @else
                    <div class="text-center">
                        <h5 class="text-danger mb-3"><i class="fas fa-exclamation-triangle"></i> Peringatan</h5>
                        <p>Anda wajib menggunakan <b>Safe Exam Browser (SEB)</b> untuk mengikuti ujian.</p>
                        <p>Jika SEB sudah terinstal di laptop Anda, klik tombol di bawah ini untuk memulai ujian:</p>
                        <a href="{{ url('download-seb-config') }}" class="btn btn-success btn-block btn-lg mt-4" style="white-space: normal;">
                            <i class="fas fa-play-circle"></i> KLIK DI SINI UNTUK MULAI UJIAN
                        </a>
                        <p class="mt-3 text-muted" style="font-size: 12px;">File .seb akan didownload. Klik file tersebut untuk membuka ujian.</p>
                    </div>
                @endif
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>
</body>

</html>
