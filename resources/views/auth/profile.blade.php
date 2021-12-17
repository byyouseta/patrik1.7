@extends('layouts.app')

@section('judul_halaman')
    Profil {{ Auth::user()->name }}
@endsection
@section('konten')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Update Profile</h3>
                </div>
                {{-- @if ($message = Session::get('sukses'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif
                @if (count($errors) > 0)
                    <div class="alert alert-info alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fa fa-ban"></i> Alert!</h5>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif --}}
                <!-- /.box-header -->
                <form role="form" action="/profil/update/{{ Auth::user()->id }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="box-body">
                        <div class="col-md-12">
                            <div class="col-md-1">
                                @if (isset($user->foto))
                                    <img src="{{ asset('foto_profil/' . $user->foto) }}" class="img-circle"
                                        alt="User Image" style="height: 80px">
                                @else
                                    <img src="{{ asset('adminlte/dist/img/avatar-default.png') }}" class="img-circle"
                                        alt="User Image" style="height: 80px">
                                @endif
                            </div>
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="exampleInputFile">Ubah Profile</label>
                                    <input type="file" id="exampleInputFile" name="foto">

                                    <p class="help-block">File berbentuk jpeg/jpg/png dengan maksimal ukuran 200KB</p>
                                    @if ($errors->has('foto'))
                                        <div class="text-danger">
                                            {{ $errors->first('foto') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">

                            <!-- text input -->
                            <div class="form-group">
                                <label>NIP/ NO PIN Simadam</label>
                                <input type="text" class="form-control" value="{{ Auth::user()->username }}"
                                    name="username">
                                @if ($errors->has('username'))
                                    <div class="text-danger">
                                        {{ $errors->first('username') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Nama Pengguna</label>
                                <input type="text" class="form-control" value="{{ Auth::user()->name }}" name="name">
                                @if ($errors->has('name'))
                                    <div class="text-danger">
                                        {{ $errors->first('name') }}
                                    </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Kontak</label>
                                <input type="text" class="form-control" value="{{ $user->pegawai->no_hp }}" name="nohp">
                                @if ($errors->has('nohp'))
                                    <div class="text-danger">
                                        {{ $errors->first('nohp') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                <textarea class="form-control" name="alamat">{{ $user->pegawai->alamat }}</textarea>
                                @if ($errors->has('alamat'))
                                    <div class="text-danger">
                                        {{ $errors->first('alamat') }}
                                    </div>
                                @endif
                            </div>

                        </div>
                        <div class="col-md-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Email Pengguna</label>
                                <input type="text" class="form-control" value="{{ Auth::user()->email }}" name="email">
                                @if ($errors->has('email'))
                                    <div class="text-danger">
                                        {{ $errors->first('email') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Jabatan</label>
                                <input type="text" class="form-control" placeholder="Masukkan Jabatan" name="jabatan"
                                    value="{{ $user->pegawai->jabatan }}">
                                @if ($errors->has('jabatan'))
                                    <div class="text-danger">
                                        {{ $errors->first('jabatan') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Unit</label>
                                <select class="form-control select2" name="unit">
                                    <option value="">Pilih</option>
                                    @foreach ($unit as $u)
                                        <option value="{{ $u->id }}" @if ($u->id == $user->unit_id) selected @endif>
                                            {{ $u->nama_unit }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('unit'))
                                    <div class="text-danger">
                                        {{ $errors->first('unit') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Update Terakhir</label>
                                <input type="text" class="form-control"
                                    value="{{ \Carbon\Carbon::parse(Auth::user()->updated_at)->format('d M Y H:i:s') }}"
                                    disabled>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
