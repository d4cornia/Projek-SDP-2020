@extends('kontraktor.navbar')

@section('content')
<form method="POST" action="/kontraktor/submitAddWork" class="needs-validation" novalidate>
    @csrf
    <div class="form-group">
        <label for="name">Nama Perkejaan</label>
        <input type="text" class="form-control" name="name" id="name" value="{{old('name')}}" required>
        <div class="invalid-feedback">
            Kolom nama perkejaan belum di isi!
        </div>
        @error('name')
        <div class="err">
            {{$message}}
        </div>
        @enderror
    </div>
    <div class="form-group">
        <label for="nc">Nama Client</label>
        <div class="my-1">
            <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="nc" id="nc">
                <option selected>-</option>
                @foreach ($listClient as $item)
                    <option value="{{$item}}">{{$item}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="nm">Nama Mandor</label>
        <div class="my-1">
            <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="nm" id="nm">
                <option selected>-</option>
                @foreach ($listMandor as $item)
                    <option value="{{$item['username_mandor']}}">{{$item['nama_mandor'].' - '.item['username_mandor']}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="na">Nama Admin</label>
        <div class="my-1">
            <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="na" id="na">
                <option selected>-</option>
                @foreach ($listAdmin as $item)
                    <option value="{{$item['username_admin']}}">{{$item['nama_admin'].' - '.item['username_admin']}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="address">Alamat</label>
        <input type="text" class="form-control" name="address" id="address" value="{{old('address')}}" required>
        <div class="invalid-feedback">
            Kolom alamat belum di isi!
        </div>
        @error('address')
        <div class="err">
            {{$message}}
        </div>
        @enderror
    </div>
    <div class="form-group">
        <label for="specAgreement">Perjanjian Khusus</label>
        <textarea class="form-control" name="specAgreement" id="specAgreement" value="{{old('specAgreement')}}" rows="8"></textarea>
    </div>
    <div class="form-group">
        <label for="inlineRadio1" class="">Jenis Pekerjaan</label>
        <span class="col-6">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="type" id="inlineRadio1" value="0" checked>
                <label class="form-check-label" for="inlineRadio1">Harga Fix Di Depan</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="type" id="inlineRadio2" value="1">
                <label class="form-check-label" for="inlineRadio2">Komisi</label>
            </div>
        </span>
    </div>
    <div class="form-group">
        <label for="dealPrice">Harga Deal</label>
        <input type="number" class="form-control" name="dealPrice" id="dealPrice" value="{{old('dealPrice')}}" id="pass" required>
        <div class="invalid-feedback">
            Kolom Harga Deal harus berisi Angka (0-9)!
        </div>
        @error('dealPrice')
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
