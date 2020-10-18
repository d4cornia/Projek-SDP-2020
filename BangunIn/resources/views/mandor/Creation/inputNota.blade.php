@extends('mandor.navbar')

@section('content')
<h1>Input Nota Pembelian Bahan</h1>
<div class="option" style="margin-left:91%">
    <a class="btn btn-primary"  href="/mandor/listNota">Lihat Nota Pembelian</a>
</div>
<form method="POST" action="/mandor/submitNotaPembelian" class="needs-validation" novalidate enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="work">Pekerjaan</label>
        <div class="my-1">
            <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="work" id="work">
                <option value="-" selected>-</option>
                @foreach ($listPekerjaan as $item)
                    <option value="{{$item->kode_pekerjaan}}">{{$item->nama_pekerjaan}}</option>
                @endforeach
            </select>
            @error('work')
            <div class="err">
                {{$message}}
            </div>
            @enderror
        </div>
    </div>
    <div class="form-group">
        <label for="bukti">File Bukti</label><br>
        <input type="file" name="bukti[]" id="bukti" multiple>
        @error('bukti')
        <div class="err">
            {{$message}}
        </div>
        @enderror

        @error('bukti.*')
        <div class="err">
            {{$message}}
        </div>
        @enderror
    </div>
    <button type="submit" class="btn btn-success">Tambah</button>
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
