@extends('layout.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Kecamatan</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <form action="{{ url('master/kecamatan/proses') }}" method="post">
                                @csrf
                                <input type="hidden" name="fungsi" value="Edit">
                                <input type="hidden" name="id_kecamatan" value="{{ $kecamatan->id_kecamatan }}">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Kode Kecamatan</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="kode_kecamatan" value="{{ $kecamatan->kode_kecamatan }}" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Nama Kecamatan</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="nama_kecamatan" value="{{ $kecamatan->nama_kecamatan }}" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Latitude <small class="text-muted">(Opsional)</small></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="latitude" value="{{ $kecamatan->latitude }}" placeholder="Contoh: -7.7956">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Longitude <small class="text-muted">(Opsional)</small></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="longitude" value="{{ $kecamatan->longitude }}" placeholder="Contoh: 112.8252">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
