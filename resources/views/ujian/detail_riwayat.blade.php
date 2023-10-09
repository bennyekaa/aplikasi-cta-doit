@extends('layout.ujian.app')
@section('content')
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="col-sm-6">
                        <a class="btn btn-warning" href="{{session('riwayat')}}">
                            <i></i>KEMBALI
                        </a>
                    </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">DETAIL NILAI</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <th>#</th>
                                    <th>MODUL</th>
                                    <th>NILAI</th>
                                    <th>PASSING GRADE</th>
                                    <th>HASIL</th>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($kelompok_nilai as $item)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $item->nama_modul }}</td>
                                            <td>{{ $item->jumlah }}</td>
                                            <td>{{ $item->passing_grade }}</td>
                                            <td>
                                                @if ($item->jumlah >= $item->passing_grade)
                                                    <button class="btn btn-success disabled">LULUS</button>
                                                @else
                                                    <button class="btn btn-danger disabled">TIDAK LULUS</button>
                                                @endif
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

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title m-0">NILAI TOTAL DAN PEMBAHASAN</h5>
                        </div>
                        <div class="card-body">
                            <a href="{{ url('ujian/pembahasan') }}/{{decrypt($id_ujian)}}/1/{{ $id_kategori }}"
                                class="btn btn-primary">PEMBAHASAN</a>
                            <h6 class="card-title"><button
                                    class="btn btn-warning disabled">{{ $total[0]->jumlah }}/{{ $nilai_max }}</button>
                            </h6>

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
    <!-- /.content-wrapper -->
@endsection
