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
                                <a class="btn btn-primary" href="{{ url('master/soal/list') }}">
                                    <i></i>TAMBAH
                                </a>
                            </div>
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <th>#</th>
                                        <th>KATEGORI</th>
                                        <th>MODUL</th>
                                        <th>NOMOR</th>
                                        <th>SOAL</th>
                                        <th>PEMBAHASAN</th>
                                        <th>POIN A</th>
                                        <th>POIN B</th>
                                        <th>POIN C</th>
                                        <th>POIN D</th>
                                        <th>POIN E</th>
                                        <th></th>
                                    </thead>
                                    <tbody>
                                        {{-- @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($soal as $item)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $item->kategori->nama_kategori }}</td>
                                                <td>{{ $item->modul->nama_modul }}</td>
                                                <td>{{ $item->nomor }}</td>
                                                <td><img src="{{$item->soal}}" width="200" height="100"></td>
                                                <td><img src="{{$item->pembahasan}}" width="200" height="100"></td>
                                                <td>{{ $item->poin_a }}</td>
                                                <td>{{ $item->poin_b }}</td>
                                                <td>{{ $item->poin_c }}</td>
                                                <td>{{ $item->poin_d }}</td>
                                                <td>{{ $item->poin_e }}</td>
                                                <td>
                                                    <div class="btn-group">
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
