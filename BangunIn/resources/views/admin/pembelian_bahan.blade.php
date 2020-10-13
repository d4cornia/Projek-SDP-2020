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
                @endphp
                @foreach ($data as $item)
                    <option>{{$item}}</option>
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
            <label for="exampleInputEmail1">Subtotal</label>
            <input type="number" class="form-control"  min="0" id="subtotal" name="subtotal" required="required" readonly step="500" value="0">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Pekerjaan</label>
            <select name="pekerjaan" id="pekerjaan" class="form-control" required="required">
                <option disabled selected>Pilih Pekerjaan</option>
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
        <button type="submit" class="btn btn-success">Tambah</button>
    </div>
</form>
</div>
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
