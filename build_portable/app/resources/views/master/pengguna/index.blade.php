@extends('layout.app')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Data Pengguna</h1>
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
                                <a href="{{ url('master/pengguna/tambah') }}" class="btn btn-sm btn-primary float-right">Tambah Pengguna</a>
                                <button type="button" class="btn btn-sm btn-success float-right mr-2" data-toggle="modal" data-target="#modal-import">Import Excel</button>
                                <a href="{{ url('master/pengguna/template') }}" class="btn btn-sm btn-info float-right mr-2">Download Template</a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Username</th>
                                            <th>Nama Lengkap</th>
                                            <th>Jabatan</th>
                                            <th>Wilayah (Kec/Desa)</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($pengguna as $p)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $p->username }}</td>
                                                <td>{{ $p->nama_lengkap }}</td>
                                                <td>{{ $p->jabatan->nama_jabatan ?? '-' }}</td>
                                                <td>
                                                    @if($p->desa)
                                                        {{ $p->desa->kecamatan->nama_kecamatan ?? '-' }} / 
                                                        {{ $p->desa->nama_desa ?? '-' }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a class="btn btn-secondary"
                                                            href="{{ url('master/pengguna/password') }}/{{ encrypt($p->id_user) }}"
                                                            title="Reset Password">
                                                            <i></i>RESET
                                                        </a>
                                                        <a class="btn btn-warning"
                                                            href="{{ url('master/pengguna/edit') }}/{{ encrypt($p->id_user) }}"
                                                            title="Edit">
                                                            <i></i>EDIT
                                                        </a>
                                                        <a class="btn btn-danger alert_notif"
                                                            href="{{ url('master/pengguna/hapus') }}/{{ encrypt($p->id_user) }}"
                                                            title="Hapus">
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

            <!-- Modal Import -->
            <div class="modal fade" id="modal-import">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ url('master/pengguna/import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-header">
                                <h4 class="modal-title">Import Data Pengguna</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="file_excel">File Excel</label>
                                    <input type="file" class="form-control-file" id="file_excel" name="file_excel" required accept=".xls,.xlsx,.csv">
                                    <small class="text-muted">Gunakan template yang disediakan. Pastikan nama Jabatan dan Desa diketik sesuai referensi agar tersambung.</small>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Import</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->
@endsection
