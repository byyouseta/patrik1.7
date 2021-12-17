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
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit Agenda</h3>
                </div>
                <!-- /.box-header -->
                <form role="form" action="/agenda/update/{{ $agenda->id }}" method="post">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="col-md-6">

                            <!-- text input -->
                            <div class="form-group">
                                <label>Nama Agenda</label>
                                <input type="text" class="form-control" placeholder="Masukkan Nama Agenda"
                                    name="nama_agenda" value="{{ $agenda->nama_agenda }}">
                                @if ($errors->has('nama_agenda'))
                                    <div class="text-danger">
                                        {{ $errors->first('nama_agenda') }}
                                    </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Ruangan</label>
                                <select class="form-control" name="ruangan">
                                    <option value="">Pilih</option>
                                    @foreach ($ruangan as $r)
                                        <option value="{{ $r->id }}" @if ($r->id == $agenda->ruangan_id) selected @endif> {{ $r->nama }}</option>
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
                                    name="keterangan">{{ $agenda->keterangan }}</textarea>
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
                                            {{ $agenda->pengundang == $p->name ? 'selected' : '' }}>{{ $p->name }}
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
                                        autocomplete="off" value="{{ $agenda->tanggal }}">
                                </div>
                                <!-- /.input group -->
                                @if ($errors->has('tanggal'))
                                    <div class="text-danger">
                                        {{ $errors->first('tanggal') }}
                                    </div>
                                @endif
                            </div>
                            <?php
                            $waktu_mulai = new DateTime($agenda->waktu_mulai);
                            $waktu_selesai = new DateTime($agenda->waktu_selesai);
                            ?>
                            <div class="bootstrap-timepicker">
                                <div class="form-group">
                                    <label>Waktu Mulai:</label>

                                    <div class="input-group">
                                        <input type="text" class="form-control timepicker" name="waktu_mulai"
                                            value="{{ $waktu_mulai->format('h:i A') }}">

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
                                            value="{{ $waktu_selesai->format('h:i A') }}">

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
                    @if ($agenda->status == 'Ditolak')
                        <div class="box-body">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Verifikator</label>
                                    <input type="text" class="form-control" name="verivikator"
                                        value="{{ $agenda->verifikator }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Status</label>
                                    <span class="label label-default">{{ $agenda->status }}</span>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="Pengajuan" name="status"> <i class="fa fa-send"></i>
                                        Ajukan Kembali
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Catatan</label>
                                    <textarea class="form-control" rows="3" name="catatan"
                                        disabled>{{ $agenda->catatan }}</textarea>
                                </div>
                            </div>
                        </div>
                    @endif
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <a href="/agenda" class="btn btn-warning">Kembali</a>
                        <button type="submit" class="btn btn-primary">Update</button>
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
