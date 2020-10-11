@extends('admin.navbar')

@section('content')
<h1>Edit Data Toko Bangunan</h1><br>
<form method="POST" action="/admin/storeEditToko" class="needs-validation" novalidate>
    @csrf
    <input type='hidden' value='{{$kode}}' name="idkerjasama">

    <div class="form-group">
        <label for="exampleInputEmail1">Nama Toko</label>
        <input type="text" class="form-control" name="name" value="{{$nama}}" required disabled='disabled'>
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
        <label for="npass">Alamat Toko</label>
        <input type="text" class="form-control" name="alamat" value="{{$alamat}}" id="alamat" disabled='disabled'>
        <div class="invalid-feedback">
            Kolom Alamat Toko belum di isi!
        </div>
        @error('alamat')
        <div class="err">
            {{$message}}
        </div>
        @enderror
    </div>
    <div class="form-group">
        <label for="npass">No Telp Toko</label>
        <input type="text" class="form-control" name="telepon" value="{{$notelp}}" id="telepon">
        <div class="invalid-feedback">
            Kolom Telepon Toko belum di isi!
        </div>
        @error('telepon')
        <div class="err">
            {{$message}}
        </div>
        @enderror
    </div>
    <a class="btn btn-secondary" href="/admin/lihatToko">Batal</a>
    <button type="submit" class="btn btn-primary">Ubah</button>
</form>
@endsection
