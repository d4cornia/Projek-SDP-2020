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
        <center><h1>{{$work->nama_pekerjaan}}</h1></center>
        <hr>
        @if ($spWork !== null)
            @foreach ($spWork as $pk)
                <h3>Pekerjaan Khusus {{$pk->keterangan_pk}}</h3>

                @if ($pk->bahans !== null && count($pk->bahans) > 0)
                    @foreach ($pk->bahans as $b)
                        <h6>Tanggal beli : {{$b->pembelian->tanggal_beli}}</h6>
                        <table width="100%" class="table table-striped" style="margin-top: 30px;" border="1">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Bahan</th>
                                    <th>Jumlah</th>
                                    <th>Harga Satuan</th>
                                    <th>Persen Diskon</th>
                                    <th>Sub Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($b->pembelian->detail !== null)
                                    @foreach ($b->pembelian->detail as $item)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$item->bhn->nama_bahan}}</td>
                                            <td>{{$item->jumlah_barang}}</td>
                                            <td align="left">Rp. {{number_format($item->harga_satuan)}}</td>
                                            <td align="left">{{$item->persen_diskon}}%</td>
                                            <td align="left">Rp. {{number_format($item->subtotal)}}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td>#</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td align="left">-</td>
                                    </tr>
                                @endif
                                <tr  class="table-info">
                                    <td colspan="4"></td>
                                    <td>Total Pembelian Bahan </td>
                                    <td align="left">
                                        Rp. {{number_format($b->pembelian->total_pembelian)}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    @endforeach
                @endif
                <h6>Total Keseluruhan Pembelian Bahan : Rp. {{number_format($pk->total_bahan)}} </h6>
                <h6>Total Jasa : Rp. {{number_format($pk->total_jasa)}} </h6>
                <h6>Total Keseluruhan : Rp. {{number_format($pk->total_keseluruhan)}} </h6>
                <br><br><br>
            @endforeach
        @endif
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
