@extends('layout.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Backup & Restore Database</h1>
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
                                <h3 class="card-title">Backup Data</h3>
                            </div>
                            
                            @if(session('success'))
                                <div class="alert alert-success m-3">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger m-3">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <div class="card-body">
                                <p>Fasilitas ini digunakan untuk mem-backup seluruh data sistem (database). Silakan simpan file backup ini di tempat yang aman.</p>
                                <a href="{{ url('backup-restore/backup') }}" class="btn btn-primary">
                                    <i class="fas fa-download"></i> Unduh Backup Database (.sql)
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title">Restore Data</h3>
                            </div>
                            
                            <form action="{{ url('backup-restore/restore') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <p class="text-danger"><b>Peringatan!</b> Melakukan restore akan menimpa seluruh data saat ini dengan data dari file backup. Lakukan dengan hati-hati.</p>
                                    
                                    @error('backup_file')
                                        <div class="text-danger mb-2">{{ $message }}</div>
                                    @enderror

                                    <div class="form-group">
                                        <label>File Backup (.sql)</label>
                                        <input type="file" name="backup_file" class="form-control" accept=".sql" required>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-warning" onclick="return confirm('Apakah Anda yakin ingin melakukan restore? Data saat ini akan ditimpa dan tidak bisa dikembalikan!')">
                                        <i class="fas fa-upload"></i> Restore Database
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
