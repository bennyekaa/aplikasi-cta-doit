@extends('layout.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Tambah Desa</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <form action="{{ url('master/desa/proses') }}" method="post">
                                @csrf
                                <input type="hidden" name="fungsi" value="Tambah">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Kecamatan</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="id_kecamatan" required>
                                                <option value="">-- Pilih Kecamatan --</option>
                                                @foreach($kecamatan as $kec)
                                                    <option value="{{ $kec->id_kecamatan }}">{{ $kec->nama_kecamatan }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Kode Desa</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="kode_desa" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Nama Desa</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="nama_desa" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Latitude <small class="text-muted">(Opsional)</small></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="latitude" placeholder="Contoh: -7.7956">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Longitude <small class="text-muted">(Opsional)</small></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="longitude" placeholder="Contoh: 112.8252">
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
