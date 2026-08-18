@extends('layout.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data Jabatan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Jabatan</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Data Jabatan</h3>
                            <a href="{{ url('master/jabatan/tambah') }}" class="btn btn-sm btn-primary float-right">Tambah Jabatan</a>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                            <table class="table table-bordered table-striped" id="example1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Jabatan</th>
                                        <th>Modul Ujian</th>
                                        <th>Nama Jabatan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jabatan as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->kode_jabatan }}</td>
                                        <td>{{ $item->modul->nama_modul ?? '-' }}</td>
                                        <td>{{ $item->nama_jabatan }}</td>
                                        <td>
                                            <a class="btn btn-sm btn-warning"
                                                href="{{ url('master/jabatan/edit') }}/{{ encrypt($item->id_jabatan) }}">Edit</a>
                                            <a class="btn btn-sm btn-danger"
                                                href="{{ url('master/jabatan/hapus') }}/{{ encrypt($item->id_jabatan) }}"
                                                onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">Hapus</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
