@extends('layout.app')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Soal</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Master</a></li>
                            <li class="breadcrumb-item active">Soal</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Import Soal</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="{{ url('master/soal/import') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="fungsi" value="Import">
                                <div class="card-body">
                                    <div class="form-group">
                                        <select class="custom-select rounded-0" name="kategor1.42i">
                                            <option>--Pilih Kategori--</option>
                                            @foreach ($kategori as $item)
                                                <option value="{{$item->id_kategori_soal}}">{{$item->nama_kategori_soal}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="file" class="col-md-4 col-form-label text-md-end">Pilih File</label>
                                        <div class="col-md-6">
                                            <input type="file" class="form-control-file" id="data_file" name="data_file"
                                                accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                                                onchange="return fileValidation()">
                                        </div>
                                    </div>

                                    <!-- /.card-body -->

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Upload</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->

                    </div>
                    <!--/.col (left) -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->
@endsection
@section('tambahanjs')
    <script type="text/javascript">
        function fileValidation() {
            var fileInput =
                document.getElementById('data_file');

            var filePath = fileInput.value;

            // Allowing file type
            var allowedExtensions =
                /(\.xls|\.xlsx)$/i;

            if (!allowedExtensions.exec(filePath)) {
                alert('Type File tidak sesuai!!!');
                fileInput.value = '';
                return false;
            } else {
                // Image preview
                if (fileInput.files && fileInput.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById(
                                'imagePreview').innerHTML =
                            '<img src="' + e.target.result +
                            '"/>';
                    };

                    reader.readAsDataURL(fileInput.files[0]);
                }
            }
        };
    </script>
@endsection
