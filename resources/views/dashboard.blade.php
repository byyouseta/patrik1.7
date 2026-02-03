@extends('layouts.app')

<!-- isi bagian judul halaman -->
<!-- cara penulisan isi section yang pendek -->
@section('judul_halaman', 'Dashboard Timeline')


<!-- isi bagian konten -->
<!-- cara penulisan isi section yang panjang -->
@section('konten')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body text-center">
                <img src="{{ asset('adminlte/dist/img/LogoBaruRSUP.JPG') }}" alt="Gambar logo kemenkes" width="30%">
            </div>
        </div>
        <div class="box">
            <div class="box-body no-padding">
                <table class="table table-condensed padding-md" >
                    <thead style="font-size: 14pt;">
                        <tr>
                            <th rowspan="2" class="text-center" style="vertical-align: middle; width:5%;" >No</th>
                            <th rowspan="2" class="text-center" style="vertical-align: middle; width:50%;" >Unit Kerja</th>
                            <th colspan="3" class="text-center" style="width: 25%;">Status</th>
                            <th rowspan="2" class="text-center" style="vertical-align: middle; width:20%;">Persentase Selesai</th>
                        </tr>
                        <tr>
                            <th class="text-center">Belum Mulai</th>
                            <th class="text-center">Proses</th>
                            <th class="text-center">Selesai</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 12pt;">
                        @foreach ($data as $index=>$list)
                            <tr>
                                <td class="text-center">{{ ++$index}}</td>
                                <td>{{ $list->nama_unit }}</td>
                                <td class="text-center">{{ $list->belum_mulai }}</td>
                                <td class="text-center">{{ $list->proses }}</td>
                                <td class="text-center">{{ $list->selesai }}</td>
                                @php
                                    $hitung = $list->selesai/($list->belum_mulai+$list->proses+$list->selesai)*100;
                                @endphp
                                 <td class="text-center"><span class="badge bg-green">{{ $hitung }}%</span> </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
        <!-- /.box -->
        <!-- /.box-body -->
    </div>
</div>
@endsection
