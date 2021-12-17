<!-- Menghubungkan dengan view template master -->
@extends('layouts.app')

<!-- isi bagian judul halaman -->
<!-- cara penulisan isi section yang pendek -->
@section('judul_halaman', 'Daftar Pegawai')


<!-- isi bagian konten -->
<!-- cara penulisan isi section yang panjang -->
@section('konten')

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="btn-group">
                        <a href="/pegawai/tambah" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i>
                            Tambah</a>

                    </div>
                    {{-- <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-default">

                    <i class="glyphicon glyphicon-download-alt"></i>
                    Import Pegawai
                </button> --}}
                    <div class="box-tools">
                        <form action="/pegawai/cari" method="get">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="cari" class="form-control pull-right" placeholder="Search"
                                    @if (Request::get('cari')) value="{{ Request::get('cari') }}" @endif>
                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @php
                    if (isset($cari)) {
                        # code...
                        $no = 1;
                    } else {
                        $halaman = $pegawai->currentPage();
                        $per_page = $pegawai->perPage();
                        $no = ($halaman - 1) * $per_page + 1;
                    }
                @endphp
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIP</th>
                                <th>Nama Pegawai</th>
                                <th>Alamat</th>
                                <th>Unit</th>
                                <th>No Handphone</th>
                                <th style="width: 100px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @if (!empty($cari))
                                @foreach ($cari as $p)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $p->username }}</td>
                                        <td>{{ $p->name }}</td>
                                        <td>{{ $p->alamat }}</td>
                                        <td>{{ $p->nama_unit }}</td>
                                        <td>{{ $p->no_hp }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="/pegawai/edit/{{ Crypt::encrypt($p->id) }}"
                                                    class="btn btn-warning btn-sm" data-toggle="tooltip"
                                                    data-placement="bottom" title="Ubah">
                                                    <i class="fa fa-edit"></i></a>
                                                <a href="/pegawai/hapus/{{ Crypt::encrypt($p->id) }}"
                                                    class="btn btn-danger btn-sm delete-confirm" data-toggle="tooltip"
                                                    data-placement="bottom" title="Hapus">
                                                    <i class="fa fa-trash-o"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                @foreach ($pegawai as $p)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $p->username }}</td>
                                        <td>{{ $p->name }}</td>
                                        <td>{{ $p->pegawai->alamat }}</td>
                                        <td>{{ $p->unit->nama_unit }}</td>
                                        <td>{{ $p->pegawai->no_hp }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="/pegawai/edit/{{ Crypt::encrypt($p->id) }}"
                                                    class="btn btn-warning btn-sm" data-toggle="tooltip"
                                                    data-placement="bottom" title="Ubah">
                                                    <i class="fa fa-edit"></i></a>
                                                <a href="/pegawai/hapus/{{ Crypt::encrypt($p->id) }}"
                                                    class="btn btn-danger btn-sm delete-confirm" data-toggle="tooltip"
                                                    data-placement="bottom" title="Hapus">
                                                    <i class="fa fa-trash-o"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                    <ul class="pagination pagination-sm no-margin pull-right">

                        <li>
                            @if (!empty($cari))
                                {{ $cari->appends(Request::get('page'))->links() }}
                            @else
                                {{ $pegawai->appends(Request::get('page'))->links() }}
                            @endif
                        </li>

                    </ul>
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>
    <!-- /.content -->
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Import Data Pegawai</h4>
                </div>
                <form method="post" action="/pegawai/import_excel" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <label>Pilih file excel</label>
                        <div class="form-group">
                            <input type="file" name="file" required="required">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Keluar</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

@endsection
