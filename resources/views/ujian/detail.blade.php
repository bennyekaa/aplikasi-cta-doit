@extends('layout.ujian.app')
@section('content')
<!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- /.col-md-6 -->
          <div class="col-lg-9" style="float:none;margin:auto;">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="m-0">TRYOUT {{$kategori->nama_kategori}}</h5>
              </div>
              <div class="card-body" style="text-align: center">
                <h6 class="card-title">DETAIL</h6>

                <p class="card-text">Waktu : {{$kategori->menit}} Menit</p>
                <p class="card-text">{{$kategori->keterangan}}</p>
                <a href="{{url('ujian/input')}}/{{encrypt($kategori->id_kategori)}}" class="btn btn-primary">MULAI</a>
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