@extends('layout.app')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Tematik</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Master</a></li>
                            <li class="breadcrumb-item active">Tematik</li>
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
                                <h3 class="card-title">Edit Tematik</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="{{ url('master/kategori/proses') }}" method="post">
                                @csrf
                                <input type="hidden" name="id_kategori" value="{{$id_kategori}}">
                                <input type="hidden" name="fungsi" value="Edit">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Pilih Modul Ujian</label>
                                        <select name="id_modul" class="form-control" required>
                                            <option value="">-- Pilih Modul --</option>
                                            @foreach($modul as $m)
                                                <option value="{{ $m->id_modul }}" {{ $kategori->id_modul == $m->id_modul ? 'selected' : '' }}>{{ $m->nama_modul }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Tematik</label>
                                        <input type="text" name="nama_tematik" class="form-control"
                                            placeholder="Nama Tematik" value="{{$kategori->nama_tematik}}" required>
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
