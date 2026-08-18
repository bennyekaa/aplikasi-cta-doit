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
                                    <div class="form-group row">
                                        <label for="" class="col-sm-3 col-form-label">Nama Lengkap</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="nama_lengkap"
                                                placeholder="Nama Lengkap" value="{{$pengguna->nama_lengkap}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Jabatan</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="id_jabatan">
                                                <option value="">-- Pilih Jabatan --</option>
                                                @foreach($jabatan as $j)
                                                    <option value="{{ $j->id_jabatan }}" {{ $pengguna->id_jabatan == $j->id_jabatan ? 'selected' : '' }}>
                                                        {{ $j->nama_jabatan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Wilayah (Desa)</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="id_desa">
                                                <option value="">-- Pilih Desa --</option>
                                                @foreach($desa as $d)
                                                    <option value="{{ $d->id_desa }}" {{ $pengguna->id_desa == $d->id_desa ? 'selected' : '' }}>
                                                        {{ $d->nama_desa }} (Kec. {{ $d->kecamatan->nama_kecamatan ?? '-' }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
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
