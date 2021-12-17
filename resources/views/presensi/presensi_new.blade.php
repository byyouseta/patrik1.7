<!-- Menghubungkan dengan view template master -->
@extends('layouts.app')
@section('head')
    <!-- DataTables -->
    <link rel="stylesheet"
        href="{{ asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection
<!-- isi bagian judul halaman -->
<!-- cara penulisan isi section yang pendek -->
@section('judul_halaman', 'Daftar Agenda')


<!-- isi bagian konten -->
<!-- cara penulisan isi section yang panjang -->
@section('konten')

    <div class="row">
        <div class="col-xs-12">
            <div class="box">

                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-hover" id="example2">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Agenda</th>
                                <th>Tanggal</th>
                                <th>Waktu Mulai</th>
                                <th>Waktu Selesai</th>
                                <th>Tempat</th>
                                <th>Status Presensi</th>
                                <th>Waktu Presensi</th>

                                <th>Pengundang</th>

                                <th> Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($cari)) {
                                $halaman = $agenda->currentPage();
                                $per_page = $agenda->perPage();
                                $no = ($halaman - 1) * $per_page + 1;
                            } else {
                                $no = 1;
                            }
                            $now = new DateTime();
                            $now = $now->format('Y-m-d');
                            ?>
                            @forelse ($agenda as $a)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $a->nama_agenda }}</td>
                                    <td>{{ \Carbon\Carbon::parse($a->tanggal)->format('d M Y') }}</td>
                                    <td>{{ $a->waktu_mulai }}</td>
                                    <td>{{ $a->waktu_selesai }}</td>
                                    <td>{{ $a->nama_ruangan }}</td>
                                    <td>
                                        @if ($a->presensi == 'sudah')
                                            <span class="label label-success">
                                            @else
                                                <span class="label label-danger">
                                        @endif
                                        {{ $a->presensi }}</span>
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($a->waktu_presensi)->format('d M Y H:i:s') }}
                                    </td>
                                    <td>
                                        {{ $a->pengundang }}
                                    </td>

                                    <td>

                                        <div class="btn-group">
                                            {{-- <a href="/agenda/undangan/{{ Crypt::encrypt($a->id) }}"
                                                class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="bottom"
                                                title="Detail">
                                                <i class="fa fa-info-circle"></i></a> --}}
                                            <a href="/presensi/{{ Crypt::encrypt($a->id) }}/{{ Crypt::encrypt(Auth::user()->id) }}"
                                                class="btn btn-success btn-sm @if ($a->presensi == 'sudah' or $now != $a->tanggal) disabled @endif" data-toggle="tooltip"
                                                data-placement="bottom" title="Presensi">
                                                <i class="fa fa-sign-in"></i> Klik Presensi
                                            </a>
                                        </div>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center">Belum ada data agenda yang dibuat</td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                    <!-- /.box-body -->
                </div>

                {{-- <div class="box-footer clearfix">

                    <ul class="pagination pagination-sm no-margin pull-right">

                        <li>

                            {{ $agenda->appends(Request::get('page'))->links() }}

                        </li>

                    </ul>
                </div> --}}

            </div>
            <!-- /.box -->
        </div>
    </div>

@endsection
@section('plugin')
    <!-- DataTables -->
    <script src="{{ asset('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script>
        $(function() {
            $('#example1').DataTable()
            $('#example2').DataTable({
                'paging': true,
                'lengthChange': true,
                'searching': true,
                'ordering': true,
                'info': true,
                "scrollY": false,
                "scrollX": true,
                "autoWidth": false,
                "fixedHeader": {
                    "header": false,
                    "footer": false
                },
            })
        })
    </script>
@endsection
