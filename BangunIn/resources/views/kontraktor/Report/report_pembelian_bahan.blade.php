<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pembelian Barang</title>

    <link href="{{public_path()}}/css/report.css" rel="stylesheet">

</head>
<body>
<div class="report">
    <div class="container">
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
            <center><h1>Laporan Pembelian Barang</h1></center>
            @foreach ($toko as $item)
                @php
                    $nm = $item->nama_toko;
                    $total = $item->total_pembelian;
                @endphp
                <hr>
                <h4>TOKO : {{$item->nama_toko}}</h4>
                <h4>TANGGAL PEMBELIAN : {{$item->tanggal_beli}}</h4>
                <h4>TOTAL PEMBELIAN   : Rp. {{number_format($total)}}</h4>
                <hr>

                <table width="100%" class="table table-light" style="margin-top: 30px;"  >
                    <thead class="thead-dark">
                        <tr>
                            <th>NAMA BAHAN</th>
                            <th>JUMLAH</th>
                            <th>HARGA</th>
                            <th>SUBTOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            @if($item->nama_toko ==$nm )
                            <tr>
                                <td>{{$item->nama_bahan}}</td>
                                <td>{{$item->jumlah_barang}}</td>
                                <td>{{$item->harga_satuan}}</td>
                                <td>{{$item->subtotal}}</td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
                <h4 style="margin-bottom: 10%;text-align:right;">Total  : Rp. {{number_format($total)}}</h4>
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
</div>
</body>
</html>
