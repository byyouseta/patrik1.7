<h3>Halo, {{ $data['nama'] }} !</h3>
<p>Anda Telah diundang dalam acara berikut ini</p>
<table>
    <tr>
        <td style="width: 150px"><b>Nama Rapat</b></td>
        <td>{{ $data['nama_agenda'] }}</td>
    </tr>
    <tr>
        <td><b>Tanggal</b></td>
        <td>{{ $data['tanggal'] }}</td>
    </tr>
    <tr>
        <td><b>Waktu</b></td>
        <td>{{ $data['mulai'] . ' - ' . $data['selesai'] }}</td>
    </tr>
    <tr>
        <td><b>Tempat</b></td>
        <td>{{ $data['nama_ruangan'] }}</td>
    </tr>
    <tr>
        <td><b>Keterangan</b></td>
        <td>{{ $data['keterangan'] }}</td>
    </tr>
    <tr>
        <td><b>PIC Rapat</b></td>
        <td>{{ $data['pic'] }}</td>
    </tr>
    <tr>
        <td><b>Pengundang Rapat</b></td>
        <td>{{ $data['pengundang'] }}</td>
    </tr>
</table>
<p>Silahkan klik berikut untuk Absen</p>

<h3><b><a href="{{ $data['link'] }}">Klik untuk Presensi</a></b></h3>
