<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="{{ asset('adminlte/dist/img/LogoRSUP.png') }}">
    <title>PATRIK (Rapat Elektronik) RSUP Surakarta</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{ asset('adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('adminlte/bower_components/Ionicons/css/ionicons.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect. -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/skins/skin-blue.min.css') }}">
    <!-- daterange picker -->
    <link rel="stylesheet"
        href="{{ asset('adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet"
        href="{{ asset('adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/timepicker/bootstrap-timepicker.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('adminlte/bower_components/select2/dist/css/select2.min.css') }}">
    {{-- SweetAlert2 --}}
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.min.css') }}" id="theme-styles">
    {{-- animate css --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
        .swal2-popup {
            font-size: 1.2rem !important;
        }

        /* This only changes this particular animation duration */
        .animate__animated.animate__swing {
            --animate-duration: 2s;
            /* --animate-repeat: 3; */
            /* --animation-iteration-count: infinite;
            --animation-timing-function: linear;
            --animation-delay: 0s; */
        }

    </style>

    @hasSection('head')
        @yield('head')
    @endif
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// 
        -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <!-- Main Header -->
        <header class="main-header">

            <!-- Logo -->
            <a href="/" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>A</b>LT</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><img src="{{ asset('adminlte/dist/img/LogoRSUP.png') }}"
                        alt="User Image">
                    <b>P A T R I K</b>
                    <small>RSUP Surakarta</small></span>
            </a>
            <script>
                function display_ct5() {
                    arrhari = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
                    arrbulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September",
                        "Oktober", "November", "Desember"
                    ];
                    var x = new Date();
                    hari = x.getDay();
                    bulan = x.getMonth();
                    var ampm = x.getHours() >= 12 ? ' PM' : ' AM';

                    var x1 = x.getDate() + "/" + arrbulan[bulan] + "/" + x.getFullYear();
                    x1 = arrhari[hari] + ", " + x1 + " " + x.getHours() + ":" + x.getMinutes() + ":" + x.getSeconds() + ampm;
                    document.getElementById('ct5').innerHTML = x1;
                    display_c5();
                }

                function display_c5() {
                    var refresh = 1000; // Refresh rate in milli seconds
                    mytime = setTimeout('display_ct5()', refresh)
                }
                display_c5()
            </script>
            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- Messages: style can be found in dropdown.less-->

                        <!-- Notifications: style can be found in dropdown.less -->
                        @if (\App\Agenda::pesan()->count() > 0)
                            <li class="dropdown notifications-menu">
                                <a href="#" class="dropdown-toggle animate__animated animate__swing animate__repeat-3"
                                    data-toggle="dropdown">
                                    <i class="fa fa-bell-o"></i>
                                    <span class="label label-warning">{{ \App\Agenda::pesan()->count() }}</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">Kamu memiliki {{ \App\Agenda::pesan()->count() }}
                                        agenda
                                        presensi</li>
                                    <li>
                                        <!-- inner menu: contains the actual data -->
                                        <ul class="menu">
                                            @foreach (\App\Agenda::pesan() as $item)
                                                <li>
                                                    <a href="/presensi">
                                                        <i class="fa fa-calendar text-aqua"></i>
                                                        {{ $item->nama_agenda }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                    <li class="footer"><a href="/presensi">Lihat</a></li>
                                </ul>
                            </li>
                        @endif


                        <!-- User Account Menu -->
                        <li class="dropdown user user-menu">
                            <!-- Menu Toggle Button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <!-- The user image in the navbar-->
                                <!-- Kita tidak menggunakan foto profil dl-->
                                <!--<img src="{{ asset('adminlte/dist/img/user2-160x160.jpg') }}" class="user-image" alt="User Image">
                Akhir foto profil-->
                                @if (isset(Auth::user()->foto))
                                    <img src="{{ asset('foto_profil/' . Auth::user()->foto) }}"
                                        class="user-image" alt="User Image">
                                @else
                                    <img src="{{ asset('adminlte/dist/img/avatar-default.png') }}"
                                        class="user-image" alt="User Image">
                                @endif
                                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                <span class="hidden-xs">{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- The user image in the menu -->
                                <li class="user-header">
                                    @if (isset(Auth::user()->foto))
                                        <img src="{{ asset('foto_profil/' . Auth::user()->foto) }}"
                                            class="img-circle" alt="User Image">
                                    @else
                                        <img src="{{ asset('adminlte/dist/img/avatar-default.png') }}"
                                            class="img-circle" alt="User Image">
                                    @endif

                                    <p>
                                        {{ Auth::user()->name }}
                                        <small><span id='ct5'></span></small>
                                    </p>
                                </li>

                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="/password" class="btn btn-default"><i class="fa fa-lock"></i>
                                            Password</a>
                                    </div>

                                    <div class="pull-right">
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="Submit" class="btn btn-default"><i class="fa fa-sign-out"></i>
                                                Logout</button>
                                        </form>
                                    </div>

                                </li>
                            </ul>
                        </li>
                        <!-- Control Sidebar Toggle Button -->
                        <!-- Kita tidak pakai
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
          Akhir dari tidak -->
                    </ul>
                </div>
            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        @include('layouts.sidebar')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>@yield('judul_halaman')

                </h1>
                <!-- Tidak dipakai
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol>
    Akhir tidak dipakai-->
            </section>

            <!-- Main content -->
            <section class="content container-fluid">

                <!--------------------------
        | Your Page Content Here |
        -------------------------->
                @yield('konten')

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        @include('layouts.footer')

        <!-- REQUIRED JS SCRIPTS -->

        <!-- jQuery 3 -->
        <script src="{{ asset('adminlte/bower_components/jquery/dist/jquery.min.js') }}"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="{{ asset('adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
        <!-- bootstrap datepicker -->
        <script src="{{ asset('adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}">
        </script>
        <!-- bootstrap time picker -->
        <script src="{{ asset('adminlte/plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
        <!-- Select2 -->
        <script src="{{ asset('adminlte/bower_components/select2/dist/js/select2.full.min.js') }}"></script>

        <script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
        {{-- <script>
            $(function() {

                @if (Session::has('sukses'))
                    Swal.fire({
                    icon: 'success',
                    title: 'Great!',
                    text: '{{ Session::get('sukses') }}'
                    })
                @endif
            });
        </script> --}}

        @if (session()->has('sukses'))
            <script>
                swal.fire({
                    title: "{{ __('Sukses!') }}",
                    text: "{{ Session::get('sukses') }}",
                    icon: "success",
                });
            </script>
        @endif

        @if (session()->has('sukses2'))
            <script>
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: false,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'success',
                    title: "{{ Session::get('sukses2') }}"
                })
            </script>
        @endif

        @if (session()->has('error'))
            <script>
                swal.fire({
                    title: "{{ __('Error!') }}",
                    text: "{{ Session::get('error') }}",
                    type: "error",
                    icon: "warning",
                });
            </script>
        @endif

        @if ($errors->any())
            <script>
                swal.fire({
                    title: "{{ __('Error dalam pengisian form!') }}",
                    text: "{{ implode(' ', $errors->all()) }}",
                    type: "error",
                    icon: "warning",
                });
            </script>
        @endif

        <script>
            $('.delete-confirm').on('click', function(event) {
                event.preventDefault();
                const url = $(this).attr('href');
                Swal.fire({
                    title: 'Apa kamu yakin?',
                    text: "Data akan dihapus dari sistem",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                })
            });
        </script>

        <script>
            $(function() {
                //Date picker
                $('#datepicker').datepicker({
                    format: "yyyy-mm-dd",
                    autoclose: true,
                    todayHighlight: true,
                    orientation: "auto"
                })

                //Timepicker
                $('.timepicker').timepicker({
                    timeFormat: 'hh:mm',
                    use24hours: true,
                    pickDate: false,
                    showInputs: false,
                    interval: 30,

                    pickTime: true,

                })

                //Initialize Select2 Elements
                $('.select2').select2()
            })
        </script>
        @hasSection('plugin')
            @yield('plugin')
        @endif
</body>

</html>
