@extends('mandor.navbar')

@section('content')
<form method="POST" action="/mandor/submitRegTukang" class="needs-validation" novalidate>
    @csrf
    <div class="form-group">
        <label for="exampleInputEmail1">Nama Tukang</label>
        <input type="text" class="form-control" name="name" value="{{old('name')}}" required>
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
            <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="jenis" id="jenis">
                <option selected>-</option>
                @foreach ($listJenis as $item)
                    <option value="{{$item['nama_jenis']}}">{{$item['nama_jenis']}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Gaji Tukang</label>
        <input type="text" class="form-control" name="gaji" value="{{old('gaji')}}" required>
        <div class="invalid-feedback">
            Kolom gaji tukang belum di isi!
        </div>
        @error('gaji')
        <div class="err">
            {{$message}}
        </div>
        @enderror
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">No Telepon</label>
        <input type="text" class="form-control" name="no" value="{{old('no')}}" required>
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
        <input type="text" class="form-control" name="username" value="{{old('username')}}" required>
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
        <input type="email" class="form-control" name="email" value="{{old('email')}}" id="email" aria-describedby="emailHelp" required>
        <div class="invalid-feedback">
            Kolom alamat e-mail belum di isi!
        </div>
        @error('email')
        <div class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Kata sandi</label>
        <input type="password" class="form-control" name="pass" value="{{old('pass')}}" id="pass" required>
        <div class="invalid-feedback">
            Kolom kata sandi belum di isi!
        </div>
        @error('pass')
        <div class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary">Tambah</button>
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
@endsection
