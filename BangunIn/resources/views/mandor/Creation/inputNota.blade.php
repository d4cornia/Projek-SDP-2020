@extends('mandor.navbar')

@section('content')
<h1>Input Nota Pembelian Bahan</h1>
<div class="option" style="margin-left:91%">
    <a class="btn btn-primary"  href="/mandor/lihatBon">Lihat Bon</a>
</div>
<form method="POST" action="/mandor/submitRegBon" class="needs-validation" novalidate>
    @csrf
    <div class="form-group">
        <label for="nm">Pekerjaan</label>
        <div class="my-1">
            <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="nm" id="nm">
                @foreach ($listPekerjaan as $item)
                    <option value="{{$item->kode_pekerjaan}}">{{$item->nama_pekerjaan}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="nm">File Bukti</label><br>
        <input type="file" name="" id="">
    </div>
    <button type="submit" class="btn btn-primary">Tambah</button>
</form>

{{-- <script>
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
</script> --}}
@endsection
