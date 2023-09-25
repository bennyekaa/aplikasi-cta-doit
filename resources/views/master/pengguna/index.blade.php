@extends('layout.app')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>DataTables</h1>
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
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Pengguna</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <th>#</th>
                                        <th>USERNAME</th>
                                        <th>EMAIL</th>
                                        <th>NAMA LENGKAP</th>
                                        <th>JENIS KELAMIN</th>
                                        <th>TELEPON/HP</th>
                                        <th>ALAMAT</th>
                                        <th>TANGGAL BERLANGGANAN</th>
                                        <th></th>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($pengguna as $item)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $item->username }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td>{{ $item->nama_lengkap }}</td>
                                                <td>{{ $item->jk }}</td>
                                                <td>{{ $item->telepon }}</td>
                                                <td>{{ $item->alamat }}</td>
                                                <td>{{ $item->tanggal_aktif }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a class="btn btn-secondary" href="{{url('master/pengguna/jadwal')}}/{{encrypt($item->id_user)}}" title="Atur Jadwal">
                                                            <i></i>JADWAL
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
