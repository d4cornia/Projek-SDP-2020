<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan pekerjaan</title>
    <link rel="stylesheet" type="text/css" href="/css/cssB/bootstrap.min.css">

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
        <center><h1>{{$pembayaranPekerjaan->nama_pekerjaan}}</h1></center>

        <center><h1>Client : {{$pembayaranPekerjaan->client->nama_client}}</h1></center>
        <hr>
        @php
            $total = 0;

        @endphp
        @if ($pembayaranPekerjaan->pc !== null)
            <table width="100%" class="table table-striped" style="margin-top: 30px;" border="1">
                <thead class="thead-dark">
                    <tr>
                        <th>Tagihan Ke</th>
                        <th>Jumlah</th>
                        <th>Tanggal Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pembayaranPekerjaan->pc as $pk)
                    <tr>
                    <td>{{$pk->id_tagihan}}</td>
                    <td>Rp. {{number_format($pk->jumlah_pembayaran_client)}}</td>
                    <td>{{$pk->tanggal_pembayan_client}}</td>
                    @php
                        $total += $pk->jumlah_pembayaran_client;
                    @endphp
                    </tr>
                    @endforeach
                </tbody>
            </table>
                <h3>Total Keseluruhan : Rp. {{number_format($pembayaranPekerjaan->harga_deal)}} </h3>
                <h3>Total Pembayaran : Rp. {{number_format($total)}}</h3>
                @if ($pembayaranPekerjaan->status_lunas == 0)
                    <h3>Belum Lunas</h3>
                @else
                    <h3>Lunas</h3>
                @endif
                <br><br><br>
        @endif
    </div>
</div>
</body>
</html>
