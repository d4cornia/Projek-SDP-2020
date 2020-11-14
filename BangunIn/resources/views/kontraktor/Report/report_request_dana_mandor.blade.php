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
        @foreach ($mans as $m)
            <center><h1>Mandor {{$m->nama_mandor}}</h1></center>
            <br><br>
            @if ($req !== null)
                @foreach ($req as $pu)
                    @if($pu->kode_mandor == $m->kode_mandor)
                        <h3>Tanggal {{$pu->tanggal_permintaan_uang}}</h3><br>

                        @if ($pu->detail_pu !== null && count($pu->detail_pu) > 0)
                            @foreach ($pu->detail_pu as $d)
                                <h6>Nama Pekerjaan : {{$d->pekerjaan->nama_pekerjaan}}</h6>
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
                                            <td>Rp. {{number_format($d->total_gaji_tukang)}}</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Total Pekerjaan Khusus</td>
                                            <td>Rp. {{number_format($d->total_pk)}}</td>
                                        </tr>
                                        <tr>
                                            <td>#</td>
                                            <td>Sub Total</td>
                                            <td>Rp. {{number_format($d->subtotal)}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br><br>
                            @endforeach
                        @endif
                        <h6>Total Detail : Rp. {{number_format($pu->total_detail)}} </h6>
                        <h6>Total Bon : Rp. {{number_format($pu->total_bon)}} </h6>
                        <h6>Total Sistem : Rp. {{number_format($pu->total_sistem)}} </h6>
                        <h5>Total Yang Diminta : Rp. {{number_format($pu->real_total)}} </h5>
                        <h5>Keterangan : {{$pu->keterangan}}</h5>
                        <hr>
                        <br><br><br><br><br>
                    @endif
                @endforeach
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
