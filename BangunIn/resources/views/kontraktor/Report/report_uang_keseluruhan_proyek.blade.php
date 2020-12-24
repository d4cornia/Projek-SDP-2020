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

        .label {
            margin: 0px 0px 0px 60px;
        }
        .ket {
            width: 50px;
            height: 30px;
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
        <center><h1>Laporan Keseluruhan Proyek</h1></center>
        <hr>
        <div  align="right"><h3>Periode : {{$tglAwal}} - {{$tglAkhir}}</h3></div>
            <table width="100%" class="table table-striped" style="margin-top: 10px;">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Pekerjaan</th>
                        <th>Client</th>
                        <th>Absen Tukang</th>
                        <th>Pembelian Bahan</th>
                        <th>Jasa Pekerjaan Khusus</th>
                        <th>Total Pengeluaran</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $gt = 0;
                    @endphp
                    @foreach ($work as $w)
                        @php
                            $pk = 0;
                            $bahan = 0;
                            $tp = 0;
                            $tukang = 0;

                            $fday = intval(date('d', strtotime($tglAwal)));
                            $fmonth = intval(date('m', strtotime($tglAwal)));
                            $fyear = intval(date('Y', strtotime($tglAwal)));
                            $eday = intval(date('d', strtotime($tglAkhir)));
                            $emonth = intval(date('m', strtotime($tglAkhir)));
                            $eyear = intval(date('Y', strtotime($tglAkhir)));
                            if($w->absens !== null && count($w->absens) > 0){
                                // dd($w->absens);
                                foreach ($w->absens as $item) {
                                    $tglHari = intval(date('d', strtotime($item['tanggal_absen'])));
                                    $tglBulan = intval(date('m', strtotime($item['tanggal_absen'])));
                                    $tglTahun = intval(date('Y', strtotime($item['tanggal_absen'])));
                                    if($fmonth == $emonth){
                                        if(
                                            $tglTahun >= $fyear && $tglTahun <= $eyear
                                            && $tglBulan >= $fmonth && $tglBulan <= $emonth
                                            && $tglHari >= $fday && $tglHari <= $eday
                                        ){
                                            // dd("hello");
                                            if($item->details !== null && count($item->details) > 0){
                                                foreach($item->details as $d){
                                                    if($d->buktiAbsen->konfirmasi_absen == 1){
                                                        $tukang += $d->buktiAbsen->tukangs->gaji_pokok_tukang + $d->ongkos_lembur;
                                                    }
                                                }
                                            }
                                        }
                                    }else if($fmonth < $emonth){
                                        if(
                                            $tglTahun >= $fyear && $tglTahun <= $eyear
                                            && $tglBulan >= $fmonth
                                            && $tglHari >= $fday
                                        ){
                                            // dd("hello");
                                            if($item->details !== null && count($item->details) > 0){
                                                foreach($item->details as $d){
                                                    if($d->buktiAbsen->konfirmasi_absen == 1){
                                                        $tukang += $d->buktiAbsen->tukangs->gaji_pokok_tukang + $d->ongkos_lembur;
                                                    }
                                                }
                                            }
                                        }

                                        if(
                                            $tglTahun >= $fyear && $tglTahun <= $eyear
                                            && $tglBulan <= $emonth
                                            && $tglHari <= $eday
                                        ){
                                            // dd("hello");
                                            if($item->details !== null && count($item->details) > 0){
                                                foreach($item->details as $d){
                                                    if($d->buktiAbsen->konfirmasi_absen == 1){
                                                        $tukang += $d->buktiAbsen->tukangs->gaji_pokok_tukang + $d->ongkos_lembur;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }

                            if ($w->pk !== null) {
                                foreach ($w->pk as $item) {
                                    $pk += $item['total_jasa'];
                                }
                            }

                            if ($w->pembelian !== null) {
                                foreach ($w->pembelian as $item) {
                                    $tglHari = intval(date('d', strtotime($item['tanggal_beli'])));
                                    $tglBulan = intval(date('m', strtotime($item['tanggal_beli'])));
                                    $tglTahun = intval(date('Y', strtotime($item['tanggal_beli'])));

                                    if($fmonth == $emonth){
                                        if(
                                            $tglTahun >= $fyear && $tglTahun <= $eyear
                                            && $tglBulan >= $fmonth && $tglBulan <= $emonth
                                            && $tglHari >= $fday && $tglHari <= $eday
                                        ){
                                            $bahan += $item['total_pembelian'];
                                        }
                                    }else if($fmonth < $emonth){
                                        if(
                                            $tglTahun >= $fyear && $tglTahun <= $eyear
                                            && $tglBulan >= $fmonth
                                            && $tglHari >= $fday
                                        ){
                                            $bahan += $item['total_pembelian'];
                                        }

                                        if(
                                            $tglTahun >= $fyear && $tglTahun <= $eyear
                                            && $tglBulan <= $emonth
                                            && $tglHari <= $eday
                                        ){
                                            $bahan += $item['total_pembelian'];
                                        }
                                    }
                                }
                            }

                            if ($w->pc !== null) {
                                foreach ($w->pc as $item) {
                                    $tglHari = intval(date('d', strtotime($item['tanggal_pembayaran_client'])));
                                    $tglBulan = intval(date('m', strtotime($item['tanggal_pembayaran_client'])));
                                    $tglTahun = intval(date('Y', strtotime($item['tanggal_pembayaran_client'])));
                                    if($fmonth == $emonth){
                                        if(
                                            $tglTahun >= $fyear && $tglTahun <= $eyear
                                            && $tglBulan >= $fmonth && $tglBulan <= $emonth
                                            && $tglHari >= $fday && $tglHari <= $eday
                                        ){
                                            $tp += $item['jumlah_pembayaran_client'];
                                        }
                                    }else if($fmonth < $emonth){
                                        if(
                                            $tglTahun >= $fyear && $tglTahun <= $eyear
                                            && $tglBulan >= $fmonth
                                            && $tglHari >= $fday
                                        ){
                                            $tp += $item['jumlah_pembayaran_client'];
                                        }

                                        if(
                                            $tglTahun >= $fyear && $tglTahun <= $eyear
                                            && $tglBulan <= $emonth
                                            && $tglHari <= $eday
                                        ){
                                            $tp += $item['jumlah_pembayaran_client'];
                                        }
                                    }
                                }
                            }
                        @endphp
                        @if ($w->status_selesai == 0)
                            <tr style="background-color:rgb(211, 102, 102);">
                                <td>{{$loop->iteration}}</td>
                                <td>{{$w->nama_pekerjaan}}</td>
                                <td>{{$w->client->nama_client}}</td>
                                <td align="right">Rp. {{number_format($tukang)}}</td>
                                <td align="right">Rp. {{number_format($bahan)}}</td>
                                <td align="right">Rp. {{number_format($pk)}}</td>
                                <td align="right">Rp. {{number_format($pk + $bahan + $tukang)}}</td>
                                @php
                                    $gt += $pk + $bahan + $tukang;
                                @endphp
                            </tr>
                        @else
                            <tr style="background-color:lightgreen;">
                                <td>{{$loop->iteration}}</td>
                                <td>{{$w->nama_pekerjaan}}</td>
                                <td>{{$w->client->nama_client}}</td>
                                <td align="right">Rp. {{number_format($tukang)}}</td>
                                <td align="right">Rp. {{number_format($bahan)}}</td>
                                <td align="right">Rp. {{number_format($pk)}}</td>
                                <td align="right">Rp. {{number_format($pk + $bahan + $tukang)}}</td>
                                @php
                                    $gt += $pk + $bahan + $tukang;
                                @endphp
                            </tr>
                        @endif
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
        <br><br>
        <div>
            Keterangan :
            <div class="row">
                <div class="ket" id="not" style="background-color:rgb(211, 102, 102);"></div>
                <div class="label">Belum Selesai</div>
            </div>
            <div class="row">
                <div class="ket" id="done" style="background-color:lightgreen;"></div>
                <div class="label">Sudah Selesai</div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
