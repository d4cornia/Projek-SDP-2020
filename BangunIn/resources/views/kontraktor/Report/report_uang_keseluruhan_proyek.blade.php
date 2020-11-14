<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan pekerjaan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <style type="text/css">
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
            padding-left: 25%;
            padding-right: 25%;
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
                    <img src="/assets/logo_perusahaan/{{session()->get('lgperusahaan')}}" alt="Logo" width="128" class="logo"/>
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
        <h4>Pekerjaan : {{$work->nama_pekerjaan}}</h4>
        <h4>Client : {{$work->nama_pekerjaan}}</h4>
        <h4>Total Pembayaran : Rp. {{number_format($total_pembayaran)}}</h4><br>


        <table width="100%" class="table table-striped" style="margin-top: 30px;">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Keterangan</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Claim Nota Kembalian</td>
                    <td>Rp. {{number_format($d->claim_nota_pembelian)}}</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Total Gaji</td>
                    <td>Rp. {{number_format($d->totalgaji)}}</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Total Pekerjaan Khusus</td>
                    <td>Rp. {{number_format($d->totalpk)}}</td>
                </tr>
                <tr>
                    <td>#</td>
                    <td>Sub Total</td>
                    <td>Rp. {{number_format($d->subtotal)}}</td>
                </tr>
            </tbody>
        </table>
        <h2>Total Pengeluaran : Rp. </h2>
        <h2>Sisa Uang : Rp. </h2>
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
