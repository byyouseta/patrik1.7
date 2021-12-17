@extends('layouts.app')

<!-- isi bagian judul halaman -->
<!-- cara penulisan isi section yang pendek -->
@section('judul_halaman', 'Daftar Pegawai')


<!-- isi bagian konten -->
<!-- cara penulisan isi section yang panjang -->
@section('konten')
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Tambah Pegawai</h3>
                </div>
                <!-- /.box-header -->
                <form role="form" action="/pegawai/tambahpegawai" method="post">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="col-md-6">

                            <!-- text input -->
                            <div class="form-group">
                                <label>NIP/ Username</label>
                                <input type="text" class="form-control" placeholder="Masukkan NIP" name="username"
                                    value="{{ old('username') }}">
                                @if ($errors->has('username'))
                                    <div class="text-danger">
                                        {{ $errors->first('username') }}
                                    </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input type="text" class="form-control" placeholder="Masukkan Nama" name="name"
                                    value="{{ old('name') }}">
                                @if ($errors->has('name'))
                                    <div class="text-danger">
                                        {{ $errors->first('name') }}
                                    </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>No Handphone</label>
                                <input type="text" class="form-control" placeholder="Masukkan No Handphone" name="no_hp"
                                    value="{{ old('no_hp') }}">
                                @if ($errors->has('no_hp'))
                                    <div class="text-danger">
                                        {{ $errors->first('no_hp') }}
                                    </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Alamat</label>
                                <textarea class="form-control" rows="3" placeholder="Masukkan Alamat"
                                    name="alamat">{{ old('alamat') }}</textarea>
                                @if ($errors->has('alamat'))
                                    <div class="text-danger">
                                        {{ $errors->first('alamat') }}
                                    </div>
                                @endif
                            </div>


                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" placeholder="Masukkan Email" name="email"
                                    value="{{ old('email') }}">
                                @if ($errors->has('email'))
                                    <div class="text-danger">
                                        {{ $errors->first('email') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Hak Akses</label>
                                <select class="form-control" name="level">
                                    <option value="" selected>Pilih</option>
                                    <option value="user" {{ old('level') == 'user' ? 'selected' : '' }}>User</option>
                                    <option value="admin" {{ old('level') == 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                                @if ($errors->has('level'))
                                    <div class="text-danger">
                                        {{ $errors->first('level') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Jabatan</label>
                                <input type="text" class="form-control" placeholder="Masukkan Jabatan" name="jabatan"
                                    value="{{ old('jabatan') }}">
                                @if ($errors->has('jabatan'))
                                    <div class="text-danger">
                                        {{ $errors->first('jabatan') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Eselon (Optional)</label>
                                <select class="form-control" name="eselon">
                                    <option value="" selected>Pilih</option>
                                    <option value="1">Eselon I</option>
                                    <option value="2">Eselon III</option>
                                    <option value="3">Eselon IV</option>
                                </select>
                                @if ($errors->has('eselon'))
                                    <div class="text-danger">
                                        {{ $errors->first('eselon') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Unit</label>
                                <select class="form-control select2 " name="unit">
                                    <option value="">Pilih</option>
                                    @foreach ($unit as $u)
                                        <option value="{{ $u->id }}"
                                            {{ old('unit') == $u->id ? 'selected' : '' }}>
                                            {{ $u->nama_unit }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('unit'))
                                    <div class="text-danger">
                                        {{ $errors->first('unit') }}
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <a href="/pegawai" class="btn btn-warning">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
            @if (!empty($pesan))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $pesan }}</strong>
                </div>
            @endif
        </div>
    </div>
@endsection
