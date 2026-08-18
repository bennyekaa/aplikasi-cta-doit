@extends('layout.app')

@section('tambahancss')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard v1</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $total_pengguna }}</h3>
                                <p>Total Pengguna</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person"></i>
                            </div>
                            <a href="{{ url('master/pengguna/index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $total_desa }}</h3>
                                <p>Total Desa</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-map"></i>
                            </div>
                            <a href="{{ url('master/desa/index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $total_kecamatan }}</h3>
                                <p>Total Kecamatan</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-location"></i>
                            </div>
                            <a href="{{ url('master/kecamatan/index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $total_soal }}</h3>
                                <p>Total Soal</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-clipboard"></i>
                            </div>
                            <a href="{{ url('master/bank_soal/index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
                <!-- /.row -->
                <!-- Main row -->
                <div class="row">
                    <section class="col-lg-12 connectedSortable">
                        <!-- Map card -->
                        <div class="card">
                            <div class="card-header border-0">
                                <h3 class="card-title">
                                    <i class="fas fa-map-marker-alt mr-1"></i>
                                    Peta Lokasi Desa & Kecamatan
                                </h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-sm" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="leaflet-map" style="height: 500px; width: 100%; z-index: 1;"></div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </section>
                </div>
                <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
        </section>
    </div>
@endsection

@section('tambahanjs')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    $(document).ready(function() {
        // Init Leaflet Map centered on Jawa Timur
        var map = L.map('leaflet-map').setView([-7.7956, 112.8252], 8);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        // Add Desa markers
        var desaList = @json($desa);
        desaList.forEach(function(desa) {
            if (desa.latitude && desa.longitude) {
                L.marker([desa.latitude, desa.longitude])
                 .addTo(map)
                 .bindPopup("<b>Desa:</b> " + desa.nama_desa);
            }
        });

        // Add Kecamatan markers
        var kecamatanList = @json($kecamatan);
        kecamatanList.forEach(function(kec) {
            if (kec.latitude && kec.longitude) {
                var marker = L.marker([kec.latitude, kec.longitude])
                 .addTo(map)
                 .bindPopup("<b>Kecamatan:</b> " + kec.nama_kecamatan);
                 // optional: make kecamatan marker different color if needed by using custom icon
            }
        });
    });
</script>
@endsection
