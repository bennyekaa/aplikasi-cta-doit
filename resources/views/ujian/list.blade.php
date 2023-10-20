@extends('layout.ujian.app')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">TRYOUT</small></h1>
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
                    <div class="col-lg-6">
                        @if (!empty($ujian_aktif) || session('list_ujian') == 'ada')
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title m-0">TRYOUT AKTIF</h5>
                                </div>
                                <div class="card-body">
                                    <h6 class="card-title">Anda Masih Memiliki Ujian yang belum Berakhir</h6>

                                    <p class="card-text"></p>
                                    <a href="{{url('ujian/mulai')}}/{{encrypt($ujian_aktif->id_kategori)}}/1/{{$ujian_aktif->id_ujian}}" class="btn btn-primary">Klik Disini Lanjutkan</a>
                                    <a href="{{url('ujian/selesai')}}/{{$ujian_aktif->id_ujian}}" class="btn btn-danger">Selesai</a>
                                </div>
                            </div>
                        @else
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
                                            <th>KETERANGAN</th>
                                            <th></th>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i = 1;
                                            @endphp
                                            @foreach ($kategori as $item)
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td>{{ $item->nama_kategori }}</td>
                                                    <td>{{ $item->keterangan }}</td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a class="btn btn-primary"
                                                                href="{{ url('ujian/detail') }}/{{ encrypt($item->id_kategori) }}"
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
                        @endif
                    </div>
                    <!-- /.col-md-6 -->

                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title m-0">RIWAYAT</h5>
                            </div>
                            <div class="card-body">
                                <h6 class="card-title">Riwayat pengerjaan Tryout</h6>

                                <p class="card-text"></p>
                                <a href="{{url('ujian/riwayat')}}" class="btn btn-primary">Klik Disini</a>
                            </div>
                        </div>

                    </div>

                    <!-- /.col-md-6 -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
@endsection
