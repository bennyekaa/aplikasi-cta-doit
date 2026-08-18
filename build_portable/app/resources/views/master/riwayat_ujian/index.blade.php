@extends('layout.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Riwayat Ujian</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Daftar Hasil Ujian Peserta</h3>
                            </div>
                            <div class="card-body">
                                @if(session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Peserta</th>
                                            <th>Username</th>
                                            <th>Modul Ujian</th>
                                            <th>Waktu Mulai</th>
                                            <th>Waktu Selesai</th>
                                            <th>Status</th>
                                            <th>Nilai</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($exams as $key => $exam)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $exam->nama_peserta }}</td>
                                                <td>{{ $exam->username }}</td>
                                                <td>{{ $exam->nama_modul }}</td>
                                                <td>{{ $exam->waktu_mulai ? date('d M Y H:i:s', strtotime($exam->waktu_mulai)) : '-' }}</td>
                                                <td>{{ $exam->waktu_selesai ? date('d M Y H:i:s', strtotime($exam->waktu_selesai)) : '-' }}</td>
                                                <td>
                                                    @if($exam->status == 1)
                                                        <span class="badge badge-success">Selesai</span>
                                                    @elseif($exam->status == 0)
                                                        <span class="badge badge-warning">Berjalan</span>
                                                    @else
                                                        <span class="badge badge-secondary">{{ $exam->status }}</span>
                                                    @endif
                                                </td>
                                                <td><span class="font-weight-bold">{{ $exam->nilai ?? 0 }}</span></td>
                                                <td>
                                                    <a href="{{ url('master/riwayat_ujian/detail/' . encrypt($exam->id)) }}" class="btn btn-sm btn-info" title="Detail Koreksi">
                                                        <i class="fas fa-eye"></i> Detail
                                                    </a>
                                                    <a href="{{ url('master/riwayat_ujian/cetak/' . encrypt($exam->id)) }}" target="_blank" class="btn btn-sm btn-secondary" title="Cetak Hasil">
                                                        <i class="fas fa-print"></i> Cetak
                                                    </a>
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
        </div>
    </div>
@endsection
