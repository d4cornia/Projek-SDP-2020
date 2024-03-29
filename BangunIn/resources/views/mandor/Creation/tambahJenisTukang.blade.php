@extends('mandor.navbar')

@section('content')
<h1>Jenis Tukang</h1>
<hr>
<div class="option" style="margin-left:78%">
    <a class="btn btn-primary"  href="/mandor/lihatJenisTukang" style="width:250px"><font size="3">Lihat Jenis Tukang</font></a>
</div>
<form method="POST" action="/mandor/submitRegJenisTukang" class="needs-validation" novalidate>
    @csrf
    <div class="form-group">
        <label for="exampleInputEmail1">Nama Jenis</label>
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
        <label for="exampleInputEmail1">Gaji Pokok</label>
        <input type="text" class="form-control" name="gaji" value="{{old('gaji')}}" required>
        <div class="invalid-feedback">
            Kolom gaji pokok belum di isi!
        </div>
        @error('gaji')
        <div class="err">
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
