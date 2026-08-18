@extends('layout.ujian.app')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">RIWAYAT TRYOUT</small></h1>
                    </div><!-- /.col -->
                    {{-- <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Layout</a></li>
                            <li class="breadcrumb-item active">Top Navigation</li>
                        </ol>
                    </div><!-- /.col --> --}}
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-sm-6">
                            <a class="btn btn-warning" href="{{ session('list') }}">
                                <i></i>KEMBALI
                            </a>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">PAKET SOAL</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <th>#</th>
                                        <th>PAKET</th>
                                        <th>WAKTU MULAI</th>
                                        <th>WAKTU SELESAI</th>
                                        <th></th>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($riwayat as $item)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $item->nama_kategori }}</td>
                                                <td>{{ $item->ujian_mulai }}</td>
                                                <td>{{ $item->ujian_selesai }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a class="btn btn-primary"
                                                            href="{{ url('ujian/detail/riwayat') }}/{{ encrypt($item->id_ujian) }}/{{ encrypt($item->id_kategori) }}"
                                                            title="Detail">
                                                            <i></i>PILIH
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
                    </div>
                    <!-- /.col-md-6 -->
                    <!-- /.col-md-6 -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
@endsection
