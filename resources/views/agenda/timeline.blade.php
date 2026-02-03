<!-- Menghubungkan dengan view template master -->
@extends('layouts.app')
@section('head')
    <!-- DataTables -->
    <link rel="stylesheet"
        href="{{ asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <style>
        .dataTables_scrollHeadInner,
        .dataTables_scrollBody table {
            width: 100% !important;
        }
    </style>
@endsection
<!-- isi bagian judul halaman -->
<!-- cara penulisan isi section yang pendek -->
@section('judul_halaman', 'Timeline')


<!-- isi bagian konten -->
<!-- cara penulisan isi section yang panjang -->
@section('konten')

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">

                    <div class="btn-group">

                        <a href="/timeline/tambah" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="right"
                            title="Tambah Timeline">
                            <i class="fa fa-plus-circle"></i> Tambah</a>
                        <a href="/timeline/dashboard" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="right"
                            title="Dashboard Timeline">
                            <i class="fa fa-tv"></i> Dashboard</a>
                    </div>
                </div>

                <!-- /.box-header -->
                <div class="box-body">
                    @php
                        use Illuminate\Support\Str;
                        use \Carbon\Carbon;
                    @endphp
                    {{-- <div style="overflow-x:auto;"> --}}
                        <table class="table table-hover table-bordered table-responsive" id="example3" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Nama Timeline</th>
                                    <th>Target</th>
                                    <th>Pemberi Tugas</th>
                                    <th>PIC</th>
                                    <th>Unit Kerja</th>
                                    <th>Mulai</th>
                                    <th>Selesai</th>
                                    <th>Aktual</th>
                                    <th>Hambatan</th>
                                    <th>RTL</th>
                                    <th>Progres</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $list)
                                    <tr>
                                        <td>{{ $list->nama_timeline }}</td>
                                        <td>{{ Str::limit($list->target, 20,'...') }}</td>
                                        <td>{{ $list->instruktor }}</td>
                                        <td>{{ $list->user->name }}</td>
                                        <td>{{ $list->unit->nama_unit }}</td>
                                        <td>{{ \Carbon\Carbon::parse($list->waktu_mulai)->format('d M Y') }}</td>
                                        <td>
                                            @php
                                                $date1 = Carbon::today(); // Tanggal pertama
                                                $date2 = Carbon::createFromFormat('Y-m-d',$list->waktu_selesai); // Tanggal kedua

                                                $selisih = $date1->diffInDays($date2);

                                                // dd($differenceInDays);
                                            @endphp
                                            @if (($selisih >= 30 ))
                                                <span class="label label-success">
                                            @elseif(($selisih >= 10 ))
                                                <span class="label label-warning">
                                            @elseif($selisih >= 0)
                                                <span class="label label-danger">
                                            @endif
                                            {{ \Carbon\Carbon::parse($list->waktu_selesai)->format('d M Y') }} </span>

                                        </td>
                                        <td>
                                            @if (($list->aktual >= 0 )&& ($list->aktual < 60))
                                                <span class="label label-danger">
                                            @elseif(($list->aktual >= 60 )&& ($list->aktual < 90))
                                                <span class="label label-warning">
                                            @elseif($list->aktual >= 90)
                                                <span class="label label-success">
                                            @endif
                                            {{ $list->aktual }} &#37;</span>
                                        </td>
                                        <td>{{ Str::limit($list->hambatan, 20,'...') }}</td>
                                        <td>{{ Str::limit($list->rtl, 20,'...') }}</td>
                                        <td>
                                            @if ($list->progress == 'Belum Mulai')
                                                <span class="label label-danger">
                                            @elseif ($list->progress == 'Proses')
                                                <span class="label label-primary">
                                            @elseif ($list->progress == 'Selesai')
                                                <span class="label label-success">
                                            @endif
                                            {{ $list->progress }}</span>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="/timeline/{{ Crypt::encrypt($list->id) }}/detail"
                                                    class="btn btn-info btn-sm" data-toggle="tooltip"
                                                    data-placement="bottom" title="Info Detail">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                                @if(Auth::user()->id == $list->pic || Auth::user()->level == 'admin')
                                                    <a href="/timeline/{{ Crypt::encrypt($list->id) }}/edit"
                                                        class="btn btn-warning btn-sm" data-toggle="tooltip"
                                                        data-placement="bottom" title="Progress">
                                                        <i class="fa fa-arrow-right"></i>
                                                    </a>
                                                    <a href="/timeline/{{ Crypt::encrypt($list->id) }}/delete"
                                                        class="btn btn-danger btn-sm delete-confirm" data-toggle="tooltip"
                                                        data-placement="bottom" title="Hapus">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    {{-- </div> --}}
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
            $('#example1').DataTable();
            $('#example3').DataTable({
                'paging': true,
                'lengthChange': true,
                'searching': true,
                'ordering': true,
                'order': [[7, 'asc']],
                'info': true,
                "scrollY": '400px',
                "scrollX": true,
                "scrollCollapse": true,
                "autoWidth": false
            });

        })
    </script>
@endsection
