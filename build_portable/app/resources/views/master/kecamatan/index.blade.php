@extends('layout.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Master Kecamatan</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <a href="{{ url('master/kecamatan/tambah') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Kecamatan</a>
                            </div>
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Kecamatan</th>
                                            <th>Nama Kecamatan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($kecamatan as $key => $k)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $k->kode_kecamatan }}</td>
                                                <td>{{ $k->nama_kecamatan }}</td>
                                                <td>
                                                    <a href="{{ url('master/kecamatan/edit/' . $k->id_kecamatan) }}" class="btn btn-warning btn-sm">Edit</a>
                                                    <a href="{{ url('master/kecamatan/hapus/' . $k->id_kecamatan) }}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</a>
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
