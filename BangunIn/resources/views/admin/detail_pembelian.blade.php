@extends('admin.navbar')

@section('content')

<h1 class="mb-5">Detail Pembelian</h1>

<div class="col-md-12 mb-5">
    <h4>Detail Pembelian bahan</h4>
    @php
    $arrBeli = json_decode($listBeli);
@endphp
<br>
@if (count($arrBeli)>0)
        @csrf
        @php
            $total=0;
            foreach ($arrBeli as $item){
                $total+=$item->subtotal;
            }
        @endphp

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
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="">

                @foreach ($arrBeli as $item)
                    <tr>

                        <th scope="row">{{$loop->iteration}}</th>
                        <td>{{$item->nama_bahan}}</td>
                        <td>{{$item->jumlah_barang}}</td>
                        <td align="right">Rp {{number_format($item->harga_satuan)}}</td>
                        <td>{{$item->persen_diskon}}</td>
                        <td align='right'>Rp {{number_format($item->subtotal)}}</td>
                        <td>
                        <button type='submit' name='kodeku' value='{{$item->nama_bahan}}' class="btn btn-danger">Batal</button>
                        </td>
                    </tr>
                @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>No</th>
                <th>Bahan Bangunan</th>
                <th>Jumlah Barang</th>
                <th>Harga Satuan</th>
                <th>Diskon</th>
                <th>Subtotal</th>
                <th>Action</th>
            </tr>
        </tfoot>
        </table>
    </div>
    <h6 class="text-right">Total : Rp {{number_format($total)}}</h6>
</div>
<div class="row">
    <div class="col-5">
        <form style='margin-top:50px' method="POST" action="/admin/checkout" class="needs-validation" novalidate id="form">
        @csrf
        <h6>Nota Pembelian</h6>
        <img src="/assets/nota_beli/{{$foto[0]["file_bukti"]}}" class="d-block w-100" alt="...">
    </div>
    <div class="col-7">
            <div class="form-group">
                <label for="exampleInputEmail1">Nama Toko</label>
                <input type="text" name="nama" id="nama" class="form-control" required="required" readonly="readonly" value="{{session()->get('namatoko')}}">
            </div>
            <div class="form-group">
                <input type="hidden" name="now" id="now" class="form-control" value="{{$id_foto}}">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Alamat Toko</label>
                <input type="text" name="alamat" id="alamat" class="form-control" required="required" readonly="readonly" value="{{$alamat[0]}}">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Total Pembelian</label>
                <input type="text" name="total" id="total" class="form-control" required="required" readonly="readonly" value="{{number_format($total)}}">
                <input type="hidden" name="vtotal" id="vtotal" class="form-control" required="required" readonly="readonly" value="{{$total}}">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Pekerjaan</label>
                <select name="pekerjaan" id="pekerjaan" class="form-control" required="required">
                    <option readonly="readonly"d selected>Pilih Pekerjaan</option>
                    @foreach ($listPekerjaan as $item)
                            <option value="{{$item["kode_pekerjaan"]}}">{{$item["nama_pekerjaan"]}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Pekerjaan Khusus</label>
                <select name="spekerjaan" id="spekerjaan" class="form-control">
                </select>
            </div>


            <div class="form-check form-check-inline mr-5">
                <input class="form-check-input" type="radio" onchange="check(0)" name="status" value="lunas" id="inlineRadio1"  >
                <label class="form-check-label" for="inlineRadio1">Lunas</label>
            </div>
            <div class="form-check form-check-inline ml-5">
                <input class="form-check-input" type="radio" onchange="check(1)" name="status" value="bon" id="inlineRadio1" checked>
                <label class="form-check-label" for="inlineRadio1">Bon</label>
            </div>

            <div class="form-group mt-3 ">
                <label for="exampleInputEmail1">Tanggal Beli</label>
                <input type="date" name="beli" id="beli" class="form-control" required="required" value="">
            </div>
            <a href="/admin/vpembelianNota"><button class="btn btn-info mr-3">Kembali</button></a>
            <button class="btn btn-success" type="submit">Simpan</button>
        </form>
    </div>

</div>

    @endif
<script>
    $('#bbayar').hide();
    $('#pekerjaan').change(function(){
            if($(this).val()!=''){
                var value = $(this).val();
                var _token=$('input[name="_token"]').val();
                $.ajax({
                    url:"{{route('admin.getSpesial')}}",
                    method:"POST",
                    data:{value:value,_token:_token},
                    success:function(result){
                        $("#spekerjaan").html(result);
                    }
                })
            }
    });
</script>
@endsection
