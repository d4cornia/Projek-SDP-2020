<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan pekerjaan</title>

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
        @foreach ($mans as $m)
            <center><h1>Mandor {{$m->nama_mandor}}</h1></center>
            <hr>
            @php
                $flag = false;
            @endphp
            @if ($req !== null)
                @foreach ($req as $pu)
                    @if($pu->kode_mandor == $m->kode_mandor)
                        <h3>Tanggal {{$pu->tanggal_permintaan_uang}}</h3>
                        @php
                            $flag = true;
                        @endphp

                        @if ($pu->detail_pu !== null && count($pu->detail_pu) > 0)
                            @foreach ($pu->detail_pu as $d)
                                <h5>Nama Pekerjaan : {{$d->pekerjaan->nama_pekerjaan}}</h5>
                                <table width="100%" class="table table-striped" style="margin-top: 30px;" border="1">
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
                                            <td>Claim Nota Pembelian</td>
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
                                <br>
                            @endforeach
                        @endif
                        <h5>Total Detail : Rp. {{number_format($pu->total_detail)}} </h5>
                        <h5>Total Bon : Rp. {{number_format($pu->total_bon)}} </h5>
                        <h5>Total Sistem : Rp. {{number_format($pu->total_sistem)}} </h5>
                        <h4>Total Yang Diminta : Rp. {{number_format($pu->real_total)}} </h4>
                        <h4>Keterangan : {{$pu->keterangan}}</h4>
                        <br><br><br><br><br>
                    @endif
                @endforeach
            @endif
            @if (!$flag)
                <center><h3>Tidak Melakukan Request</h3></center>
            @endif
            <br>
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
