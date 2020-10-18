@extends('admin.navbar')

@section('content')

<h1 class="mb-5">Detail Pembelian</h1>


    @if(count($pembelian)>0)
        <div class="row mb-5">
            <div class="col-8">
                <h4>Detail Pembelian bahan  {{$toko[0]["nama_toko"]}}</h4>
            </div>
            <div class="col-4 text-right">
                <a href="/admin/lihatToko"><button class="btn btn-info">Kembali Ke List</button></a>
            </div>
        </div>
        @for($i=0;$i<count($pembelian);$i++)
        <div id="p{{$i}}">
            <div class="col-md-12 mb-5">

                @php
                    $total=0;
                @endphp
                @for ($j=0; $j < count($arrBeli); $j++)

                    @if($arrBeli[$j]["id_pembelian"] == $pembelian[$i]["id_pembelian"])
                        @php
                            $total+=$arrBeli[$j]["subtotal"];
                        @endphp
                    @endif

                @endfor

                <h6>List Bahan</h6>
                <div class="table-responsive w-100">
                    <table id="tabel-beli" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Bahan Bangunan</th>
                            <th>Jumlah Barang</th>
                            <th>Harga Satuan</th>
                            <th>Diskon</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody id="">
                            @php
                            $no=1;
                            @endphp

                            @for($j=0;$j<count($arrBeli);$j++)

                                @if($arrBeli[$j]["id_pembelian"] == $pembelian[$i]["id_pembelian"])

                                    <tr>

                                        <th scope="row">{{$no}}</th>
                                        <td>{{$arrBeli[$j]["nama_bahan"]}}</td>
                                        <td>{{$arrBeli[$j]["jumlah_barang"]}}</td>
                                        <td align="right">Rp {{number_format($arrBeli[$j]["harga_satuan"])}}</td>
                                        <td>{{$arrBeli[$j]->persen_diskon}}</td>
                                        <td align='right'>Rp {{number_format($arrBeli[$j]["subtotal"])}}</td>

                                    </tr>

                                    @php
                                        $no++;
                                    @endphp
                                @endif

                            @endfor
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Bahan Bangunan</th>
                            <th>Jumlah Barang</th>
                            <th>Harga Satuan</th>
                            <th>Diskon</th>
                            <th>Subtotal</th>
                        </tr>
                    </tfoot>
                    </table>
                </div>
                <h6 class="text-right">Total : Rp {{number_format($total)}}</h6>
            </div>
            @php
                //dd($arrBeli);
            @endphp
                <div class="row">
                    <div class="col-5">
                        <form style='margin-top:50px' method="POST" action="/admin/checkout" class="needs-validation" novalidate id="form">
                        @csrf
                        <h6>Nota Pembelian</h6>
                        <img src="/assets/nota_beli/{{$foto[$i]->file_bukti}}" class="d-block w-100" alt="...">
                    </div>
                    <div class="col-7">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama Toko</label>
                            <input type="text" name="nama" id="nama" class="form-control" required="required" readonly="readonly" value="{{$toko[$i]["nama_toko"]}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Alamat Toko</label>
                            <input type="text" name="alamat" id="alamat" class="form-control" required="required" readonly="readonly" value="{{$toko[$i]["alamat_toko"]}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Total Pembelian</label>
                            <input type="text" name="total" id="total" class="form-control" required="required" readonly="readonly" value="{{number_format($total)}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Pekerjaan</label>
                        <input type="text" name="pekerjaan" id="pekerjaan" class="form-control" required="required" readonly="readonly" value="{{$pekerjaan[$i]["nama_pekerjaan"]}}">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Pekerjaan Khusus</label>
                            <input type="text" name="pk" id="pk" class="form-control" required="required" readonly="readonly" value="{{$getPK[$i]["keterangan_pk"]}}">
                        </div>

                        <div class="form-check form-check-inline mr-5">
                            @if($pembelian[$i]["status_pembayaran_oleh"]==1)
                                <input class="form-check-input" type="radio"  name="status" value="lunas" id="inlineRadio1"  checked>
                            @else
                                <input class="form-check-input" type="radio"  name="status" value="lunas" id="inlineRadio1"  >
                            @endif
                            <label class="form-check-label" for="inlineRadio1">Lunas</label>
                        </div>

                        <div class="form-check form-check-inline ml-5">
                            @if($pembelian[$i]["status_pembayaran_oleh"]==2)
                                <input class="form-check-input" type="radio" onchange="check(1)" name="status" value="bon" id="inlineRadio1" checked>
                            @else
                                <input class="form-check-input" type="radio" onchange="check(1)" name="status" value="bon" id="inlineRadio1">
                            @endif
                            <label class="form-check-label" for="inlineRadio1">Bon</label>
                        </div>

                        <div class="form-group mt-3 ">
                            <label for="exampleInputEmail1">Tanggal Beli</label>
                        <input type="date" name="beli" id="beli" class="form-control" required="required" readonly="readonly" value="{{$pembelian[$i]["tanggal_beli"]}}">
                        </div>
                        @if($pembelian[$i]["tanggal_bayar"]!=null)
                            <div class="form-group mt-3 " id="bbayar">
                                <label for="exampleInputEmail1">Tanggal Bayar</label>
                                <input type="date" name="bayar" id="bayar" class="form-control" required="required" readonly="readonly" value="{{$pembelian[$i]["tanggal_bayar"]}}">
                            </div>
                        @endif
                        @if($pembelian[$i]["tanggal_jatuh_tempo"]!=null)
                            <div class="form-group mt-3 " id="bbayar">
                                <label for="exampleInputEmail1">Tanggal Jatuh Tempo</label>
                            <input type="date" name="bayar" id="bayar" class="form-control" required="required" readonly="readonly" value="{{$pembelian[$i]["tanggal_jatuh_tempo"]}}">
                            </div>
                        @endif
                        @if($pembelian[$i]["tanggal_jatuh_tempo"]!=null&&$pembelian[$i]["tanggal_bayar"]==null)
                            <a href="/bayarBon/{{ $pembelian[$i]["id_pembelian"]}}"><button class="btn btn-danger" type="button">Bayar Bon</button></a>
                        @endif
                        </form>
                    </div>
                </div>
            </div>
        @endfor
        <div class="row mt-5">
            <div class="col-4 text-right">
                <button class="btn btn-primary" onclick="prev()">Prev</button>
            </div>
            <div class="col-4">
                <p class="text-center" id="nav">0/0</p>
            </div>
            <div class="col-4">
                <button class="btn btn-primary" onclick="next()">Next</button>
            </div>
        </div>
    @endif
    <script>
        jum = {{count($pembelian)}}
        active=0;
        nav();
        for (let index = 1; index < jum; index++) {
            $("#p"+index).hide();
        }
        function nav() {
            $('#nav').html(active+1+"/"+jum);
        }
        function next() {
            $("#p"+active).hide();
            active++;
            if(active>=jum){
                active=0;
            }
            $("#p"+active).show();
            nav();
        }
        function prev() {
            $("#p"+active).hide();
            active--;
            if(active<0){
                active=jum-1;
            }
            $("#p"+active).show();
            nav();
        }
    </script>
@endsection
