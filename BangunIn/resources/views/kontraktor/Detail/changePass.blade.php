@extends('kontraktor.navbar')

@section('content')
<h1>Ubah Kata Sandi</h1>
<form method="POST" action="/kontraktor/{{$path}}" class="needs-validation" novalidate>
    @csrf
    <div class="form-group">
        <label for="pass">Kata sandi lama</label>
        <input type="text" class="form-control" name="pass" value="{{$oldPass}}" id="pass">
        @error('pass')
        <div class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
    </div>
    <div class="form-group">
        <label for="npass">Kata sandi baru</label>
        <input type="text" class="form-control" name="npass" value="" id="npass">
        @error('npass')
        <div class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
    </div>
    <div class="form-group">
        <label for="cpass">Konfirmasi kata sandi baru</label>
        <input type="text" class="form-control" name="cpass" value="" id="cpass">
        @error('cpass')
        <div class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
    </div>
    <input type="hidden" name="username" value="{{$username}}">
    <button type="submit" class="btn btn-primary">Ubah</button>
</form>
@endsection
