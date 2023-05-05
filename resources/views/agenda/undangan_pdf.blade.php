<!DOCTYPE html>
<html lang="en">

<head>
    <title>Undangan Rapat {{ $agenda->nama_agenda }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    {{-- <link rel="stylesheet" href="adminlte/plugins/bootstrap413/dist/css/bootstrap.min.css"> --}}
    <style>
        header {
            position: fixed;
            top: -60px;
            left: 0px;
            right: 0px;
            height: 50px;

            /** Extra personal styles **/
            /* background-color: #03a9f4; */
            color: black;
            text-align: right;
            line-height: 12px;
        }

        footer {
            position: fixed;
            bottom: -60px;
            left: 0px;
            right: 30px;
            height: 100px;

            /** Extra personal styles **/
            /* background-color: #03a9f4; */
            color: grey;
            text-align: right;
            font-size: 11px;
            line-height: 35px;
        }
    </style>
</head>

<body>
    <main>
        <table class="table table-borderless" style="margin-bottom : 0px;padding-bottom:0px;">
            <thead>
                <tr>
                    <th class="align-middle"><img src="adminlte/dist/img/LogoKemenkes.png" alt="Logo Kemenkes"
                            width="80" height="80"></th>
                    <td class="col-10 text-center align-middle" style="line-height: 1.2;">
                        <strong>
                            <div style="font-size: 18px;">KEMENTERIAN KESEHATAN REPUBLIK INDONESIA</div>
                            <div style="font-size: 16px;">DIREKTORAL JENDERAL PELAYANAN KESEHATAN</div>
                            <div style="font-size: 14px;">RUMAH SAKIT UMUM PUSAT (RSUP) SURAKARTA</div>
                        </strong>
                        <div style="font-size: 10px;">Jalan Prof. Dr. R. Soeharso No. 28 Surakarta 57144 Telp
                            0271-713055/720002<br>
                            surat elektronik: rsupsurakarta@kemkes.go.id;
                            info.rsupsurakarta@gmail.com
                        </div>
                    </td>
                    <th class="align-middle"><img src="adminlte/dist/img/Logo.png" alt="Logo RSUP" width="80"
                            height="80">
                    </th>
                </tr>
            </thead>
        </table>
        <?php
        $arrhari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $hari = new DateTime($agenda->tanggal);
        //$hari = $arrhari[$tanggal->format('N')];
        $tanggal = new DateTime($agenda->tanggal);
        ?>
        <style type="text/css">
            table tr td,
            table tr th {
                font-size: 10pt;

            }

            hr.new4 {
                border: 2px solid black;
                margin-left: auto;
                margin-right: auto;
                margin-top: 0em;
                margin-bottom: 0em;
            }

            p.ex1 {
                margin-left: auto;
                margin-right: auto;
                margin-top: auto;
                margin-bottom: auto;
            }
        </style>

        <hr class='new4' />
        @php
            $jmlundangan = $peserta->count();
            $urutan2 = ceil($jmlundangan / 2);
            // $index = 1;

            foreach ($peserta as $index => $user) {
                # code...
                $undangan[$index] = $user->name;
            }

            $kanan = $urutan2;
            $nokiri = 1;
            $nokanan = $urutan2 + 1;

        @endphp


        <table class="table table-borderless table-sm"
            style="margin-top:0px; padding-top:0px; margin-bottom:0px; padding-bottom:0px">
            <tbody>
                <tr>
                    <th colspan='4' class="text-center" style="padding-top: 0px;">
                        <h4 style="padding-bottom:1px; margin-bottom:1px;">Undangan</h4>
                        <p style="padding-top: 1px; padding-bottom:1px; margin-top:1px; margin-bottom:1px;">
                            {{ $agenda->no_undangan }}
                        </p>
                    </th>
                </tr>
                <tr>
                    <td colspan='4' style="padding-left: 40px">Yth. Bapak Ibu </td>
                </tr>

            </tbody>
        </table>
        <table class="table table-borderless table-sm" style="margin-top:0%; padding-top:0%; margin-bottom:0%">
            @for ($i = 0; $i < $urutan2; $i++)
                <tr>
                    <td class="ml-5" style="padding-top:1px;padding-bottom:1px; padding-left:45px;">
                        {{ $nokiri . '. ' . $undangan[$i] }}
                    </td>
                    @php
                        $kanan = $urutan2 + $i;
                        $nokiri++;
                    @endphp
                    @if (!empty($undangan[$kanan]))
                        <td style="padding-top:1px;padding-bottom:1px; padding-right:40px">
                            {{ $nokanan . '. ' . $undangan[$kanan] }}</td>
                    @endif
                    @php
                        $nokanan++;
                    @endphp
                </tr>
            @endfor
        </table>
        @php
            $keterangan = explode(PHP_EOL, $agenda->keterangan);
        @endphp
        <table class="table table-borderless table-sm" style="margin-top:1px;">
            <tbody>
                <tr>
                    <td colspan='3' style="padding-top: 1px; padding-bottom:1px; padding-left:40px;">Di RSUP
                        Surakarta</td>
                </tr>
                <tr>
                    <td colspan='3' style="padding-top: 1px; padding-bottom:1px; padding-left:40px;">Mengharap
                        kehadiran
                        Bapak/Ibu/Saudara/i pada :</td>
                </tr>
                <tr>
                    <th class="text-left ml-5"
                        style="width: 25%; padding-top: 1px; padding-bottom:1px; padding-left:40px;">Hari,Tanggal
                    </th>
                    <th class="text-right" style="width: 5%; padding-top: 1px; padding-bottom:1px;">:</th>
                    <th style="width: 70%; padding-top: 1px; padding-bottom:1px;">{{ $arrhari[$tanggal->format('N')] }},
                        {{ $tanggal->format('d-m-Y') }}</th>
                </tr>
                <tr>
                    <th class="text-left ml-5"
                        style="width: 25%; padding-top: 1px; padding-bottom:1px; padding-left:40px;">Waktu</th>
                    <th class="text-right" style="width: 5%; padding-top: 1px; padding-bottom:1px;">:</th>
                    <th style="width: 70%; padding-top: 1px; padding-bottom:1px;">{{ $agenda->waktu_mulai }} -
                        {{ $agenda->waktu_selesai }}</th>
                </tr>
                <tr>
                    <th class="text-left ml-5"
                        style="width: 25%; padding-top: 1px; padding-bottom:1px; padding-left:40px;">Tempat</th>
                    <th class="text-right" style="width: 5%; padding-top: 1px; padding-bottom:1px;">:</th>
                    <th style="width: 70%; padding-top: 1px; padding-bottom:1px;">{{ $agenda->ruangan->nama }}</th>
                </tr>
                <tr>
                    <th class="text-left ml-5"
                        style="width: 25%; padding-top: 1px; padding-bottom:1px; padding-left:40px;">Acara</th>
                    <th class="text-right" style="width: 5%; padding-top: 1px; padding-bottom:1px;">:</th>
                    <th style="width: 70%; padding-top: 1px; padding-bottom:1px;">
                        {{ $agenda->nama_agenda }}
                    </th>
                </tr>

                <tr>
                    <th class="text-left ml-5"
                        style="width: 25%; padding-top: 1px; padding-bottom:1px; padding-left:40px;">Keterangan</th>
                    <th class="text-right" style="width: 5%; padding-top: 1px; padding-bottom:1px;">:</th>
                    <th style="width: 70%; padding-top: 1px; padding-bottom:1px;">
                        @foreach ($keterangan as $keterangan)
                            <p style="padding-top: 1px; padding-bottom:1px; margin-top:1px; margin-bottom:1px;">
                                {{ $keterangan }} </p>
                        @endforeach
                    </th>
                </tr>
                <tr>
                    <td colspan='3' style="padding-top: 1px; padding-bottom:1px; padding-left:40px;">Atas
                        kehadirannya diucapkan terima
                        kasih.</td>
                </tr>

            </tbody>
        </table>
        <table class="table table-borderless">
            <tbody>
                <tr>
                    <td style="width: 50%"></td>
                    <td class="text-center" style="width: 50%; padding-right:40px">{{ $agenda->jab_pengundang }}</td>
                </tr>
                <tr>
                    <td style="width: 80%"></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="width: 80%"></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="width: 50%"></td>
                    <th class="text-center" style="width: 50%; padding-right:40px">{{ $agenda->pengundang }}</th>
                </tr>


            </tbody>

        </table>
    </main>
    <footer>
        {{-- <div>
            <img src="adminlte/dist/img/kars_paripurna.png" alt="Logo Kemenkes" width="50" height="50">
        </div> --}}
        <table class="table table-sm table-borderless" style="margin-bottom:0px;">
            <tr>
                <td style="color: grey; padding-top:25px; padding-bottom:0px; font-size:11px">
                    Dicetak dari PATRIK (Rapat Elektronik) pada {{ \Carbon\Carbon::now()->format('d/m/Y h:i:s') }}
                </td>
                <td class="text-right">
                    <img src="adminlte/dist/img/kars_paripurna.png" alt="Logo Kemenkes" width="50" height="50">
                </td>
            </tr>
        </table>
        {{-- <div class="form-row">
            <div class="col-md-6">
                Dicetak dari PATRIK (Rapat Elektronik) pada {{ \Carbon\Carbon::now()->format('d/m/Y h:i:s') }}
            </div>
            <div class="col-md-4">
                <img src="adminlte/dist/img/kars_paripurna.png" alt="Logo Kemenkes" width="50" height="50">
            </div>
            <div class="col-md-2">

            </div>
        </div> --}}
    </footer>

</body>

</html>
