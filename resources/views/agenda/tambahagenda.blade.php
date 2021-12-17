@extends('layouts.app')

<!-- isi bagian judul halaman -->
<!-- cara penulisan isi section yang pendek -->
@section('judul_halaman', 'Daftar Agenda')


<!-- isi bagian konten -->
<!-- cara penulisan isi section yang panjang -->
@section('konten')
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Tambah Agenda</h3>
                </div>
                <!-- /.box-header -->
                <form role="form" action="/agenda/tambahagenda" method="post">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="col-md-6">

                            <!-- text input -->
                            <div class="form-group">
                                <label>Nama Agenda</label>
                                <input type="text" class="form-control" placeholder="Masukkan Nama Agenda"
                                    name="nama_agenda" value="{{ old('nama_agenda') }}">
                                @if ($errors->has('nama_agenda'))
                                    <div class="text-danger">
                                        {{ $errors->first('nama_agenda') }}
                                    </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Ruangan</label>
                                <select class="form-control" name="ruangan">
                                    <option value="" selected>Pilih</option>
                                    @foreach ($ruangan as $r)
                                        <option value="{{ $r->id }}">{{ $r->nama }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('ruangan'))
                                    <div class="text-danger">
                                        {{ $errors->first('ruangan') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Keterangan</label>
                                <textarea class="form-control" rows="3" placeholder="Masukkan Keterangan"
                                    name="keterangan">{{ old('keterangan') }}</textarea>
                                @if ($errors->has('keterangan'))
                                    <div class="text-danger">
                                        {{ $errors->first('keterangan') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Pengundang Acara</label>
                                <select class="form-control select2 " name="pengundang">
                                    <option value="">Pilih</option>
                                    @foreach ($pengundang as $p)
                                        <option value="{{ $p->id }}"
                                            {{ old('pengundang') == $p->id ? 'selected' : '' }}>{{ $p->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('pengundang'))
                                    <div class="text-danger">
                                        {{ $errors->first('pengundang') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal:</label>

                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right" id="datepicker" name="tanggal"
                                        autocomplete="off" value="{{ old('tanggal') }}">
                                </div>
                                <!-- /.input group -->
                                @if ($errors->has('tanggal'))
                                    <div class="text-danger">
                                        {{ $errors->first('tanggal') }}
                                    </div>
                                @endif
                            </div>

                            <div class="bootstrap-timepicker">
                                <div class="form-group">
                                    <label>Waktu Mulai:</label>

                                    <div class="input-group">
                                        <input type="text" class="form-control timepicker" name="waktu_mulai"
                                            value="{{ old('waktu_mulai') }}">

                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                    </div>
                                    <!-- /.input group -->
                                </div>
                                <!-- /.form group -->
                                @if ($errors->has('waktu_mulai'))
                                    <div class="text-danger">
                                        {{ $errors->first('waktu_mulai') }}
                                    </div>
                                @endif
                            </div>

                            <div class="bootstrap-timepicker">
                                <div class="form-group">
                                    <label>Waktu Selesai:</label>

                                    <div class="input-group">
                                        <input type="text" class="form-control timepicker" name="waktu_selesai"
                                            value="{{ old('waktu_selesai') }}">

                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                    </div>
                                    <!-- /.input group -->
                                </div>
                                <!-- /.form group -->
                                @if ($errors->has('waktu_selesai'))
                                    <div class="text-danger">
                                        {{ $errors->first('waktu_selesai') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <a href="/agenda" class="btn btn-warning">Kembali</a>
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
