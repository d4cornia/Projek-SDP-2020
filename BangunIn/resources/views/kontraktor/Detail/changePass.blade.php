@extends('kontraktor.navbar')

@section('content')
<h1>Ubah Kata Sandi</h1>
<form method="POST" action="/kontraktor/{{$path}}" class="needs-validation" novalidate>
    @csrf
    <div class="form-group">
        <label for="pass">Kata sandi lama</label>
        <input type="text" class="form-control" name="pass" value="{{$oldPass}}" id="pass">
        @error('pass')
        <div class="err">
            {{$message}}
        </div>
        @enderror
    </div>
    <div class="form-group">
        <label for="npass">Kata sandi baru</label>
        <input type="password" class="form-control" name="npass" value="" id="npass">
        @error('npass')
        <div class="err">
            {{$message}}
        </div>
        @enderror
    </div>
    <div class="form-group">
        <label for="cpass">Konfirmasi kata sandi baru</label>
        <input type="password" class="form-control" name="cpass" value="" id="cpass">
        @error('cpass')
        <div class="err">
            {{$message}}
        </div>
        @enderror
    </div>
    <input type="hidden" name="username" value="{{$username}}">
    <a href="/kontraktor/{{$bef}}/{{encrypt($kode)}}" class="btn btn-secondary">Kembali</a>
    <button type="submit" class="btn btn-primary">Ubah</button>
</form>
@endsection
