@extends('layouts.app')
@section('head')
    <!-- DataTables -->
    <link rel="stylesheet"
        href="{{ asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection
<!-- isi bagian judul halaman -->
<!-- cara penulisan isi section yang pendek -->
@section('judul_halaman', 'Agenda')


<!-- isi bagian konten -->
<!-- cara penulisan isi section yang panjang -->
@section('konten')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">

                <div class="box-header">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                {{ $error }} <br />
                            @endforeach
                        </div>
                    @endif
                    @php
                        $now = new DateTime();
                        $now = $now->format('Y-m-d');
                        $tahun = new DateTime();
                        $tahun = $tahun->format('Y');
                    @endphp
                    <a href="/agenda" class="btn btn-warning">Kembali</a>
                    @if ($agenda->status == 'Pengajuan' and Auth::user()->level == 'admin')
                        <button type="button" class="btn btn-primary" data-toggle="modal"
                            data-target="#modal-default">Verifikasi</button>
                    @endif
                    @if ($now >= $agenda->tanggal and $agenda->status != 'Selesai')
                        <a href="/agenda/selesai/{{ Crypt::encrypt($agenda->id) }}" class="btn btn-success">Selesai</a>
                    @endif
                </div>


                <div class="box-header">
                    <table class="table table-hover">
                        <tr>
                            <th style="width: 10%">Nama Rapat</th>
                            <td style="width: 50%">{{ $agenda->nama_agenda }}</td>
                            <th style="width: 10%">PIC Rapat</th>
                            <td style="width: 30%">
                                {{ $agenda->userpic->name }}
                            </td>
                        </tr>
                        <tr>
                            <th>Tanggal</th>
                            <td>{{ \Carbon\Carbon::parse($agenda->tanggal)->format('d M Y') }}</td>
                            <th>Pengundang Acara</th>
                            <td>{{ $agenda->pengundang }}</td>
                        </tr>
                        <tr>
                            <th>Waktu</th>
                            <td>{{ $agenda->waktu_mulai . ' - ' . $agenda->waktu_selesai }}</td>
                            <th>Peserta / Presensi</th>
                            <td>{{ $agenda->user->count() }} / {{ $presensi }}</td>
                        </tr>
                        <tr>
                            <th>Tempat</th>
                            <td>{{ $agenda->ruangan->nama }}</td>
                            <th>Notulen</th>
                            <td>
                                @if (!empty($agenda->notulen))
                                    {{-- {{$agenda->notulen}} --}}
                                    <a href="/notulen/view/{{ $agenda->notulen }} " target="_blank"
                                        class="label label-success">Lihat File</a>
                                @else
                                    <span class="label label-warning">belum ada Notulen</span>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>Keterangan</th>
                            <td>{{ $agenda->keterangan }}</td>
                            <th>Daftar Hadir</th>
                            <td>
                                @if (!empty($agenda->daftar))
                                    {{ $agenda->daftar }}
                                    <a href="/daftarhadir/view/{{ $agenda->daftar }} " target="_blank"
                                        class="label label-success">Daftar Hadir Luring</a>
                                @else
                                    <span class="label label-warning">belum ada Daftar Hadir Luring</span>
                                @endif
                                <a href="/presensi/hadir/{{ Crypt::encrypt($agenda->id) }}" target="_blank"
                                    class="label label-primary">Daring</a>
                            </td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if ($agenda->status == 'Pengajuan')
                                    <span class="label label-warning">
                                    @elseif($agenda->status == 'Dijadwalkan')
                                        <span class="label label-success">
                                        @else
                                            <span class="label label-default">
                                @endif
                                {{ $agenda->status }}</span>
                            </td>
                            <th>Materi</th>
                            <td>
                                @if (!empty($agenda->materi))
                                    {{ $agenda->materi }}
                                    <a href="/materi/view/{{ $agenda->materi }} " target="_blank"
                                        class="label label-success">Lihat Materi</a>
                                @else
                                    <span class="label label-warning">belum ada materi</span>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>Varifikator</th>
                            <td>{{ $agenda->verifikator }}</td>
                            <th>Dokumentasi</th>
                            <td>
                                @forelse ($gambar as $item)
                                    <a href="/dokumentasi/view/{{ $item->gambar }} " target="_blank"
                                        class="label label-success">{{ $item->gambar }}</a>
                                @empty
                                    <span class="label label-warning">belum ada dokumentasi</span>
                                @endforelse

                            </td>
                        </tr>
                        <tr>
                            <th>Catatan</th>
                            <td>{{ $agenda->catatan }}</td>
                            <th>Undangan</th>
                            <td>
                                <a href="/undangan/view/{{ Crypt::encrypt($agenda->id) }} " target="_blank"
                                    class="label label-primary">Undangan</a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            @if (($agenda->status != 'Pengajuan' or $agenda->status != 'Ditolak') and (Auth::user()->level == 'admin' or Auth::user()->id == $agenda->pic))
                <div class="box box-info collapsed-box">
                    <div class="box-header">
                        <h3 class="box-title">PATRIK Notulen
                            <small>dari CK Editor</small>
                        </h3>
                        <!-- tools box -->
                        <div class="pull-right box-tools">
                            <button type="button" class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip"
                                title="Minimalkan">
                                <i class="fa fa-plus"></i></button>

                        </div>
                        <!-- /. tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body pad display:none">
                        <form method="POST" action="/notulen/save/{{ $agenda->id }}">
                            @csrf
                            <textarea id="editor1" name="notulen_ol" rows="10" cols="80">
                                                                                                                                                                                                                                                                                                                                                                                                                                                {{ $agenda->notulen_ol }}
                                                                                                                                                                                                                                                                                                                                                                                                                                            </textarea>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Simpan</button>

                            </div>
                        </form>
                    </div>
                </div>
            @endif
            <!-- /.box -->


            @if (($agenda->status != 'Pengajuan' or $agenda->status != 'Ditolak') and (Auth::user()->level == 'admin' or Auth::user()->id == $agenda->pic))
                <div class="box box-success">
                    <div class="box-body">
                        <div class="box-header table-hover">
                            @if ($now <= $agenda->tanggal)
                                <form role="form" action="/undangan/tambahpeserta/{{ $id }}" method="post">
                                    {{ csrf_field() }}

                                    <div class="form-group col-md-12">
                                        <label>Undang Peserta Rapat</label>
                                    </div>

                                    <div class="form-group col-md-8">
                                        <input type="hidden" name="id" value="{{ $id }}">
                                        <select class="form-control select2 " style="width: 100%;" name="peserta">
                                            <option selected value="" active>Pilih</option>
                                            @foreach ($pegawai as $p)
                                                <option value="{{ $p->id }}">
                                                    {{ $p->name . ' Unit ' . $p->unit->nama_unit }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary btn-sm"><i
                                                class="fa fa-plus-circle"></i> Tambah</button>
                                    </div>
                                    <div class="col-md-12">
                                        @if ($errors->any())
                                            <div class="text-danger">
                                                {{ $errors->first() }}
                                            </div>
                                        @endif
                                    </div>
                                </form>
                            @endif
                            @if ($now >= $agenda->tanggal and empty($agenda->notulen))
                                <form class="form-inline" action="/notulen/upload/{{ $id }}" method="POST"
                                    enctype="multipart/form-data">
                                    {{ csrf_field() }}

                                    <div class="form-group col-md-8">
                                        <strong>File Notulen dalam bentuk PDF (Maksimal 2Mb)</strong>
                                        <input type="file" name="filepdf">

                                    </div>

                                    <div class="form-group col-md-2">
                                        <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-upload">
                                                Upload</i></button>
                                    </div>
                                </form>
                            @endif
                            @if ($errors->has('filepdf'))
                                <div class="text-danger">
                                    {{ $errors->first('filepdf') }}
                                </div>
                            @endif
                            @if ($now >= $agenda->tanggal and empty($agenda->daftar))
                                <form action="/daftarhadir/upload/{{ $id }}" method="POST"
                                    enctype="multipart/form-data">
                                    {{ csrf_field() }}

                                    <div class="form-group col-md-8">
                                        <strong>File Daftar Hadir dalam bentuk PDF/JPEG (Maksimal 2Mb)</strong>
                                        <input type="file" name="filedaftar">

                                    </div>

                                    <div class="form-group col-md-2">
                                        <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-upload">
                                                Upload</i></button>
                                    </div>
                                </form>
                            @endif
                            @if ($errors->has('filedaftar'))
                                <div class="text-danger">
                                    {{ $errors->first('filedaftar') }}
                                </div>
                            @endif
                            @if ($now >= $agenda->tanggal and empty($agenda->materi))
                                <form action="/materi/upload/{{ $id }}" method="POST"
                                    enctype="multipart/form-data">
                                    {{ csrf_field() }}

                                    <div class="form-group col-md-8">
                                        <strong>File Materi dalam bentuk PDF/PPT/PPTX (Maksimal 2Mb)</strong>
                                        <input type="file" name="filemateri">

                                    </div>

                                    <div class="form-group col-md-2">
                                        <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-upload">
                                                Upload</i></button>
                                    </div>
                                </form>
                            @endif
                            @if ($errors->has('filemateri'))
                                <div class="text-danger">
                                    {{ $errors->first('filemateri') }}
                                </div>
                            @endif
                            @if ($now >= $agenda->tanggal)
                                <form action="/dokumentasi/upload/{{ $id }}" method="POST"
                                    enctype="multipart/form-data">
                                    {{ csrf_field() }}

                                    <div class="form-group col-md-8">
                                        <strong>File dokumentasi dalam bentuk JPG/JPEG (Maksimal 1Mb)</strong>
                                        <input type="file" name="filedokumentasi">

                                    </div>

                                    <div class="form-group col-md-2">
                                        <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-upload">
                                                Upload</i></button>
                                    </div>
                                </form>
                            @endif
                            @if ($errors->has('filedokumentasi'))
                                <div class="text-danger">
                                    {{ $errors->first('filedokumentasi') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
            <div class="box box-primary">
                <div class="box-header">
                    <!-- /.box-header -->

                    <h4> <label>Daftar Peserta </label></h4>
                    @if ($now <= $agenda->tanggal and $agenda->status != 'Selesai')
                        <a href="/presensi/email/{{ Crypt::encrypt($agenda->id) }}" class="btn btn-success"><i
                                class="fa fa-envelope"></i> Kirim Email</a>
                    @endif
                </div>

                <div class="box-body">
                    <table class="table table-hover" id="example1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Unit</th>
                                <th>Status Presensi</th>
                                <th>Waktu Presensi</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($agenda->user as $index => $user)
                                <tr>
                                    <td>{{ ++$index }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->unit->nama_unit }}</td>
                                    <td>
                                        @if ($user->pivot->presensi == 'sudah')
                                            <span class="label label-success">
                                            @else
                                                <span class="label label-danger">
                                        @endif
                                        {{ $user->pivot->presensi }}</span>
                                    </td>
                                    <td>
                                        @if (!empty($user->pivot->presensi_at))
                                            {{ \Carbon\Carbon::parse($user->pivot->presensi_at)->format('d-m-Y H:i:s') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if (($now < $agenda->tanggal or $user->pivot->presensi != 'sudah') and (Auth::user()->level == 'admin' or Auth::user()->id == $agenda->pic))
                                            <div class="btn-group">
                                                <a href="/undangan/{{ $id }}/hapus/{{ Crypt::encrypt($user->id) }}"
                                                    class="btn btn-danger btn-sm" data-toggle="tooltip"
                                                    data-placement="bottom" title="Hapus"><i class="fa fa-trash"></i></a>
                                            </div>
                                            <div class="btn-group">
                                                <a href="/presensi/{{ $id }}/email/{{ Crypt::encrypt($user->id) }}"
                                                    class="btn btn-success btn-sm" data-toggle="tooltip"
                                                    data-placement="bottom" title="Kirim Email Presensi"><i
                                                        class="fa fa-envelope"></i></a>
                                            </div>
                                        @else
                                            <div class="btn-group">
                                                <a href="/undangan/{{ $id }}/hapus/{{ Crypt::encrypt($user->id) }}"
                                                    class="btn btn-danger btn-sm disabled" data-toggle="tooltip"
                                                    data-placement="bottom" title="Hapus"><i class="fa fa-trash"></i></a>
                                            </div>
                                            <div class="btn-group">
                                                <a href="/presensi/{{ $id }}/email/{{ Crypt::encrypt($user->id) }}"
                                                    class="btn btn-success btn-sm disabled" data-toggle="tooltip"
                                                    data-placement="bottom" title="Kirim Email Presensi"><i
                                                        class="fa fa-envelope"></i></a>
                                            </div>
                                        @endif

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
            <!--modal -->
            <div class="modal fade" id="modal-default">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Verifikasi Agenda</h4>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="/agenda/verifikasi">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label>Diverifikasi Oleh</label>
                                    <input type='hidden' class="form-control" name='id' value='{{ $agenda->id }}' />
                                    <input type='text' class="form-control" name='verifikator'
                                        value='{{ Auth::user()->name }}' disabled />
                                </div>
                                <div class="form-group">
                                    <label>Pengajuan</label>
                                    <select class="form-control" style="width: 100%;" name="status">
                                        <option selected value="" active>Pilih Status</option>

                                        <option value="Dijadwalkan">Dijadwalkan</option>
                                        <option value="Ditolak">Ditolak</option>
                                    </select>
                                </div>
                                @if (!empty($eselon->pegawai->eselon))
                                    <div class="form-group">
                                        <label>No Undangan (Optional)</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">UM.02.08/XLVIII.

                                                {{ $eselon->pegawai->eselon }}/

                                            </span>
                                            <input type='text' class="form-control" name='no_undangan' />
                                            <span class="input-group-addon">/{{ $tahun }}</span>
                                        </div>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label>Catatan</label>
                                    <textarea class="form-control" rows="3" name='catatan' placeholder="Catatan"></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left"
                                        data-dismiss="modal">Kembali</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
            </div>
        </div>
    </div>
@endsection
@section('plugin')
    <!-- DataTables -->
    <script src="{{ asset('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <!-- CK Editor -->
    <script src="{{ asset('adminlte/bower_components/ckeditor/ckeditor.js') }}"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="{{ asset('adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
    <script>
        $(function() {
            // Replace the <textarea id="editor1"> with a CKEditor
            // instance, using default configuration.
            CKEDITOR.replace('editor1')
            //bootstrap WYSIHTML5 - text editor
            $('.textarea').wysihtml5()
        })
    </script>
    <script>
        $(function() {
            $('#example1').DataTable()
            $('#example2').DataTable({
                'paging': true,
                'lengthChange': true,
                'searching': true,
                'ordering': true,
                'info': true,
                'autoWidth': false
            })
        })
    </script>
@endsection
