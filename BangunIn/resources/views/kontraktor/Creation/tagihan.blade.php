@extends('kontraktor.navbar')

@section('content')
<form method="POST" action="/kontraktor/submitTagihan" class="needs-validation" novalidate>
    @csrf
    <div class="option" style="float: right;margin:5px 0px 40px 0px;">
        <a class="btn btn-secondary" href="/kontraktor/listTagihan">List Tagihan</a>
    </div>
<br><br>
    <div class="form-group">
        <label for="exampleInputEmail1">Pekerjaan</label>
        {{-- <input type="text" class="form-control" name="handphoneNumber" value="" required> --}}
        <select name="pekerjaan" id="pekerjaan" class="form-control">
            <option value="-">-</option>
            @foreach ($listDataPekerjaanFix as $item)
                <option value="{{$item->kode_pekerjaan}}">{{$item->nama_pekerjaan}}</option>
            @endforeach
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
    <div class="form-group">
        <label for="exampleInputEmail1">Tagihan ke :</label>
        <input type="text" class="form-control indexTagihan" name="keterangan" value="" required>
        <div class="invalid-feedback">
            Kolom tagihan belum diisi!
        </div>
        @error('keterangan')
        <div class="err">
            {{$message}}
        </div>
        @enderror
    </div>
    <input type="hidden" name="kodejenis" class="kodejenis">
    <input type="hidden" name="indexTagihan" class="indexTagihan">
    <div class="form-group">
        <label for="exampleInputEmail1">Tanggal Tagihan</label>
        <input type="date" id="birthdaytime" name="waktuTagihan" class="form-control">
        <div class="invalid-feedback">
            Kolom nomor telepon belum di isi!
        </div>
        @error('waktuTagihan')
        <div class="err">
            {{$message}}
        </div>
        @enderror
    </div>

    <div class="form-group">
        <label for="exampleInputEmail1">Jumlah Tagihan</label>
        <input type="text" class="form-control" name="jumlah" value="" required>
        <div class="invalid-feedback">
            Kolom nomor telepon belum di isi!
        </div>
        @error('jumlah')
        <div class="err">
            {{$message}}
        </div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Tambah</button>
</form>
<script>
    $(document).ready(function(){
        $('#pekerjaan').change(function(){
            if($(this).val()!=''){
                var value = $(this).val();
                var _token=$('input[name="_token"]').val();
                $.ajax({
                    url:"{{route('cbKirim.cekTagihan')}}",
                    method:"POST",
                    data:{value:value,_token:_token},
                    success:function(result){
                        $(".indexTagihan").val("");
                        $(".indexTagihan").val(result);
                        $(".indexTagihan").prop('readonly',true);
                    }
                })
            }
        });

    })
</script>
@endsection
