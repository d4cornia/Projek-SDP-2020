@extends('admin.navbar')

@section('content')
    <h1>Detail Bon Pembelian Bahan</h1>
    <div class="option" style="float:right;margin-bottom:10px">
        <a class="btn btn-primary"  href="/admin/vListNotaBon">List Bon Pembelian Bahan</a>
    </div>
    <br>
    <br>
    @foreach ($toko as $item)
        @foreach ($pembelian as $item2)
            @if ($item->id_kerjasama == $item2->id_kerjasama)
                @php
                    $namatoko = $item->nama_toko;
                @endphp
            @endif
        @endforeach
    @endforeach
    @php
        $idbukti = $pembelian[0]->id_bukti;
        $pathfoto="";
        foreach($bukti as $item){
            if($item->id_bukti==$idbukti){
                $pathfoto=$item->file_bukti;
            }
        }
    @endphp
    Toko Bangunan : {{$namatoko}}<br>
    @php
        $namapekerjaan="";
    @endphp
    @foreach ($toko as $item)
        @foreach ($pekerjaan as $item2)
            @if ($item->kode_pekerjaan == $item2->kode_pekerjaan)
                @php
                    $namapekerjaan = $item->nama_pekerjaan;
                @endphp
            @endif
        @endforeach
    @endforeach
    Nama Pekerjaan : {{$namapekerjaan}}<br>
    @if ($pkmemakaibahan!="")
        @php
            $pkbahan = $pkmemakaibahan[0];
            $idpk = $pkbahan->kode_pk;

            $namapk="";
            foreach($pk as $item){
                if($item->kode_pk == $idpk){
                    $namapk = $item->keterangan_pk;
                }
            }
        @endphp
        Pekerjaan Khusus : {{$namapk}}
    @endif
    Total Pembelian : Rp {{number_format($pembelian[0]->total_pembelian)}}<br>
    Tanggal Pembelian : {{$pembelian[0]->tanggal_beli}}<br>
    @php
        $pathsaya = "/assets/nota_beli/".$pathfoto;
    @endphp
    <img style='width:500px;height:500px;' src='{{$pathsaya}}'><br>
    <br>
    <b>
    <form method='post' action='/admin/bayarBonBahan'>
        @csrf
        <input type='hidden' name='kodepembelian' value='{{$pembelian[0]->id_pembelian}}'>
        <input type='hidden' name='idbukti' value='{{$pembelian[0]->id_bukti}}'>
        Tanggal pembayaran : <input type='date' name='tanggal'><br>
        Bukti pembayaran : <input type='file' name='foto'><br>
        <input type='submit' value='Bayar' class='btn-success'>
        <br><br>
    </form>
    </b>
    @if (count($detailbeli) > 0)
        <div class="table-responsive">
            <table id="tabel-nota" class="table table-bordered table-striped">
              <thead>
                <tr>
                    <th>No</th>
                    <th>Bahan Bangunan</th>
                    <th>Jumlah Barang</th>
                    <th>Harga Satuan</th>
                    <th>Persen Diskon</th>
                    <th>Subtotal</th>
                </tr>
              </thead>
              <tbody id="">
                @foreach ($detailbeli as $item)
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            @php
                                $bahans="";
                            @endphp
                            @foreach ($bahan as $item2)
                                @if ($item2->id_bahan==$item->id_bahan)
                                    @php
                                        $bahans=$item2->nama_bahan;
                                    @endphp
                                @endif
                            @endforeach
                            <td>{{$bahans}}</td>

                            <td>{{$item->jumlah_barang}}</td>
                            <td align="right">Rp. {{number_format($item->harga_satuan)}}</td>
                            <td>{{$item->persen_diskon}}</td>
                            <td align="right">Rp. {{number_format($item->subtotal)}}</td>
                        </tr>
                    @endforeach
              </tbody>
              <tfoot>
                <tr>
                    <th>No</th>
                    <th>Bahan Bangunan</th>
                    <th>Jumlah Barang</th>
                    <th>Harga Satuan</th>
                    <th>Persen Diskon</th>
                    <th>Subtotal</th>
                </tr>
              </tfoot>
            </table>
            </div>

    @else
        <h4>Tidak Ada Bon Pembelian Bahan!</h4>
    @endif

    <script>
        $(document).ready(function() {
            $("#tabel-nota").DataTable();
    } );
    </script>
@endsection

