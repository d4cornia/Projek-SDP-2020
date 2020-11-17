@extends('mandor.navbar')

@section('content')
<h1>Tambah Bon</h1>
<div class="col-12 text-right">
    <a class="btn btn-primary"  href="/mandor/lihatBon">Lihat Bon</a>
</div>
<form method="POST" action="/mandor/submitRegBon" class="needs-validation" novalidate>
    @csrf
    <div class="form-group">
        <label for="nm">Nama Tukang</label>
        <div class="my-1">
            <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="nm" id="nm">
                <option selected>-</option>
                @foreach ($listTukang as $item)
                    @foreach ($listJenis as $item2)
                        @if ($item->kode_jenis==$item2->kode_jenis)
                            <option value="{{$item['username_tukang']}}">{{$item['nama_tukang']}}-{{$item2['nama_jenis']}}</option>
                        @endif
                    @endforeach
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Tanggal Pengajuan Bon</label>
        <input type="date" class="form-control" name="tanggal" value="{{old('tanggal')}}" required>
        <div class="invalid-feedback">
            Kolom Tanggal Pengajuan Bon belum di isi!
        </div>
        @error('tanggal')
        <div class="err">
            {{$message}}
        </div>
        @enderror
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Jumlah Bon</label>
        <input type="text" class="form-control" name="jumlah" value="{{old('jumlah')}}" required>
        <div class="invalid-feedback">
            Kolom Jumlah Bon belum di isi!
        </div>
        @error('jumlah')
        <div class="err">
            {{$message}}
        </div>
        @enderror
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Keterangan Bon</label>
        <input type="text" class="form-control" name="keteranganbon" value="{{old('keteranganbon')}}" required>
        <div class="invalid-feedback">
            Kolom Keterangan Bon belum di isi!
        </div>
        @error('keteranganbon')
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
