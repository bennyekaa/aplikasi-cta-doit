@extends('layout.app')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Kategori</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Master</a></li>
                            <li class="breadcrumb-item active">Kategori</li>
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
                                <h3 class="card-title">Edit Kategori</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="{{ url('master/kategori/proses') }}" method="post">
                                @csrf
                                <input type="hidden" name="id_kategori" value="{{$id_kategori}}">
                                <input type="hidden" name="fungsi" value="Edit">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Nama Kategori</label>
                                        <input type="text" name="nama_kategori" class="form-control"
                                            placeholder="Nama Kategori" value="{{$kategori->nama_kategori}}">
                                    </div>
                                    <div class="form-group">
                                        <label>Total Waktu Ujian (Dalam Menit)</label>
                                        <input type="text" name="menit" class="form-control"
                                            placeholder="Waktu" value="{{$kategori->menit}}">
                                    </div>
                                    <div class="form-group">
                                        <label>Nilai Total</label>
                                        <input type="text" name="nilai_total" class="form-control"
                                            placeholder="Nilai Total" value="{{$kategori->nilai_total}}">
                                    </div>
                                    <div class="form-group">
                                        <label>Keterangan</label>
                                        <textarea class="form-control" rows="3" name="keterangan" placeholder="Masukkan Keterangan">{{$kategori->keterangan}}</textarea>
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
