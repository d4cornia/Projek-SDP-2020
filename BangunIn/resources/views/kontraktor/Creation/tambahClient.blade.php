@extends('kontraktor.navbar')

@section('content')
<h1>Tambah Client</h1>
<hr>
<div class="tombol" style="float:right">
    <a class="btn btn-info" href="/kontraktor/lihatClient">Lihat Client</a>
</div>
<br><br>
<form method="POST" action="/kontraktor/submitRegClient" class="needs-validation" novalidate>
    @csrf
    <div class="form-group">
        <label for="exampleInputEmail1">Nama Client</label>
        <input type="text" class="form-control" name="nameClient" value="" required>
        <div class="invalid-feedback">
            Kolom nama belum di isi!
        </div>
        @error('nameClient')
        <div class="err">
            {{$message}}
        </div>
        @enderror
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">No Telepon</label>
        <input type="text" class="form-control" name="handphoneNumber" value="" required>
        <div class="invalid-feedback">
            Kolom nomor telepon belum di isi!
        </div>
        @error('handphoneNumber')
        <div class="err">
            {{$message}}
        </div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Tambah</button>
</form>
@endsection
