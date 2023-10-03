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
                                <h3 class="card-title">Tambah Soal</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="{{ url('master/soal/proses')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="fungsi" value="Tambah">
                                <div class="card-body">
                                    <input type="hidden" name="id_kategori" value="{{ $id_kategori }}">
                                    <div class="form-group">
                                        <label>MODUL SOAL</label>
                                        <select class="custom-select rounded-0" name="id_modul">
                                            <option>--Pilih Modul--</option>
                                            @foreach ($modul as $item)
                                                <option value="{{ $item->id_modul }}">{{ $item->nama_modul }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputFile">UPLOAD SOAL</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="soal"
                                                    accept="image/*" onchange="return fileValidation()" id="data_file">
                                                <label class="custom-file-label soal" for="exampleInputFile">Choose file</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputFile">UPLOAD PEMBAHASAN</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="pembahasan"
                                                    accept="image/*" onchange="return fileValidation1()" id="data_file1">
                                                <label class="custom-file-label pembahasan" for="exampleInputFile">Choose file</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>NOMOR SOAL</label>
                                        <input type="number" name="nomor" class="form-control" placeholder="NOMOR SOAL">
                                    </div>
                                    <div class="form-group">
                                        <label>POIN A</label>
                                        <input type="number" name="poin_a" class="form-control" placeholder="POIN A">
                                    </div>
                                    <div class="form-group">
                                        <label>POIN B</label>
                                        <input type="number" name="poin_b" class="form-control" placeholder="POIN B">
                                    </div>
                                    <div class="form-group">
                                        <label>POIN C</label>
                                        <input type="number" name="poin_c" class="form-control" placeholder="POIN C">
                                    </div>
                                    <div class="form-group">
                                        <label>POIN D</label>
                                        <input type="number" name="poin_d" class="form-control" placeholder="POIN D">
                                    </div>
                                    <div class="form-group">
                                        <label>POIN E</label>
                                        <input type="number" name="poin_e" class="form-control" placeholder="POIN E">
                                    </div>

                                    <!-- /.card-body -->

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">SIMPAN</button>
                                        <a class="btn btn-warning" type="reset" href="{{ url()->previous() }}">BATAL</a>
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
        $('#data_file').change(function(e) {
            var fileName = e.target.files[0].name;
            $('.soal').html(fileName);
        });
        $('#data_file1').change(function(e) {
            var fileName = e.target.files[0].name;
            $('.pembahasan').html(fileName);
        });

        function fileValidation() {
            var fileInput =
                document.getElementById('data_file');

            var filePath = fileInput.value;

            // Allowing file type
            var allowedExtensions =
                /(\.jpg|\.png)$/i;

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

        function fileValidation1() {
            var fileInput =
                document.getElementById('data_file1');

            var filePath = fileInput.value;

            // Allowing file type
            var allowedExtensions =
                /(\.jpg|\.png)$/i;

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
