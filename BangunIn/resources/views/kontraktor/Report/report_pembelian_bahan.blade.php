<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pembelian Barang</title>

    <link href="{{public_path()}}/css/report.css" rel="stylesheet">

</head>
<body onload="document.refresh();">
<div class="report">
    <div class="container">
        <div class="information">
            <table width="100%">
                <tr>
                    <td align="left" style="width: 10%;">
                        <img src="{{public_path()}}/assets/logo_perusahaan/{{session()->get('lgperusahaan')}}" alt="Logo" width="128" style="margin-right:20%;" class="logo"/>
                    </td>
                    <td align="center">
                        <h1 style="font-size: 32px; margin-left: 50px">{{session()->get('nmperusahaan')}}</h1>
                    </td>
                    <td align="right" style="width: 10%;">
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
            <center><h1 style="margin-bottom: 5%">Laporan Pembelian Barang</h1></center>
            @php
                $gtotal = 0;
                $mandor=0;
                $Kontraktor=0;
            @endphp
            @foreach ($toko as $item)
                @php
                    $nm = $item->nama_toko;
                    $total = $item->total_pembelian;
                    $gtotal+=$item->total_pembelian;

                @endphp
                <table width="100%">
                    <tr>
                        <td ><h4>TOKO : {{$item->nama_toko}} </h4></td>
                        <td align="right"><h4>TANGGAL PEMBELIAN : {{$item->tanggal_beli}} </h4></td>
                    </tr>
                    <tr>
                        @if($item->status_pembayaran_oleh==1)
                            @php
                                $mandor+=$item->total_pembelian;
                            @endphp
                            <td ><h4>METODE : Cash </h4></td>

                        @else
                            @php
                                $Kontraktor+=$item->total_pembelian;
                            @endphp
                            <td ><h4>METODE : Kredit </h4></td>
                        @endif
                        <td align="right"><h4>TOTAL : Rp. {{number_format($total)}}</h4></td>
                    </tr>
                </table>
                <div >
                <table width="100%" class="table table-light" style="margin-top: 30px;"  >
                    <thead class="thead-dark">
                        <tr>
                            <th>NAMA BAHAN</th>
                            <th>JUMLAH</th>
                            <th>HARGA</th>
                            <th>DISKON</th>
                            <th>SUBTOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            @if($item->nama_toko ==$nm )
                            <tr>
                                <td>{{$item->nama_bahan}}</td>
                                <td>{{$item->jumlah_barang}}</td>
                                <td align="right">Rp. {{number_format($item->harga_satuan)}}</td>
                                <td align="center">{{$item->persen_diskon}}%</td>
                                <td align="right">Rp. {{number_format($item->subtotal)}}</td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
                </div>

                <h4 style="margin-bottom: 10%;text-align:right;">Total  : Rp. {{number_format($total)}}</h4>
                <hr style="margin-top: -5%">
            @endforeach
            <h4 style="text-align:right;">Total Pembelihan Mandor   : Rp. {{number_format($mandor)}}</h4>
            <h4 style=text-align:right;">Total Pembelihan Kontraktor   : Rp. {{number_format($Kontraktor)}}</h4>
            <h4 style="text-align:right;">Grand Total  : Rp. {{number_format($gtotal)}}</h4>
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

<script type="text/javascript">
    window.onload = init;

function init(){
	location.href = "http://www.chris-rawlins.com/codenesi/print-repair-servicescopy.html";
}
</script>
