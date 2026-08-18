@extends('layout.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tambah Jabatan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('master/jabatan/index') }}">Jabatan</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Form Tambah Jabatan</h3>
                        </div>
                        <form action="{{ url('master/jabatan/proses') }}" method="post">
                            @csrf
                            <input type="hidden" name="fungsi" value="Tambah">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Pilih Modul Ujian</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="id_modul" required>
                                            <option value="">-- Pilih Modul --</option>
                                            @foreach($modul as $m)
                                                <option value="{{ $m->id_modul }}">{{ $m->nama_modul }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Kode Jabatan</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="kode_jabatan" placeholder="Kode Jabatan" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Nama Jabatan</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="nama_jabatan" placeholder="Nama Jabatan" required>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary float-right">Simpan</button>
                                <a href="{{ url('master/jabatan/index') }}" class="btn btn-default">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
