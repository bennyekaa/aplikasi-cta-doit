@extends('layout.app')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Data Modul</h1>
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
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Modul</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="col-sm-6">
                                <a class="btn btn-primary" href="{{url('master/modul/tambah')}}">
                                    <i></i>TAMBAH
                                </a>
                            </div>
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <th>#</th>
                                        <th>MODUL</th>
                                        <th>KETERANGAN</th>
                                        <th>STATUS</th>
                                        <th></th>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($modul as $item)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $item->nama_modul }}</td>
                                                <td>{{ $item->keterangan }}</td>
                                                <td>
                                                    @if ($item->aktif == 0)
                                                        <a class="btn btn-danger disabled">
                                                            <i></i>Tidak Aktif
                                                        </a>
                                                    @else
                                                        <a class="btn btn-success disabled">
                                                            <i></i>Aktif
                                                        </a>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a class="btn btn-success" title="Aktifkan">
                                                            <i></i>AKTIF
                                                        </a>
                                                        <a class="btn btn-primary" title="NOn-Aktif">
                                                            <i></i>NON-AKTIF
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
