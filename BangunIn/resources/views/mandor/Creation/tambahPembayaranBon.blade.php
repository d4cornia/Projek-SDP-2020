@extends('mandor.navbar')

@section('content')
<form method="POST" action="/mandor/submitBayarBon" class="needs-validation" novalidate>
    @csrf

    <div class="form-group">
        <label for="nm">Nama Tukang</label>
        <div class="my-1">
            <select class="custom-select mr-sm-2 dynamic" id="inlineFormCustomSelect" name="nm" id="nm">
                <option selected value=''>-</option>
                @foreach ($listTukang as $item)
                    @foreach ($listJenis as $item2)
                        @if ($item->kode_jenis==$item2->kode_jenis)
                            <option value="{{$item['kode_tukang']}}">{{$item['nama_tukang']}}-{{$item2['nama_jenis']}}</option>
                        @endif
                    @endforeach
                @endforeach
            </select>
        </div>
        <div class="invalid-feedback">
            Kolom Nama Tukang belum di pilih!
        </div>
        @error('nm')
        <div class="err">
            {{$message}}
        </div>
        @enderror
    </div>
    <div class="form-group">
        <label for="detailbon">Detail Bon</label>
        <div class="my-1">
            <select class="custom-select mr-sm-2 isi" id="inlineFormCustomSelect" name="detailbon" id="detailbon">
                <option selected>-</option>

            </select>

        </div>
        <div class="invalid-feedback">
            Kolom Detail Bon belum di isi!
        </div>
        @error('detailbon')
        <div class="err">
            {{$message}}
        </div>
        @enderror
    </div>
    {{ csrf_field() }}
    <div class="form-group">
        <label for="exampleInputEmail1">Jumlah Pembayaran</label>
        <input type="text" class="form-control" name="jumlahbyr" value="{{old('jumlahbyr')}}" required>
        <div class="invalid-feedback">
            Kolom Jumlah Pembayaran Bon belum di isi!
        </div>
        @error('jumlahbyr')
        <div class="err">
            {{$message}}
        </div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary" name='btnTambah'>Tambah</button>
</form>


    @php
        $arrbayar = json_decode($listBayar);
        //echo "masuksini";
        //echo "Ctr : ".count($arrbayar);
    @endphp
    <br>
    @if (count($arrbayar)>0)
        <form method="POST" action="/mandor/tabelBayar" class="needs-validation" novalidate>
            @csrf

        <div class="table-responsive">
            <table id="tabel-bayar" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username Tukang</th>
                    <th>Kode Bon</th>
                    <th>Keterangan</th>
                    <th>Jumlah Bayar</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="">

                    @foreach ($arrbayar as $item)
                        <tr>

                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{$item->nama_tukang}}</td>
                            <td>{{$item->kode_bon}}</td>
                            <td>{{$item->keterangan}}</td>
                            <td>{{$item->jumlah_bayar}}</td>
                            <td>
                            <button type='submit' name='kodeku'value='{{$item->kode_bon}}' class="btn btn-danger">Batal</button>
                            </td>
                        </tr>
                    @endforeach
                </form>
            </tbody>
            <tfoot>
                <tr>
                    <th>No</th>
                    <th>Username Tukang</th>
                    <th>Kode Bon</th>
                    <th>Keterangan</th>
                    <th>Jumlah Bayar</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            </table>
        </div>
        <form method="POST" action="/mandor/simpanBayarBon" class="needs-validation" novalidate>
            @csrf
            <button type="submit" class="btn btn-success" name='btnSimpan'>Simpan</button>
        </form>
    @endif


<script>
    $(document).ready(function() {
        $("#tabel-bayar").DataTable();
} );
</script>
<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
      'use strict';
      window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
          form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add('was-validated');
          }, false);
        });
      }, false);
    })();
</script>
<script>
    $(document).ready(function(){
       //alert("hai");
        $('.dynamic').change(function(){
            //alert('masuk');

            if($(this).val()!=''){
                //alert($(this).val());

                var value = $(this).val();
                var _token=$('input[name="_token"]').val();
                $.ajax({
                    url:"{{route('dynamicdependent.fetch')}}",
                    method:"POST",
                    data:{value:value,_token:_token},
                    success:function(result){
                        //alert("Res"+result);
                        $(".isi").html(result);
                    }
                })
            }
        });
    })
</script>
@endsection
