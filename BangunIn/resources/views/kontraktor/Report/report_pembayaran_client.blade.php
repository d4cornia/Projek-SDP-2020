<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan pekerjaan</title>
    {{-- <link rel="stylesheet" type="text/css" href="/css/cssB/bootstrap.min.css"> --}}

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
    @php
        // dd($buktiPembayaran);
    @endphp
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
                        <h1>Kwitansi</h1>
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
        @if ($buktiPembayaran != null)
            <div class="kiri" style="float:left;margin-right: 10px;">
                <h3>Telah Diterima Dari </h3>
                <h3>Uang Sejumlah </h3>
                <h3>Untuk Pembayaran </h3>
                <h3>Tanggal Terima </h3>
            </div>
            <div class="kanan">
                <h3>: {{$buktiPembayaran->client->nama_client}}</h3>
                <h3>: Rp. {{number_format($buktiPembayaran->jumlah_pembayaran_client)}}</h3>
                @isset($buktiPembayaran->tagihan->keterangan)
                    <h3>: Tagihan ke- {{$buktiPembayaran->tagihan->keterangan}} dari Pekerjaan {{$buktiPembayaran->pekerjaan->nama_pekerjaan}}</h3>
                    @else
                    <h3>: Pembayaran dari Pekerjaan {{$buktiPembayaran->pekerjaan->nama_pekerjaan}}</h3>
                @endisset
                <h3>: {{$buktiPembayaran->tanggal_pembayan_client}}</h3>
            </div>
        @endif

    </div>
</div>
</body>
</html>
