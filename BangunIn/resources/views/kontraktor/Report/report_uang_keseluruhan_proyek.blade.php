<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan pekerjaan</title>
    {{-- <link rel="stylesheet" type="text/css" href="{{public_path()}}/css/cssB/bootstrap.min.css"> --}}

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
        <center><h1>Laporan Keseluruhan Proyek</h1></center>
        <hr>
        <h4>Client : {{$work->client->nama_client}}</h4>
        <h4>Pekerjaan : {{$work->nama_pekerjaan}}</h4>
        <h4>Status pekerjaan : @if ($work->status_selesai == 0)
            Belum selesai
            @else
            Selesai
        @endif</h4>
        <h4>Total Pembayaran : Rp. {{number_format($total_pembayaran)}}</h4>
        <hr>

        <table width="100%" class="table table-striped" style="margin-top: 30px;"  border="1">
            <thead class="thead-dark">
                <tr>
                    <th>Keterangan</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        Pembayaran Tukang @if ($minggu > 0) {{$minggu}} Minggu @endif @if ($hari > 0)
                            {{$hari}} Hari
                        @endif
                    </td>
                    <td>Rp. {{number_format($tukang)}}</td>
                </tr>
                <tr>
                    <td>Pembelian Bahan</td>
                    <td>Rp. {{number_format($bahan)}}</td>
                </tr>
                <tr>
                    <td>Pekerjaan Khusus</td>
                    <td>Rp. {{number_format($pk)}}</td>
                </tr>
            </tbody>
        </table>
        <h2>Total Pengeluaran : Rp. {{number_format($pk + $bahan + $tukang)}}</h2>
        @if ($total_pembayaran - ($pk + $bahan + $tukang) < 0)
            <h2 style="color: red;">Sisa Uang : Rp. -{{ number_format(($pk + $bahan + $tukang) - $total_pembayaran) }}</h2>
        @else
            <h2 style="color: green;">Sisa Uang : Rp. {{ number_format($total_pembayaran - ($pk + $bahan + $tukang)) }}</h2>
        @endif
        <br><br>
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
