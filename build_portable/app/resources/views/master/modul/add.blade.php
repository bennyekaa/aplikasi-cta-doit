@extends('layout.app')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Modul</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Master</a></li>
                            <li class="breadcrumb-item active">Modul</li>
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
                                <h3 class="card-title">Tambah Modul</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="{{ url('master/modul/proses') }}" method="post">
                                @csrf
                                <input type="hidden" name="fungsi" value="Tambah">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Nama Modul</label>
                                        <input type="text" name="nama_modul" class="form-control"
                                            placeholder="Nama Modul">
                                    </div>
                                    <div class="form-group">
                                        <label>Waktu (Menit)</label>
                                        <input type="number" name="waktu" class="form-control"
                                            placeholder="Contoh: 90" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Waktu Mulai Ujian</label>
                                        <input type="datetime-local" name="waktu_mulai" class="form-control"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label>Jumlah Soal</label>
                                        <input type="number" name="jumlah_soal" class="form-control"
                                            placeholder="Contoh: 100" required>
                                    </div>
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
