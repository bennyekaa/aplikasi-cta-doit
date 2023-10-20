@extends('layout.app')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Data</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Pengguna</a></li>
                            <li class="breadcrumb-item active">Edit</li>
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
                                <h3 class="card-title">Edit Pengguna</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="{{ url('master/pengguna/proses') }}" method="post">
                                @csrf
                                <input type="hidden" name="fungsi" value="Edit">
                                <input type="hidden" name="id_user" value="{{ $id_user }}">
                                <div class="card-body">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="username" placeholder="Username" value="{{$pengguna->username}}">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-user"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="nama_lengkap"
                                            placeholder="Nama Lengkap" value="{{$pengguna->nama_lengkap}}">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-user"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="telepon" placeholder="Telepon" value="{{$pengguna->telepon}}">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-user"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="email" class="form-control" name="email" placeholder="Email" value="{{$pengguna->email}}">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-envelope"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <select class="custom-select rounded-0" id="exampleSelectRounded0" name="jk"
                                            required>
                                            <option>--Pilih Jenis Kelamin--</option>
                                            <option value="L" {{$pengguna->jk == 'L' ? 'selected' : ''}}>Laki - Laki</option>
                                            <option value="P" {{$pengguna->jk == 'P' ? 'selected' : ''}}>Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <textarea class="form-control" rows="3" name="alamat" placeholder="Masukkan Alamat">{{$pengguna->alamat}}</textarea>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
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
