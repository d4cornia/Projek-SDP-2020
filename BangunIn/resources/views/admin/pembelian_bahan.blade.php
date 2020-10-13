@extends('admin.navbar')

@section('content')
<h1 class="mb-3">Input Nota Bahan Toko Bangunan</h1>
<div class="option col-12 text-right mb-5" style="margin-top: 0px">
    <a class="btn btn-primary"  href="/admin/lihatToko" style="width:250px"><font size="3">Lihat Toko Bangunan</font></a>
    <a class="btn btn-info"  href="/admin/tambahToko" style="width:250px"><font size="3">Tambah Toko Bangunan</font></a>
    <a class="btn btn-secondary"  href="/admin/inputBahan" style="width:250px"><font size="3">Tambah Bahan Bangunan</font></a>
</div>

<div class="row">
    <div class="col-5">
    <form style='margin-top:50px' method="POST" action="/admin/pembelianNota" class="needs-validation" novalidate>
            @csrf

        <div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="false" style="width:100%;">
            <div class="carousel-inner">
                @php $i=0; @endphp
                @foreach ($listFoto as $item)
                    @if($i==0)
                        <div class="carousel-item active">
                            <img src="/assets/nota_beli/{{$item->file_bukti}}" class="d-block w-100" alt="...">
                        </div>
                    @else
                        <div class="carousel-item">
                            <img src="/assets/nota_beli/{{$item->file_bukti}}" class="d-block w-100" alt="...">
                        </div>

                    @endif
                    @php $i++; @endphp
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#carouselExampleFade" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only" style="color: black">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleFade" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
    <div class="col-7">
        <div class="form-group">
            <label for="exampleInputEmail1">Nama Toko</label>
            <select name="nama" id="nama" class="form-control" required="required">
                <option disabled selected>Pilih Nama Toko</option>
                @php
                    $data = array_unique($listToko,SORT_STRING);
                    if(session()->has('namatoko')){
                        $namatoko=session()->get('namatoko');
                    }
                    else{
                        $namatoko="";
                    }
                @endphp
                @foreach ($data as $item)
                    @if ($item==$namatoko)
                        <option value='{{$item}}' selected='true'>{{$item}}</option>
                    @else
                        <option value='{{$item}}'>{{$item}}</option>
                    @endif
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">Alamat Toko</label>
            <select name="alamat" id="alamat" class="form-control" required="required">
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Nama Bahan</label>
            <select name="bahan" id="bahan" class="form-control" required="required">
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Harga Bahan</label>
            <input type="number" class="form-control"  min="0" id="hargabahan" name="hargabahan" required="required" step="500" value="0">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Jumlah Bahan</label>
            <input type="number" class="form-control"  min="0" id="jumlah" name="jumlah" required="required" step="0.01" value="0">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Persen Diskon</label>
            <input type="number" class="form-control"  min="0" id="diskon" name="diskon" required="required" step="1" value="0">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Subtotal</label>
            <input type="number" class="form-control"  min="0" id="subtotal" name="subtotal" required="required" readonly step="500" value="0">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Pekerjaan</label>
            <select name="pekerjaan" id="pekerjaan" class="form-control" required="required">
                <option disabled selected>Pilih Pekerjaan</option>
                @php
                    if(session()->has('pek')){
                        $pek=session()->get('pek');
                    }
                    else{
                        $pek="";
                    }
                @endphp
                @foreach ($listPekerjaan as $item)
                    @if ($item['kode_pekerjaan']==$pek)
                        <option value="{{$item["kode_pekerjaan"]}}" selected='true'>{{$item["nama_pekerjaan"]}}</option>
                    @else
                        <option value="{{$item["kode_pekerjaan"]}}">{{$item["nama_pekerjaan"]}}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Pekerjaan Khusus</label>
            <select name="spekerjaan" id="spekerjaan" class="form-control">
            </select>
        </div>
        <button type="submit" class="btn btn-success">Tambah</button>
    </div>
</form>
</div>
    @php
        $arrBeli = json_decode($listBeli);
    @endphp
    <br>
    @if (count($arrBeli)>0)
        <form method="POST" action="/admin/tabelBeli" class="needs-validation" novalidate>
            @csrf
            @php
                $total=0;
                foreach ($arrBeli as $item){
                    $total+=$item->subtotal;
                }
            @endphp
        <h3>Total : Rp {{number_format($total)}}</h3>
        <div class="table-responsive">
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
                </form>
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
        <form method="POST" action="/admin/simpanPembelian" class="needs-validation" novalidate>
            @csrf
            <button type="submit" class="btn btn-success" name='btnSimpan'>Simpan</button>
        </form>
    @endif
@if($msg = Session::get('success'))
    <script>
        swal('Berhasil!', "{{Session::get('success')}}", "success");
    </script>
@endif
<script>
    $(document).ready(function(){
        $('#nama').change(function(){
            if($(this).val()!=''){
                var value = $(this).val();
                var _token=$('input[name="_token"]').val();
                $.ajax({
                    url:"{{route('admin.getAlamat')}}",
                    method:"POST",
                    data:{value:value,_token:_token},
                    success:function(result){
                        $("#alamat").html(result);
                    }
                })
            }
        });
        $('#alamat').change(function(){
            if($(this).val()!=''){
                var value = $(this).val();
                var _token=$('input[name="_token"]').val();
                $.ajax({
                    url:"{{route('admin.getBahan')}}",
                    method:"POST",
                    data:{value:value,_token:_token},
                    success:function(result){
                        $("#bahan").html(result);
                    }
                })
            }
        });
        $('#bahan').change(function(){
            if($(this).val()!=''){
                option = $(this).find('option:selected');
                harga = option.attr("harga");
                $('#hargabahan').val(harga);
            }
        });
        $('#jumlah').change(function(){

            if($(this).val()>=0){
                var jumlah =  $('#jumlah').val();
                var harga =  $('#hargabahan').val();

                $('#subtotal').val(jumlah*harga);
            }
            else{
                $('#jumlah').val(0);
            }
        });
        $('#diskon').change(function(){
            if($(this).val()>=0){
                var diskon =  $('#diskon').val();
                var sub =  $('#subtotal').val();

                $('#subtotal').val((100-diskon)*sub/100);
            }
            else{
                $('#diskon').val(0);
            }
        });
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
    })
</script>
@endsection
