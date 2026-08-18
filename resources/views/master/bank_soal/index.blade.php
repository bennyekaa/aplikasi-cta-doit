@extends('layout.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Data Bank Soal</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Master</a></li>
                            <li class="breadcrumb-item active">Bank Soal</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Bank Soal</h3>
                            </div>
                            <div class="card-body">
                                <form method="GET" action="{{ url('master/bank_soal/index') }}" class="mb-4">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Filter Modul</label>
                                            <select name="filter_modul" id="filter_modul" class="form-control" onchange="document.getElementById('filter_tematik').value=''; this.form.submit()">
                                                <option value="">-- Semua Modul --</option>
                                                @foreach ($modul as $m)
                                                    <option value="{{ $m->id_modul }}" {{ $filter_modul == $m->id_modul ? 'selected' : '' }}>{{ $m->nama_modul }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Filter Tematik</label>
                                            <select name="filter_tematik" id="filter_tematik" class="form-control" onchange="this.form.submit()" {{ empty($filter_modul) ? 'disabled' : '' }}>
                                                <option value="">-- {{ empty($filter_modul) ? 'Pilih Modul Terlebih Dahulu' : 'Semua Tematik' }} --</option>
                                                @foreach ($tematik as $t)
                                                    <option value="{{ $t->id_kategori }}" {{ $filter_tematik == $t->id_kategori ? 'selected' : '' }}>{{ $t->nama_tematik }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 d-flex align-items-end">
                                            <a href="{{ url('master/bank_soal/index') }}" class="btn btn-secondary">Reset Filter</a>
                                        </div>
                                    </div>
                                </form>

                                <div class="mb-3 d-flex">
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-import">
                                        <i></i> IMPORT EXCEL
                                    </button>
                                    <button type="button" class="btn btn-danger ml-2" id="btn-hapus-terpilih" style="display:none;">
                                        Hapus Terpilih
                                    </button>
                                </div>
                                <form id="form-bulk-delete" action="{{ url('master/bank_soal/hapus-bulk') }}" method="post">
                                    @csrf
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="select-all"></th>
                                            <th>#</th>
                                            <th>MODUL</th>
                                            <th>TEMATIK</th>
                                            <th>SOAL</th>
                                            <th>OPSI A</th>
                                            <th>OPSI B</th>
                                            <th>OPSI C</th>
                                            <th>OPSI D</th>
                                            <th>OPSI E</th>
                                            <th>KUNCI</th>
                                            <th>AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $i = 1; @endphp
                                        @foreach ($soal as $item)
                                            <tr>
                                                <td><input type="checkbox" name="ids[]" value="{{ $item->id }}" class="row-checkbox"></td>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $item->modul->nama_modul ?? '-' }}</td>
                                                <td>{{ $item->tematik->nama_tematik ?? '-' }}</td>
                                                <td>{{ $item->soal }}</td>
                                                <td>{{ $item->opsi_a }}</td>
                                                <td>{{ $item->opsi_b }}</td>
                                                <td>{{ $item->opsi_c }}</td>
                                                <td>{{ $item->opsi_d }}</td>
                                                <td>{{ $item->opsi_e }}</td>
                                                <td>{{ $item->kunci }}</td>
                                                <td>
                                                    <a class="btn btn-danger btn-sm" title="Hapus" href="{{url('master/bank_soal/hapus')}}/{{encrypt($item->id)}}" onclick="return confirm('Yakin hapus soal ini?')">
                                                        HAPUS
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Modal Import -->
    <div class="modal fade" id="modal-import">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Import Bank Soal</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('master/bank_soal/import') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Pilih Modul</label>
                            <select name="id_modul" id="id_modul" class="form-control" required>
                                <option value="">-- Pilih Modul --</option>
                                @foreach ($modul as $m)
                                    <option value="{{ $m->id_modul }}">{{ $m->nama_modul }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Pilih Tematik</label>
                            <select name="id_tematik" id="id_tematik" class="form-control" required>
                                <option value="">-- Pilih Tematik --</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>File Excel</label>
                            <input type="file" name="data_file" class="form-control" required accept=".xlsx, .xls, .csv">
                            <small class="text-danger">*Pastikan format sesuai template.</small>
                        </div>
                        <div class="form-group">
                            <a href="{{ url('master/bank_soal/template') }}" class="btn btn-info btn-sm">Download Template Excel</a>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('tambahanjs')
<script>
    $(document).ready(function() {
        $('#id_modul').change(function() {
            var idModul = $(this).val();
            if(idModul) {
                $.ajax({
                    url: "{{ url('master/bank_soal/get-tematik') }}/" + idModul,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $('#id_tematik').empty();
                        $('#id_tematik').append('<option value="">-- Pilih Tematik --</option>');
                        $.each(data, function(key, value) {
                            $('#id_tematik').append('<option value="'+ value.id_kategori +'">'+ value.nama_tematik +'</option>');
                        });
                    }
                });
            } else {
                $('#id_tematik').empty();
                $('#id_tematik').append('<option value="">-- Pilih Tematik --</option>');
            }
        });

        // Toggle all checkboxes
        $('#select-all').click(function(event) {   
            if(this.checked) {
                $('.row-checkbox').each(function() {
                    this.checked = true;                        
                });
            } else {
                $('.row-checkbox').each(function() {
                    this.checked = false;                       
                });
            }
            toggleHapusButton();
        });

        // Toggle hapus button on individual checkbox click
        $('.row-checkbox').change(function() {
            toggleHapusButton();
            // Uncheck "select all" if one is unchecked
            if (!this.checked) {
                $('#select-all').prop('checked', false);
            }
            // Check "select all" if all are checked
            if ($('.row-checkbox:checked').length == $('.row-checkbox').length) {
                $('#select-all').prop('checked', true);
            }
        });

        function toggleHapusButton() {
            if ($('.row-checkbox:checked').length > 0) {
                $('#btn-hapus-terpilih').show();
            } else {
                $('#btn-hapus-terpilih').hide();
            }
        }

        $('#btn-hapus-terpilih').click(function() {
            if(confirm('Yakin hapus data yang dipilih?')) {
                $('#form-bulk-delete').submit();
            }
        });
    });
</script>
@endsection
