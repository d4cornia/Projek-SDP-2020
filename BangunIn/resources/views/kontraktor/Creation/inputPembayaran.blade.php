@extends('kontraktor.navbar')

@section('content')

{{-- {{dd($listDataClient)}} --}}
{{-- {{dd($listDataPekerjaan)}} --}}
{{-- {{dd($listNamaClient)}} --}}

<form method="POST" action="/kontraktor/submitPembayaran" class="needs-validation" novalidate>
    @csrf
    <div class="form-group">
        <label for="exampleInputEmail1">Nama Client</label>
        <select name="namaClient" id="" class="form-control dynamic">
            <option value="-">-</option>
            @foreach ($listNamaClient as $item)
                <option value="{{$item->kode_client}}">{{$item->nama_client}}</option>
            @endforeach
        </select>
        @error('namaClient')
        <div class="err">
            {{$message}}
        </div>
        @enderror
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Pekerjaan</label>
        {{-- <input type="text" class="form-control" name="handphoneNumber" value="" required> --}}
        <select name="pekerjaan" id="isiPekerjaan" class="form-control isiPekerjaan">

        </select>
        <div class="invalid-feedback">
            Kolom nomor telepon belum di isi!
        </div>
        @error('pekerjaan')
        <div class="err">
            {{$message}}
        </div>
        @enderror
    </div>
    <label for="exampleInputEmail1">Tipe Pekerjaan</label>
    <div class="radio" style="display: flex">
        <div class="form-check" style="margin-right: 2vw;">
            <input class="form-check-input" type="radio" name="radio" id="fix" value="0" checked>
            <label class="form-check-label" for="exampleRadios1">
              Harga Fix di Depan
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="radio" id="komisi" value="1">
            <label class="form-check-label" for="exampleRadios2">
              Komisi
            </label>
          </div>
    </div><br>
    <div class="form-group">
        <label for="exampleInputEmail1">List Tagihan Fix</label>
        {{-- <input type="text" class="form-control" name="handphoneNumber" value="" required> --}}
        <select name="tagihan" id="tagihan" class="form-control isiTagihan">

        </select>
        <div class="invalid-feedback">
            Kolom tagihan belum diisi!
        </div>
        @error('tagihan')
        <div class="err">
            {{$message}}
        </div>
        @enderror
    </div>

    <input type="hidden" name="kodejenis" class="kodejenis">
    <div class="form-group">
        <label for="exampleInputEmail1">Waktu Pembayaran</label>
        <input type="date" id="birthdaytime" name="waktuPembayaran" class="form-control">
        <div class="invalid-feedback">
            Kolom waktu pembayaran belum di isi!
        </div>
        @error('waktuPembayaran')
        <div class="err">
            {{$message}}
        </div>
        @enderror
    </div>

    <div class="form-group">
        <label for="exampleInputEmail1">Total</label>
        <input type="text" class="form-control" name="total" value="" required>
        <div class="invalid-feedback">
            Kolom total belum di isi!
        </div>
        @error('total')
        <div class="err">
            {{$message}}
        </div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Tambah</button>
</form>
<script>
    $(document).ready(function(){
        $('.dynamic').change(function(){

            if($(this).val()!=''){

                var value = $(this).val();
                var _token=$('input[name="_token"]').val();
                $.ajax({
                    url:"{{route('cbPekerjaan.fetch')}}",
                    method:"POST",
                    data:{value:value,_token:_token},
                    success:function(result){
                        $(".isiPekerjaan").html("");
                        $(".isiPekerjaan").html(result);
                    }
                })
            }
        });
        $('.isiPekerjaan').change(function () {
            // if($(this).val()!= '')
            // {
            //     var value = $(this).val();
            //     var _token=$('input[name="_token"]').val();
            //     $.ajax({
            //         url:"{{route('cb.fetch1')}}",
            //         method:"POST",
            //         data:{value:value,_token:_token},
            //         success:function(result){
            //             $(".kodejenis").html("");
            //             $(".kodejenis").val(result);
            //         }
            //     })
            // }
        });
        $("#fix").click(function () {
            $("#tagihan").prop('disabled', false);
            if($("#isiPekerjaan").val()!= '')
            {
                var value = $("#isiPekerjaan").val();
                var _token=$('input[name="_token"]').val();
                $.ajax({
                    url:"{{route('cb.fetch1')}}",
                    method:"POST",
                    data:{value:value,_token:_token},
                    success:function(result){
                        // $(".kodejenis").html("");
                        // $(".kodejenis").val(result);
                        $(".isiTagihan").html("");
                        $(".isiTagihan").html(result);
                    }
                })
            }
        });
        $("#komisi").click(function () {
            $("#tagihan").prop('disabled',true);
        });
    })
</script>
@endsection
