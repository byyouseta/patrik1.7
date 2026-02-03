<!-- Menghubungkan dengan view template master -->
@extends('layouts.app')

<!-- isi bagian judul halaman -->
<!-- cara penulisan isi section yang pendek -->
@section('judul_halaman', 'Daftar Agenda')
@section('head')
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap.min.css">
@endsection

<!-- isi bagian konten -->
<!-- cara penulisan isi section yang panjang -->
@section('konten')

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="btn-group">
                        <a href="/agenda/tambah" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="right"
                            title="Tambah Agenda">
                            <i class="fa fa-plus-circle"></i> Tambah</a>
                    </div>

                    <div class="box-tools">
                        {{-- <form action="/agenda/cari" method="get">

                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="cari" class="form-control pull-right" placeholder="Search"
                                    @if (Request::get('cari'))
                                value="{{ Request::get('cari') }}"
                                @endif
                                >

                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form> --}}
                        <form action="/agenda/cari" method="get">
                            {{-- <div class="input-group input-group-sm" style="width: 250px;">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right" id="reservation">
                                </div>

                            </div>
                            <div class="input-group">
                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                            </div> --}}
                            <div class="input-group input-group-sm" style="width: 220px;">
                                <input type="text" class="form-control" id="reservation" name="cari"
                                    @if (Request::get('cari')) value="{{ Request::get('cari') }}"
                            @else
                                value="{{ \Carbon\Carbon::now()->startOfMonth()->format('d/m/Y') }}-{{ \Carbon\Carbon::now()->endOfMonth()->format('d/m/Y') }}" @endif
                                    autocomplete="off">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-info btn-flat">Tampilkan</button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-hover" id="example">
                        <thead class="text-middle">
                            <tr>
                                <th>No</th>
                                <th>Nama Agenda</th>
                                <th>Tanggal</th>
                                <th>Waktu Mulai</th>
                                <th>Waktu Selesai</th>
                                <th>Tempat</th>
                                <th>Status</th>
                                <th>PIC</th>
                                <th>Diajukan</th>
                                <th style="width: 150px;"> Aksi</th>
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
                            @foreach ($agenda as $a)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $a->nama_agenda }}</td>
                                    <td>{{ \Carbon\Carbon::parse($a->tanggal)->format('d M Y') }}</td>
                                    <td>{{ $a->waktu_mulai }}</td>
                                    <td>{{ $a->waktu_selesai }}</td>
                                    <td>{{ $a->nama_ruangan }}</td>
                                    <td>
                                        @if ($a->tanggal < $now and $a->status != 'Selesai')
                                            <span class="label label-danger">{{ $a->status }}</span>
                                        @elseif($a->status == 'Dijadwalkan')
                                            <span class="label label-success">{{ $a->status }}</span>
                                        @elseif($a->status == 'Pengajuan')
                                            <span class="label label-warning">{{ $a->status }}</span>
                                        @elseif($a->status == 'Ditolak')
                                            <span class="label label-default">{{ $a->status }}</span>
                                        @else
                                            <span class="label label-primary">{{ $a->status }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $a->pic_name }}
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($a->created_at)->format('d M Y H:i:s') }}</td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="/agenda/undangan/{{ Crypt::encrypt($a->id) }}"
                                                class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="bottom"
                                                title="Detail">
                                                <i class="fa fa-info-circle"></i></a>
                                            {{-- <a href="/presensi/undangan/{{ Crypt::encrypt($a->id) }}"
                                                class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="bottom"
                                                title="Presensi">
                                                <i class="fa fa-sign-in"></i></a> --}}
                                            @if (Auth::user()->id == $a->pic or Auth::user()->level == 'admin')
                                                <a href="/agenda/edit/{{ Crypt::encrypt($a->id) }}"
                                                    class="btn btn-warning btn-sm" data-toggle="tooltip"
                                                    data-placement="bottom" title="Ubah">
                                                    <i class="fa fa-edit"></i></a>
                                                <a href="/agenda/hapus/{{ Crypt::encrypt($a->id) }}"
                                                    class="btn btn-danger btn-sm delete-confirm" data-toggle="tooltip"
                                                    data-placement="bottom" title="Hapus">
                                                    <i class="fa fa-trash-o"></i></a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
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
    <!-- date-range-picker -->
    <script src="{{ asset('adminlte/bower_components/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <!-- DataTables -->
    <script src="{{ asset('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.colVis.min.js"></script>

    <script>
        $(function() {
            // $('#example1').DataTable()
            $('#example2').DataTable({
                'paging': true,
                'lengthChange': true,
                'searching': true,
                'ordering': true,
                'info': true,
                'autoWidth': false
            })
            $(document).ready(function() {
                var table = $('#example').DataTable({
                    lengthChange: true,
                    buttons: ['excel', 'pdf', 'colvis']
                });

                table.buttons().container()
                    .appendTo('#example_wrapper .col-sm-6:eq(0)');
            });
            //Date range picker
            // $('#reservation').daterangepicker({
            //     locale: {
            //         format: 'DD/MM/YYYY'
            //     }
            // })
            $('#reservation').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                }
            })
            $('#reservation').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY') + '-' + picker.endDate.format(
                    'DD/MM/YYYY'));
            })

            $('#reservation').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            })
        })
    </script>
@endsection
