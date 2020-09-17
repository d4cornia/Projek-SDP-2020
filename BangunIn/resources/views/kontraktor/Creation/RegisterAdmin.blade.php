@extends('kontraktor.navbar')

@section('content')
<h1>Tambah Admin</h1>
@isset($succ)
<div class="succ"  id="succ">
    {{$succ}}
</div>
@endisset
<form method="POST" action="/kontraktor/submitRegAdmin" class="needs-validation" novalidate>
    @csrf
    <div class="form-group">
        <label for="exampleInputEmail1">Nama Admin</label>
        <input type="text" class="form-control" name="name" value="@if(isset($bef)){{$bef['name']}}@endif{{old('name')}}" required>
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
        <label for="exampleInputEmail1">No Telepon</label>
        <input type="text" class="form-control" name="no" value="@if(isset($bef)){{$bef['no']}}@endif{{old('no')}}" required>
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
        <input type="text" class="form-control" name="username" value="@if(isset($bef)){{$bef['username']}}@endif{{old('username')}}" required>
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
        <input type="email" class="form-control" name="email" value="@if(isset($bef)){{$bef['email']}}@endif{{old('email')}}" id="email" aria-describedby="emailHelp" required>
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
        <label for="salary">Gaji Admin</label>
        <input type="number" class="form-control" name="salary" value="@if(isset($bef)){{intval($bef['salary'])}}@else{{intval(old('salary'))}}@endif" id="salary" required>
        @error('salary')
            <div class="err">
                {{$message}}
            </div>
        @enderror
    </div>
    <div class="form-group">
        <label for="pass">Kata sandi</label>
        <input type="password" class="form-control" name="pass" value="@if(isset($bef)){{$bef['pass']}}@endif{{old('pass')}}" id="pass" required>
        <div class="invalid-feedback">
            Kolom kata sandi belum di isi!
        </div>
        @error('pass')
        <div class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
    </div>
    <div class="form-group">
        <label for="cpass">Konfirmasi kata sandi</label>
        <input type="password" class="form-control" name="cpass" value="" id="cpass" required>
        <div class="invalid-feedback">
            Kolom konfirmasi kata sandi belum di isi!
        </div>
        @error('cpass')
        <div class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary">Tambah</button>
    <a class="btn btn-secondary" href="/kontraktor/lAdmin">Kembali</a>
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
