@extends('layout.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Jabatan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('master/jabatan/index') }}">Jabatan</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">Form Edit Jabatan</h3>
                        </div>
                        <form action="{{ url('master/jabatan/proses') }}" method="post">
                            @csrf
                            <input type="hidden" name="fungsi" value="Edit">
                            <input type="hidden" name="id_jabatan" value="{{ encrypt($jabatan->id_jabatan) }}">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Pilih Modul Ujian</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="id_modul" required>
                                            <option value="">-- Pilih Modul --</option>
                                            @foreach($modul as $m)
                                                <option value="{{ $m->id_modul }}" {{ $jabatan->id_modul == $m->id_modul ? 'selected' : '' }}>{{ $m->nama_modul }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Kode Jabatan</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="kode_jabatan" value="{{ $jabatan->kode_jabatan }}" placeholder="Kode Jabatan" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Nama Jabatan</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="nama_jabatan" value="{{ $jabatan->nama_jabatan }}" placeholder="Nama Jabatan" required>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-warning float-right">Simpan Perubahan</button>
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
