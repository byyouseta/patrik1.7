@extends('layouts.app')

<!-- isi bagian judul halaman -->
<!-- cara penulisan isi section yang pendek -->
@section('judul_halaman', 'Timeline')


<!-- isi bagian konten -->
<!-- cara penulisan isi section yang panjang -->
@section('konten')
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit Timeline</h3>
                </div>
                <!-- /.box-header -->
                <form role="form" action="/timeline/update" method="post">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="col-md-6">
                        @php
                            $validate = \App\AgendaTimeline::getUnitTime(Auth::user()->unit_id);

                        @endphp
                            <!-- text input -->
                            <div class="form-group">
                                <label>Nama Timeline</label>
                                <input type="hidden" name="id" value="{{ $data->id }}">
                                <input type="text" class="form-control" placeholder="Masukkan Nama Timeline"
                                    name="nama_timeline" value="{{ $data->nama_timeline }}" {{ $validate ? '':'readonly' }} >
                                @if ($errors->has('nama_timeline'))
                                    <div class="text-danger">
                                        {{ $errors->first('nama_timeline') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Target</label>
                                <textarea class="form-control" rows="3" placeholder="Masukkan Target"
                                    name="target" {{ $validate ? '':'readonly' }}>{{ $data->target }}</textarea>
                                @if ($errors->has('target'))
                                    <div class="text-danger">
                                        {{ $errors->first('target') }}
                                    </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Pemberi Tugas</label>
                                <select class="form-control select2 " name="instruktor" {{ $validate ? '':'disabled' }}>
                                    <option value="">Pilih</option>
                                    @foreach ($pegawai as $instruktur)
                                        <option value="{{ $instruktur->id }}"
                                            {{ $data->instruktor_id == $instruktur->id ? 'selected' : '' }}>{{ $instruktur->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('instruktor'))
                                    <div class="text-danger">
                                        {{ $errors->first('instruktor') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>PIC</label>
                                <select class="form-control select2 " name="pic" required>
                                    <option value="">Pilih</option>
                                    @foreach ($pegawai as $p)
                                        <option value="{{ $p->id }}"
                                            {{ $data->pic == $p->id ? 'selected' : '' }}>{{ $p->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('pic'))
                                    <div class="text-danger">
                                        {{ $errors->first('pic') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Tim Kerja</label>
                                <select class="form-control select2" name="timker" required>
                                    <option value="" selected>Pilih</option>
                                    @foreach ($unit as $r)
                                        <option value="{{ $r->id }}" {{ $data->unit_id == $r->id ? 'selected' : '' }}>{{ $r->nama_unit }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('timker'))
                                    <div class="text-danger">
                                        {{ $errors->first('timker') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Mulai</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right" id="datepicker" name="mulai"
                                        autocomplete="off" value="{{ $data->waktu_mulai }}" {{ $validate ? '':'disabled' }}>
                                </div>
                                <!-- /.input group -->
                                @if ($errors->has('mulai'))
                                    <div class="text-danger">
                                        {{ $errors->first('mulai') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Selesai</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right" id="datepicker2" name="selesai"
                                        autocomplete="off" value="{{ $data->waktu_selesai }}" {{ $validate ? '':'disabled' }}>
                                </div>
                                <!-- /.input group -->
                                @if ($errors->has('selesai'))
                                    <div class="text-danger">
                                        {{ $errors->first('selesai') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Hambatan</label>
                                <textarea class="form-control" rows="3" placeholder="Masukkan Hambatan"
                                    name="hambatan">{{ $data->hambatan }}</textarea>
                                @if ($errors->has('hambatan'))
                                    <div class="text-danger">
                                        {{ $errors->first('hambatan') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Rencana Tindak Lanjut</label>
                                <textarea class="form-control" rows="3" placeholder="Masukkan Rencana Tindak Lanjut"
                                    name="rtl">{{ $data->rtl }}</textarea>
                                @if ($errors->has('rtl'))
                                    <div class="text-danger">
                                        {{ $errors->first('rtl') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Aktual</label>
                                    <div class="input-group date">
                                    <input type="number" class="form-control pull-right text-right" name="aktual"
                                            autocomplete="off" value="{{ $data->aktual }}" step="1" min="0" max="100" readonly>
                                            <div class="input-group-addon">
                                                &percnt;
                                            </div>
                                    </div>
                                    @if ($errors->has('aktual'))
                                        <div class="text-danger">
                                            {{ $errors->first('aktual') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Progress</label>
                                    <select class="form-control select2" name="progres" required>
                                        <option value="" >Pilih</option>
                                        <option value="Belum Mulai" {{ $data->progress == 'Belum Mulai' ? 'selected' : '' }}>Belum Mulai</option>
                                        <option value="Proses" {{ $data->progress == 'Proses' ? 'selected' : '' }}>Proses</option>
                                        <option value="Selesai" {{ $data->progress == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                    @if ($errors->has('progres'))
                                        <div class="text-danger">
                                            {{ $errors->first('progres') }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <a href="/timeline" class="btn btn-default">Kembali</a>
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
@section('plugin')
    <script>
        $(function() {
            //Date picker
            $('#datepicker2').datepicker({
                format: "yyyy-mm-dd",
                autoclose: true,
                todayHighlight: true,
                orientation: "auto"
            })
        })
    </script>
@endsection
