@extends('layout.app')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Data Soal</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Master</a></li>
                            <li class="breadcrumb-item active">Soal</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Soal</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="col-sm-6">
                                <a class="btn btn-primary" href="{{url('master/soal/add')}}">
                                    <i></i>TAMBAH
                                </a>
                            </div>
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <th>#</th>
                                        <th>KATEGORI</th>
                                        <th>SOAL</th>
                                        <th>PEMBAHASAN</th>
                                        <th></th>
                                    </thead>
                                    <tbody>
                                        {{-- @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($soal as $item)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $item->kategori->nama_kategori_soal }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a class="btn btn-warning" title="Detail">
                                                            <i></i>DETAIL
                                                        </a>
                                                        <a class="btn btn-warning" title="Edit">
                                                            <i></i>EDIT
                                                        </a>
                                                        <a class="btn btn-danger" title="Hapus">
                                                            <i></i>HAPUS
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach --}}
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
