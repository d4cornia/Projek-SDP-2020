@extends('mandor.navbar')

@section('content')
<form method="POST" action="/mandor/updateJenisTukang" class="needs-validation" novalidate>
    @csrf
    <input type='hidden' name='kodejenis' value={{$kodejenis}}>
    <div class="form-group">
        <label for="exampleInputEmail1">Nama Jenis</label>
        <input type="text" class="form-control" name="name" value="{{$nama}}" required>
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
        <input type="text" class="form-control" name="gaji" value="{{$gaji}}" required>
        <div class="invalid-feedback">
            Kolom gaji pokok belum di isi!
        </div>
        @error('gaji')
        <div class="err">
            {{$message}}
        </div>
        @enderror
    </div>
    <a class="btn btn-secondary" href="/mandor/lihatJenisTukang">Batal</a>
    <button type="submit" class="btn btn-primary">Ubah</button>
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
