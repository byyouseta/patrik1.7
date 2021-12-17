<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="{{ asset('adminlte/dist/img/LogoRSUP.png') }}">
    <title>PATRIK (Rapat Elektronik) RSUP Surakarta</title>

    <style>
        body {
            font: normal 100.01%/1.375 "Helvetica Neue", Helvetica, Arial, sans-serif;
        }

    </style>
    <link href="{{ asset('/css/jquery.signaturepad.css') }}" rel="stylesheet">

    <!--[if lt IE 9]><script src="../assets/flashcanvas.js"></script><![endif]-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('/adminlte/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('/adminlte/bower_components/Ionicons/css/ionicons.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('/adminlte/dist/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/custom.css') }}">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
</head>

<body class="hold-transition register-page bg">
    <section class="register-box">
        <div class="row">
            @if ($message = Session::get('sukses'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>{{ $message }}</strong>
                </div>
            @endif
            @if ($message = Session::get('gagal'))
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>{{ $message }}</strong>
                </div>
            @endif
            @if ($message = Session::get('info'))
                <div class="alert alert-info alert-block">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>{{ $message }}</strong>
                </div>
            @endif
            @if (count($errors) > 0)
                <div class="alert alert-info alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert"
                        aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <!-- left column -->
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="text-center">Detail Rapat</h3>
                    </div>
                    <div class="box-body no-padding">
                        <table class="table table-striped ">
                            <tr>
                                <td style="width: 5%"></td>
                                <th style="width: 25%">Nama Rapat</th>
                                <td style="width: 65%">
                                    {{ $cek->nama_agenda }}
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 5%"></td>
                                <th>Tanggal</th>
                                <td>
                                    {{ $cek->tanggal }}
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 5%"></td>
                                <th>Waktu</th>
                                <td>
                                    {{ $cek->waktu_mulai . ' - ' . $cek->waktu_selesai }}
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 5%"></td>
                                <th>Tempat</th>
                                <td>
                                    {{ $cek->nama_ruangan }}
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 5%"></td>
                                <th>Keterangan</th>
                                <td>
                                    {{ $cek->keterangan }}
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 5%"></td>
                                <th>PIC Rapat</th>
                                <td>
                                    {{ $cek->pic_name }}
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 5%"></td>
                                <th>Pengundang Rapat</th>
                                <td>
                                    {{ $cek->pengundang }}
                                </td>
                            </tr>

                        </table>
                    </div>
                    <div class="box-footer">
                        <table class="table table-borderless">
                            <tr>

                                {{-- <th class="text-right" style="width: 50%">Nama Peserta </th>
                                <td class="text-left" style="width: 50%">
                                    {{ $cek->name }}
                                </td> --}}
                                <th colspan="2" class="text-center"> Status Anda </th>
                            </tr>
                            <tr>

                                <th class="text-right" style="width: 50%">Status Presensi</th>
                                <td class="text-left" style="width: 50%">
                                    {{-- {{ $cek->presensi }} --}}
                                    @if ($cek->presensi == 'sudah')
                                        <span class="label label-success">{{ $cek->presensi }}</span>
                                    @else
                                        <span class="label label-danger">{{ $cek->presensi }}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>

                                <th class="text-right" style="width: 50%">Waktu Presensi</th>
                                <td class="text-left" style="width: 50%">
                                    {{ $cek->waktu_presensi }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!-- /.box -->
                <!-- /.box-body -->
            </div>
        </div>
    </section>

    <script src="{{ asset('/js/jquery.signaturepad.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.sigPad').signaturePad();
        });
    </script>
    <script src="{{ asset('/js/json2.min.js') }}"></script>
</body>
