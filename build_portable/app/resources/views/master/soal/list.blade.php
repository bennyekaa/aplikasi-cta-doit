@extends('layout.app')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Data Kategori Soal</h1>
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
                    {{-- <div class="col-sm-6">
                            <a class="btn btn-warning" href="{{session('soal')}}">
                                <i></i>KEMBALI
                            </a>
                        </div> --}}
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Kategori</h3>
                            </div>
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <th>#</th>
                                        <th>KATEGORI</th>
                                        <th>KETERANGAN</th>
                                        <th></th>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($kategori as $item)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $item->nama_kategori }}</td>
                                                <td>{{ $item->keterangan }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a class="btn btn-primary" href="{{url('master/soal/detail/list')}}/{{encrypt($item->id_kategori)}}" title="Pilih">
                                                            <i></i>PILIH
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->
@endsection
