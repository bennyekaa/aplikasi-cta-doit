@extends('layout.app')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Pengguna</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Master</a></li>
                            <li class="breadcrumb-item active">Pengguna</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Ganti Password</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="{{ url('master/pengguna/proses') }}" method="post">
                                @csrf
                                <input type="hidden" name="fungsi" value="Password">
                                <input type="hidden" name="id_user" value="{{$pengguna->id_user}}">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control form-control-border" id="password"
                                            placeholder="Masukkan Password" name="password">
                                    </div>
                                    <div class="form-group">
                                        <label for="ulangi_password">Ulangi Password</label>
                                        <input type="password" class="form-control form-control-border" id="ulangi_password"
                                            placeholder="Ulangi Password" name="ulangi_password">
                                    </div>
                                    <input type="checkbox" onclick="myFunction()"> Lihat Password
                                    <!-- /.card-body -->

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->

                    </div>
                    <!--/.col (left) -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->
@endsection
@section('tambahanjs')
    <script type="text/javascript">
        window.onload = function() {
            document.getElementById("password").onchange = validatePassword;
            document.getElementById("ulangi_password").onchange = validatePassword;
        }

        function validatePassword() {
            var pass2 = document.getElementById("ulangi_password").value;
            var pass1 = document.getElementById("password").value;
            if (pass1 != pass2)
                document.getElementById("ulangi_password").setCustomValidity("Passwords Tidak Sama, Coba Lagi");
            else
                document.getElementById("ulangi_password").setCustomValidity('');
        }

        function myFunction() {
            var x = document.getElementById("password");
            var y = document.getElementById("ulangi_password");
            if (x.type === "password" && y.type === "password") {
                x.type = "text";
                y.type = "text";
            } else {
                x.type = "password";
                y.type = "password";
            }
        }
    </script>
@endsection