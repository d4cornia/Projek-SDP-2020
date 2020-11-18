<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan pekerjaan</title>

    <link href="{{public_path()}}/css/report.css" rel="stylesheet">
    <style type="text/css">
        .page-break {
            page-break-after: always;
        }
        @page {
            margin: 0px;
        }
        body {
            margin: 0px;
        }
        * {
            font-family: Verdana, Arial, sans-serif;
        }
        a {
            color: #fff;
            text-decoration: none;
        }
        table {
            font-size: small;
        }
        tfoot tr td {
            font-weight: bold;
            font-size: small;
        }
        .information {
            background-color: #4698db;
            color: #FFF;
        }
        .information .logo {
            margin: 15px;
        }
        .information table {
            padding: 10px;
        }
        .report{
            padding-left: 5%;
            padding-right: 5%;
        }
        .isi {
            padding-right: 25px;
        }
    </style>

</head>
<body>

<div class="report">
    <div class="information">
        <table width="100%">
            <tr>
                <td align="left" style="width: 20%;">
                    <img src="{{public_path()}}/assets/logo_perusahaan/{{session()->get('lgperusahaan')}}" alt="Logo" width="128" class="logo"/>
                </td>
                <td align="center">
                    <h1 style="font-size: 32px; margin-left: 155px">{{session()->get('nmperusahaan')}}</h1>
                </td>
                <td align="right" style="width: 20%;">
                    <div class="isi">
                        <h3 style="font-size: 20px; color: white; margin-top: 30px;">{{session()->get('nama')}}</h3>
                        <pre style="font-size: 13px; font-weight: bold;margin-bottom: 0px;color: white;">

                            {{session()->get('no')}}
                            {{session()->get('alamat')}}
                        </pre>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <br/>
    <div class="invoice">
        <hr>
        <center><h1>Rekap Gaji Tukang</h1></center>
        <hr>
        @foreach ($mans as $m)
            <h3>Mandor {{$m->nama_mandor}}</h3>
            @if ($m->tukangs !== null && count($m->tukangs) > 0)
                <table width="100%" class="table table-striped" style="margin-top: 30px;" border="1">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Tukang</th>
                            <th>Jumlah Absen</th>
                            <th>Gaji Pokok/th>
                            <th>Total Gaji Absen</th>
                            <th>Total Jumlah Ongkos Lembur</th>
                            <th>Total Keseluruhan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($m->tukangs as $t)
                            @php
                                $ongkosLembur = 0;
                                $ctrAbsen = 0;
                            @endphp
                            @foreach ($header as $h)
                                @if ($h->details !== null)
                                    @foreach ($h->details as $d)
                                        @if ($d->kode_tukang == $t->kode_tukang)
                                            @php
                                                $ongkosLembur+=$d->ongkos_lembur;
                                                $ctrAbsen++;
                                            @endphp
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$t->nama_tukang}}</td>
                                <td align="right">Rp. {{number_format($ctrAbsen)}}</td>
                                <td align="right">Rp. {{number_format($t->gaji_pokok_tukang)}}</td>
                                <td align="right">Rp. {{number_format($ctrAbsen * $t->gaji_pokok_tukang)}}</td>
                                <td align="right">Rp. {{number_format($ongkosLembur)}}</td>
                                <td align="right">Rp. {{number_format(($ctrAbsen * $t->gaji_pokok_tukang) + $ongkosLembur)}}</td>
                            </tr>
                            @php
                                $gt += (($ctrAbsen * $t->gaji_pokok_tukang) + $ongkosLembur);
                            @endphp
                        @endforeach
                        <tr class="table-info">
                            <td colspan="5"></td>
                            <td>Grand Total</td>
                            <td align="right">
                                Rp. {{number_format($gt)}}
                            </td>
                        </tr>
                    </tbody>
                </table>
            @else
                <h3>Tidak Ada Tukang</h3>
            @endif
        @endforeach
        <div class="page-break"></div>
        <br><hr>
        <center><h1>Detail Gaji Tukang</h1></center>
        <hr>
        @foreach ($mans as $m)
            <h3>Mandor {{$m->nama_mandor}}</h3>
            <hr>
            @if ($m->tukangs !== null && count($m->tukangs) > 0)
                @foreach ($m->tukangs as $t)
                    <h5>Tukang {{$t->nama_tukang}}</h5>

                    @php
                        $to = 0;
                        $ctr = 0;
                    @endphp
                    <table width="100%" class="table table-striped" style="margin-top: 30px;" border="1">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Tanggal Absen</th>
                                <th>Ongkos Lembur</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($header !== null)
                                @foreach ($header as $h)
                                    @php
                                        $flag = false;
                                        $id = 0;
                                        $ctr2 = 0;
                                    @endphp
                                    @if ($h->details !== null)
                                        @foreach ($h->details as $d)
                                            @if ($d->kode_tukang == $t->kode_tukang)
                                                @php
                                                    $id = $ctr2;
                                                    $flag = true;
                                                @endphp
                                            @endif
                                            @php
                                                $ctr2++;
                                            @endphp
                                        @endforeach
                                        @if($flag)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$h->tanggal_absen}}</td>
                                                <td>Rp. {{number_format($h->details[$id]->ongkos_lembur)}}</td>
                                                <td><input type="checkbox" name="" id="" checked disabled></td>
                                            </tr>
                                            @php
                                                $to += $h->details[$id]->ongkos_lembur;
                                                $ctr++;
                                            @endphp
                                        @else
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$h->tanggal_absen}}</td>
                                                <td>Rp. 0</td>
                                                <td><input type="checkbox" name="" id="" disabled></td>
                                            </tr>
                                        @endif
                                    @endif
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    <h4>Total Ongkos Lembur : Rp. {{number_format($to)}}</h4>
                    <h4>Gaji dari absen : Rp. {{number_format($t->gaji_pokok_tukang * $ctr)}}</h4>
                    <h4>Total Gaji : Rp. {{number_format(($t->gaji_pokok_tukang * $ctr) + $to)}}</h4>
                    <br><br><br>
                @endforeach
            @else
                <center><h3>Tidak Ada Tukang</h3></center>
            @endif
        @endforeach
    </div>

    {{-- <div class="information" style="position: absolute; bottom: 0;">
        <table>
            <tr>
                <td align="left" style="width: 50%;">
                    &copy; {{ date('Y') }} {{ config('app.url') }} - All rights reserved.
                </td>
                <td align="right" style="width: 50%;">
                    Company Slogan
                </td>
            </tr>
        </table>
    </div> --}}
</div>
</body>
</html>
