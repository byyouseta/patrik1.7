@if (!empty(Auth::user()->username))
    <script>
        window.location = "/home";
    </script>
@else
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="icon" href="{{ asset('adminlte/dist/img/LogoRSUP.png') }}">
        <title>PATRIK (Rapat Elektronik) Login Page</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="{{ asset('/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('/adminlte/bower_components/font-awesome/css/font-awesome.min.css') }}">
        <!-- Ionicons -->
        <link rel="stylesheet" href="{{ asset('/adminlte/bower_components/Ionicons/css/ionicons.min.css') }}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('/adminlte/dist/css/AdminLTE.min.css') }}">
        <!-- iCheck -->
        <link rel="stylesheet" href="{{ asset('/adminlte/plugins/iCheck/square/blue.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/custom.css') }}">
        <script type="text/javascript" src="{{ asset('/js/jquery.js') }}"></script>

        <!-- Google Font -->
        <link rel="stylesheet"
            href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
            <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
    </head>

    <body class="hold-transition login-page bg">
        <div class="login-box">

            <!-- /.login-logo -->
            <div class="login-box-body">
                <div class="login-logo">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="{{ asset('adminlte/dist/img/Logo.png') }}" alt="logo" />
                        </div>
                        <div class="col-md-8">
                            <p class="text-center" style="height: 15pt"><strong>P A T R I K</strong></p>
                            <h3 style="height: 5pt"><small>(Rapat Elektronik)</small></h3>
                            <h3 class="text-center"><strong>RSUP Surakarta</strong></h3>
                        </div>
                        {{-- <table class="table table-borderless text-left">
                    <tr><td rowspan="2">
                        <img src="{{asset('adminlte/dist/img/Logo.png')}}" alt="logo" />
                    </td>
                    <td>
                        <p class="text-center"><a href="#" ><strong>P A T R I K</strong></a></p>
                    </td></tr><tr><td>
                        <h5 class="text-center">Rapat Elektronik <strong>RSUP Surakarta</strong></h5>
                    </td>
                    </tr>
                </table> --}}

                    </div>
                </div>
                <div class="col-md-12 text-center">
                    <p>Silahkan masuk untuk memulai sesi Anda</p>
                </div>
                <form action="{{ route('login') }}" method="post">
                    @csrf
                    <div class="form-group has-feedback mt-5">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" id="email"
                                class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                                placeholder="NIP / alamat email" value="{{ old('email') }}">
                        </div>
                        @if ($errors->has('email'))
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group has-feedback">
                        <div class="input-group">
                            <span class="input-group-addon" id="mybutton" onclick="change()"><i
                                    class="fa fa-eye"></i></span>
                            <input type="password" id="password"
                                class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                name="password" placeholder="Password">

                        </div>

                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-xs-12">
                            <div class="form-group align-center">
                                <label for="captcha">Captcha</label>
                                {!! NoCaptcha::renderJs() !!}
                                <div style="width: 300px; margin: 0 auto;"> <!-- Atur lebar di sini -->
                                    {!! NoCaptcha::display() !!}
                                </div>
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                </span>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block btn-flat">Masuk</button>
                            <h5 class="text-center"><strong>atau</strong></h5>
                            <a href="/tamu" class="btn btn-warning btn-block btn-flat">Presensi sebagai Tamu</a>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

            </div>
            <!-- /.login-box-body -->
            <div class="login-box-footer">
                <h5 class="text-center"><strong>PATRIK v 1.7 <br> Copyright &copy; 2021 IT <a
                            href="https://rsupsurakarta.co.id/">RSUP Surakarta</a><br></strong>
                    All rights reserved.
            </div>
        </div>
        <!-- /.login-box -->


        <!-- jQuery 3 -->
        <script src="{{ asset('/adminlte/bower_components/jquery/dist/jquery.min.js') }}"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="{{ asset('/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <!-- iCheck -->
        <script src="{{ asset('/adminlte/plugins/iCheck/icheck.min.js') }}"></script>
        <script>
            $(function() {
                $('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%' /* optional */
                });
            });
        </script>
        <script type="text/javascript">
            function change() {
                var x = document.getElementById('password').type;

                if (x == 'password') {
                    document.getElementById('password').type = 'text';
                    document.getElementById('mybutton').innerHTML = '<i class="fa fa-eye-slash"></i>';
                } else {
                    document.getElementById('password').type = 'password';
                    document.getElementById('mybutton').innerHTML = '<i class="fa fa-eye"></i>';
                }
            }
        </script>
        </div>
    </body>

    </html>
@endif
