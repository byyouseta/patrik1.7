<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                @if (isset(Auth::user()->foto))
                    <img src="{{ asset('foto_profil/' . Auth::user()->foto) }}" class="img-circle" alt="User Image">
                @else
                    <img src="{{ asset('adminlte/dist/img/avatar-default.png') }}" class="img-circle" alt="User Image">
                @endif
            </div>
            <div class="pull-left info">
                <p>Welcome</p>
                <p><b>{{ Auth::user()->name }}</b></p>
                <!-- Status -->
                <!-- Kita tidak pakai
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            Kita tidak pakai status-->
            </div>
        </div>

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN MENU</li>
            <!-- Optionally, you can add icons to the links | Mengambil data session-->

            @if (session()->get('halaman') == 'home')
                <li class="active">
                @else
                <li>
            @endif
            <a href="/home"><i class="fa fa-home"></i> <span>Home</span></a></li>
            @if (Route::is('agenda.*') || Route::is('presensi.*') || Route::is('timeline.*'))
                <li class="treeview active">
                @else
                <li class="treeview">
            @endif
            <a href="#"><i class="fa fa-calendar"></i> <span>Agenda</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span></a>
            <ul class="treeview-menu">
                <li class="{{ Route::is('agenda.*') ? 'active' : '' }}"><a href="/agenda"><i
                            class="fa fa-calendar-check-o"></i> <span>Agenda</span></a></li>
                <li class="{{ Route::is('presensi.*') ? 'active' : '' }}"><a href="/presensi"><i
                            class="fa fa-sign-in"></i> <span>Presensi</span></a></li>
                <li class="{{ Route::is('timeline.*') ? 'active' : '' }}"><a href="/timeline"><i
                            class="fa fa-television"></i> <span>Timeline</span></a></li>
            </ul>
            </li>

            @if (Auth::user()->level == 'admin')
                @if (session()->get('halaman') == 'master')
                    <li class="treeview active">
                    @else
                    <li class="treeview">
                @endif
                <a href="#"><i class="fa fa-database"></i> <span>Master Data</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Route::is('unit.*') ? 'active' : '' }}"><a href="/unit"><i class="fa fa-users"></i>
                            <span>Unit</span></a></li>
                    <li class="{{ Route::is('pegawai.*') ? 'active' : '' }}"><a href="/pegawai"><i
                                class="fa fa-user"></i> <span>Pegawai</span></a></li>
                    <li class="{{ Route::is('ruangan.*') ? 'active' : '' }}"><a href="/ruangan"><i
                                class="fa fa-building-o"></i> <span>Ruangan</span></a></li>
                </ul>
                </li>
            @endif
            @if (session()->get('halaman') == 'profil')
                <li class="active">
                @else
                <li>
            @endif
            <a href="/profil"><i class="fa fa-user"></i> <span>Profil</span></a></li>
            @if (session()->get('halaman') == 'about')
                <li class="active">
                @else
                <li>
            @endif
            <a href="/about"><i class="fa fa-bullhorn"></i> <span>About</span></a></li>
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
