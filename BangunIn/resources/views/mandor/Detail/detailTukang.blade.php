@extends('mandor.navbar')

@section('content')
<form method="POST" action="/mandor/updateTukang" class="needs-validation" novalidate>
    @csrf
    <input type='hidden' name='kodetukang' value={{$kodetukang}}>
    <div class="form-group">
        <label for="exampleInputEmail1">Nama Tukang</label>
        <input type="text" class="form-control" name="name" value="{{$namatukang}}" required>
        <div class="invalid-feedback">
            Kolom nama belum di isi!
        </div>
        @error('name')
        <div class="err">
            {{$message}}
        </div>
        @enderror
    </div>
    <div class="form-group">
        <label for="nm">Jenis Tukang</label>
        <div class="my-1">
        <select class="custom-select mr-sm-2 dynamic" id="inlineFormCustomSelect" name="jenis" id="jenis">
                <option selected value=''>-</option>
                @foreach ($listJenis as $item)
                    @if ($kodejenistukang==$item['nama_jenis'])
                        <option value="{{$item['nama_jenis']}}" selected='selected'>{{$item['nama_jenis']}}</option>
                    @else
                        <option value="{{$item['nama_jenis']}}">{{$item['nama_jenis']}}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Gaji Tukang</label>
        <input type="text" class="form-control" id="gaji" name="gaji" value="{{$gajitukang}}" required>
        <div class="invalid-feedback">
            Kolom gaji tukang belum di isi!
        </div>
        @error('gaji')
        <div class="err">
            {{$message}}
        </div>
        @enderror
    </div>
    {{ csrf_field() }}
    <div class="form-group">
        <label for="exampleInputEmail1">No Telepon</label>
        <input type="text" class="form-control" name="no" value="{{$notelptukang}}" required>
        <div class="invalid-feedback">
            Kolom nomor telepon belum di isi!
        </div>
        @error('no')
        <div class="err">
            {{$message}}
        </div>
        @enderror
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Nama Pengguna</label>
        <input type="text" class="form-control" readonly="readonly" name="username" value="{{$usernametukang}}" required>
        <div class="invalid-feedback">
            Kolom nama pengguna belum di isi!
        </div>
        @error('username')
        <div class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Alamat E-mail</label>
        <input type="email" class="form-control" name="email" value="{{$emailtukang}}" id="email" aria-describedby="emailHelp" required>
        <div class="invalid-feedback">
            Kolom alamat e-mail belum di isi!
        </div>
        @error('email')
        <div class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary">Ubah</button>
    <a href="/mandor/updatePass/{{$kodetukang}}" class="btn btn-warning">Ubah Kata Sandi Tukang</a>
</form>

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
                // alert($(this).val());

                var value = $(this).val();
                var _token=$('input[name="_token"]').val();
                $.ajax({
                    url:"{{route('dynamicdependent2.fetch')}}",
                    method:"POST",
                    data:{value:value,_token:_token},
                    success:function(result){
                        var res = result.substring(1);
                        res=res.substring(0,res.length - 1)
                        //alert("Res"+res);
                        $("#gaji").val(res);
                        /*$(".isi").html("");
                        $(".isi").html(result);*/
                    }
                })
            }
        });
    })
</script>
@endsection
