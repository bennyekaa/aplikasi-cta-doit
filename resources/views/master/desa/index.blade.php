@extends('layout.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Master Desa</h1>
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
                                <a href="{{ url('master/desa/tambah') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Desa</a>
                            </div>
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kecamatan</th>
                                            <th>Kode Desa</th>
                                            <th>Nama Desa</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($desa as $key => $d)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $d->kecamatan->nama_kecamatan ?? '-' }}</td>
                                                <td>{{ $d->kode_desa }}</td>
                                                <td>{{ $d->nama_desa }}</td>
                                                <td>
                                                    <a href="{{ url('master/desa/edit/' . $d->id_desa) }}" class="btn btn-warning btn-sm">Edit</a>
                                                    <a href="{{ url('master/desa/hapus/' . $d->id_desa) }}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</a>
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
