@extends('layouts.app')

<!-- isi bagian judul halaman -->
<!-- cara penulisan isi section yang pendek -->
@section('judul_halaman', 'Timeline')
@section('head')
    <style>
        .padded-left {
                padding-left: 20px;
            }
    </style>
@endsection


<!-- isi bagian konten -->
<!-- cara penulisan isi section yang panjang -->
@section('konten')
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Detail Timeline</h3>
                    <div class="pull-right">
                        <a href="/timeline" class="btn btn-default">Kembali</a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="col-md-6">
                        <!-- Text Display -->
                        <div class="form-group row">
                            <label class="col-md-4">Nama Timeline</label>
                            <div class="col-md-8">
                                <p class="">{{ $data->nama_timeline }}</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4">Target</label>
                            <div class="col-md-8">
                                <p class="">{!! nl2br(e($data->target)) !!}</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4">Rencana Tindak Lanjut</label>
                            <div class="col-md-8">
                                <p class="">{!! nl2br(e($data->rtl)) !!}</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4">Pemberi Kerja</label>
                            <div class="col-md-8">
                                <p class="">{{ $data->instruktor }}</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4">PIC</label>
                            <div class="col-md-8">
                                <p class="">{{ $data->user->name }}</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4">Tim Kerja</label>
                            <div class="col-md-8">
                                <p class="">{{ $data->unit->nama_unit }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-md-4">Mulai</label>
                            <div class="col-md-8">
                                <p class="">{{ $data->waktu_mulai }}</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4">Selesai</label>
                            <div class="col-md-8">
                                <p class="">{{ $data->waktu_selesai }}</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4">Rencana</label>
                            <div class="col-md-8">
                                <p class="">{!! nl2br(e($data->rencana)) !!}</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4">Hambatan</label>
                            <div class="col-md-8">
                                <p class="">{!! nl2br(e($data->hambatan)) !!}</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4">Aktual</label>
                            <div class="col-md-8">
                                <p class="">
                                    @if (($data->aktual >= 0 )&& ($data->aktual < 60))
                                        <span class="label label-danger">
                                    @elseif(($data->aktual >= 60 )&& ($data->aktual < 90))
                                        <span class="label label-warning">
                                    @elseif($data->aktual >= 90)
                                        <span class="label label-success">
                                    @endif
                                        {{ $data->aktual }}% </span></p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4">Progress</label>
                            <div class="col-md-8">
                                <p class="">
                                    @if ($data->progress == 'Belum Mulai')
                                            <span class="label label-danger">
                                        @elseif ($data->progress == 'Proses')
                                            <span class="label label-primary">
                                        @elseif ($data->progress == 'Selesai')
                                            <span class="label label-success">
                                        @endif
                                    {{ $data->progress }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div class="col-md-5">
            <div class="box">
                <div class="box-header">
                    <div class="box-title">
                        Data Bukti
                    </div>
                </div>
                <div class="box-body">
                    @if(Auth::user()->id == $data->pic || Auth::user()->level== 'admin')
                        <form action="/timeline/bukti" method="POST" enctype="multipart/form-data">
                        @csrf
                            <div class="row">
                                {{-- <div class="col-md-1"><label class="padded-left">File Bukti</label></div> --}}
                                <div class="col-md-4">
                                    <input type="hidden" name="timeline_id" value="{{ $data->id }}">
                                    <input type="file" id="exampleInputFile" name="file" required>
                                    <p class="help-block">Pastikan file dalam bentuk pdf/doc/dox/xls/xlsx</p>
                                </div>
                                <div class="col-md-5"><textarea class="form-control" placeholder="Keterangan" name="keterangan" required></textarea></div>
                                <div class="col-md-2"><button type="submit" class="btn btn-primary">Upload</button></div>
                            </div>
                        </form>
                        <hr>
                    @endif

                    <table class="table table-hover table-sm">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 10%">No</th>
                                <th class="text-center" style="width: 50%">Keterangan</th>
                                <th class="text-center" style="width: 10%">Update</th>
                                <th class="text-center" style="width: 20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data->bukti as $index=>$list)
                                <tr >
                                    <td class="text-center" style="width: 10%">{{ ++$index }}</td>
                                    <td style="width: 50%; word-wrap: break-word;">{{ $list->keterangan }}</td>
                                    <td style="width: 10%">{{ $list->updated_at }}</td>
                                    <td  class="text-center" style="width: 20%">
                                        <div class="btn-group">
                                            <a href="/timeline/bukti/{{ Crypt::encrypt($list->id) }}/view" class="btn btn-primary btn-sm" data-toggle="tooltip"
                                                data-placement="bottom" title="Download File" target="_blank"><i class="fa fa-download"></i></a>
                                            @if(Auth::user()->id == $data->pic || Auth::user()->level== 'admin')
                                                <a href="/timeline/bukti/{{ Crypt::encrypt($list->id) }}/delete" class="btn btn-danger btn-sm" data-toggle="tooltip"
                                                    data-placement="bottom" title="Hapus File"><i class="fa fa-trash"></i></a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="box">
                <div class="box-header">
                    <div class="box-title">
                        Catatan SPI
                    </div>
                </div>
                <div class="box-body">
                    @php
                        $wewenang = \App\AgendaTimeline::getUnitTime(Auth::user()->unit_id);
                    @endphp
                    @if($wewenang || Auth::user()->level == 'admin')
                        <form id="form-hybrid" action="{{ isset($catatan) ? '/timeline/catatan/update' : '/timeline/catatan/store' }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if(isset($catatan))
                                @method('PUT')
                                <input type="hidden" name="catatan_id" value="{{ $catatan->id }}">
                            @endif
                            <input type="hidden" name="timeline_id" value="{{ $data->id }}">
                            <div class="row g-0">
                                <div class="col-md-7">
                                    <textarea class="form-control" placeholder="Catatan" name="catatan" required>{{ $catatan->catatan ?? '' }}</textarea>
                                </div>
                                <div class="col-md-2">
                                    <select name="valid" class="form-control">
                                        <option value="0" {{ (isset($catatan) && $catatan->valid == 0) ? 'selected' : '' }}>Tidak Valid</option>
                                        <option value="1" {{ (isset($catatan) && $catatan->valid == 1) ? 'selected' : '' }}>Valid</option>
                                    </select>
                                </div>
                                <div class="col-md-3 pull-right">
                                    <div class="btn-group">
                                        <button type="submit" class="btn btn-primary">
                                            {{ isset($catatan) ? 'Update' : 'Tambah' }}
                                        </button>
                                        <button type="reset" class="btn btn-secondary">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <hr>
                    @endif

                    <table class="table table-hover table-sm">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 5%">No</th>
                                <th class="text-center" style="width: 45%">Catatan</th>
                                <th class="text-center" style="width: 10%">Status</th>
                                <th class="text-center" style="width: 20%">Update</th>
                                <th class="text-center" style="width: 20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data->catatan as $index=>$list)
                                <tr >
                                    <td class="text-center" style="width: 10%">{{ ++$index }}</td>
                                    <td >{{ $list->catatan }}</td>
                                    <td style="text-align: center">
                                        @if ($list->valid == TRUE)
                                            <list class="label label-success"><i class="fa fa-check"></i>
                                        @elseif ($list->valid == FALSE)
                                            <span class="label label-danger"><i class="fa fa-times"></i>
                                        @endif
                                            </span>
                                    </td>
                                    <td >{{ $list->updated_at }}</td>
                                    <td  class="text-center" style="width: 20%">
                                        @if($wewenang || Auth::user()->level == 'admin')
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-warning btn-edit"
                                                    data-id="{{ $list->id }}"
                                                    data-catatan="{{ $list->catatan }}"
                                                    data-valid="{{ $list->valid }}">
                                                    <i class="fa fa-pencil"></i>
                                                </button>
                                                <a href="/timeline/catatan/{{ Crypt::encrypt($list->id) }}/delete" class="btn btn-danger btn-sm" data-toggle="tooltip"
                                                    data-placement="bottom" title="Hapus"><i class="fa fa-trash"></i></a>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('plugin')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.btn-edit').forEach(function (button) {
                button.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    const catatan = this.getAttribute('data-catatan');
                    const valid = this.getAttribute('data-valid');

                    const form = document.getElementById('form-hybrid');
                    form.action = '/timeline/catatan/save'; // Hybrid endpoint

                    // Isi input hidden untuk ID
                    let inputId = form.querySelector('input[name="catatan_id"]');
                    if (!inputId) {
                        inputId = document.createElement('input');
                        inputId.type = 'hidden';
                        inputId.name = 'catatan_id';
                        form.appendChild(inputId);
                    }
                    inputId.value = id;

                     // Ubah teks tombol submit
                    const submitButton = form.querySelector('button[type="submit"]');
                    submitButton.textContent = 'Update';

                    // Isi data lain
                    form.querySelector('textarea[name="catatan"]').value = catatan;
                    form.querySelector('select[name="valid"]').value = valid;

                    // Scroll ke form
                    form.scrollIntoView({ behavior: 'smooth' });
                });
            });
        });

        // Reset form jika ingin menambahkan data baru
        const form = document.getElementById('form-hybrid');
        form.addEventListener('reset', function () {
            form.action = '/timeline/catatan/store'; // Kembali ke action POST
            form.querySelector('textarea[name="catatan"]').value = '';
            form.querySelector('select[name="valid"]').value = '0';

            // Hapus input hidden ID jika ada
            const inputId = form.querySelector('input[name="catatan_id"]');
            if (inputId) inputId.remove();

            // Kembalikan teks tombol submit
            const submitButton = form.querySelector('button[type="submit"]');
            submitButton.textContent = 'Tambah';
            submitButton.classList.remove('btn-warning');
            submitButton.classList.add('btn-primary');
        });

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
