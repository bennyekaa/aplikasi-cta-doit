<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="{{asset('assets/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <a href="#" class="d-block">ADMIN</a>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            {{-- <li class="nav-item menu-open">
                <a href="#" class="nav-link active">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        Dashboard
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="./index.html" class="nav-link active">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Dashboard v1</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="./index2.html" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Dashboard v2</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="./index3.html" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Dashboard v3</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="pages/widgets.html" class="nav-link">
                    <i class="nav-icon fas fa-th"></i>
                    <p>
                        Widgets
                        <span class="right badge badge-danger">New</span>
                    </p>
                </a>
            </li> --}}
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-copy"></i>
                    <p>
                        Master
                        <i class="fas fa-angle-left right"></i>
                        <span class="badge badge-info right"></span>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{url('master/kategori/index')}}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Tematik</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{url('master/modul/index')}}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Modul</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{url('master/bank_soal/index')}}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Bank Soal</p>
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a href="{{url('master/soal/list')}}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Soal</p>
                        </a>
                    </li> --}}
                    <li class="nav-item">
                        <a href="{{url('master/pengguna/index')}}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Pengguna</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{url('master/jabatan/index')}}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Jabatan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('master/kecamatan/index') }}" class="nav-link {{ request()->is('master/kecamatan*') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Kecamatan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{url('master/desa/index')}}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Desa</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="{{url('master/riwayat_ujian/index')}}" class="nav-link">
                    <i class="nav-icon fas fa-history"></i>
                    <p>Riwayat Ujian</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{url('pengaturan')}}" class="nav-link">
                    <i class="nav-icon fas fa-cogs"></i>
                    <p>
                        Pengaturan
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{url('backup-restore')}}" class="nav-link">
                    <i class="nav-icon fas fa-database"></i>
                    <p>Backup & Restore</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{url('logout')}}" class="nav-link">
                    <i class="nav-icon fas fa-arrow-alt-circle-left"></i>
                    <p>
                        Log Out
                        <span class="badge badge-info right"></span>
                    </p>
                </a>
            </li>
    </nav>
    <!-- /.sidebar-menu -->
</div>
