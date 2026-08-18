@extends('layout.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Pengaturan</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Pengaturan Aplikasi</h3>
                            </div>
                            
                            @if(session('success'))
                                <div class="alert alert-success m-3">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <form action="{{ url('pengaturan/proses') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Nama Aplikasi / Instansi</label>
                                        <input type="text" name="instansi" class="form-control" value="{{ $pengaturan->instansi ?? '' }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Logo</label>
                                        <input type="file" name="logo" class="form-control" accept="image/*">
                                        @if(isset($pengaturan) && $pengaturan->logo)
                                            <div class="mt-2">
                                                <img src="{{ asset('uploads/logo/' . $pengaturan->logo) }}" alt="Logo" style="max-height: 100px;">
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Jenis Font (Judul)</label>
                                        <select name="font_type" class="form-control">
                                            <option value="">-- Default --</option>
                                            <option value="'Source Sans Pro', sans-serif" {{ ($pengaturan->font_type ?? '') == "'Source Sans Pro', sans-serif" ? 'selected' : '' }}>Source Sans Pro</option>
                                            <option value="Arial, sans-serif" {{ ($pengaturan->font_type ?? '') == "Arial, sans-serif" ? 'selected' : '' }}>Arial</option>
                                            <option value="'Times New Roman', Times, serif" {{ ($pengaturan->font_type ?? '') == "'Times New Roman', Times, serif" ? 'selected' : '' }}>Times New Roman</option>
                                            <option value="'Courier New', Courier, monospace" {{ ($pengaturan->font_type ?? '') == "'Courier New', Courier, monospace" ? 'selected' : '' }}>Courier New</option>
                                            <option value="Tahoma, sans-serif" {{ ($pengaturan->font_type ?? '') == "Tahoma, sans-serif" ? 'selected' : '' }}>Tahoma</option>
                                            <option value="'Trebuchet MS', sans-serif" {{ ($pengaturan->font_type ?? '') == "'Trebuchet MS', sans-serif" ? 'selected' : '' }}>Trebuchet MS</option>
                                            <option value="Verdana, sans-serif" {{ ($pengaturan->font_type ?? '') == "Verdana, sans-serif" ? 'selected' : '' }}>Verdana</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Besar Font Judul (px)</label>
                                        <input type="number" name="font_size" class="form-control" value="{{ $pengaturan->font_size ?? '' }}" placeholder="Contoh: 24">
                                        <small class="text-muted">Kosongkan untuk menggunakan ukuran bawaan.</small>
                                    </div>
                                    <div class="form-group">
                                        <label>Preview Judul</label>
                                        <div class="p-3 border rounded" style="background-color: #f8f9fa; min-height: 80px; display: flex; align-items: center; justify-content: center;">
                                            <span id="font-preview" class="font-weight-light" style="{{ isset($pengaturan->font_type) ? 'font-family: '.$pengaturan->font_type.';' : '' }} {{ isset($pengaturan->font_size) ? 'font-size: '.$pengaturan->font_size.'px;' : '' }}">{{ $pengaturan->instansi ?? 'Aplikasi Ujian' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('tambahanjs')
<script>
    $(document).ready(function() {
        var $preview = $('#font-preview');
        var $fontType = $('select[name="font_type"]');
        var $fontSize = $('input[name="font_size"]');
        var $instansi = $('input[name="instansi"]');

        function updatePreview() {
            var type = $fontType.val();
            var size = $fontSize.val();
            var text = $instansi.val();
            
            if (type) {
                $preview.css('font-family', type);
            } else {
                $preview.css('font-family', '');
            }

            if (size) {
                $preview.css('font-size', size + 'px');
            } else {
                $preview.css('font-size', '');
            }

            if (text) {
                $preview.text(text);
            } else {
                $preview.text('Aplikasi Ujian');
            }
        }

        $fontType.on('change', updatePreview);
        $fontSize.on('input', updatePreview);
        $instansi.on('input', updatePreview);
    });
</script>
@endsection
