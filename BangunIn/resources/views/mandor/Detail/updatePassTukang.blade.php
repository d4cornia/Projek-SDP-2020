@extends('mandor.navbar')

@section('content')
<h1>Ubah Kata Sandi</h1><br>
<form method="POST" action="/mandor/storeGantiPass" class="needs-validation" novalidate>
    @csrf
    <input type='hidden' value='{{$kodetukang}}' name="kodetukang">
    <div class="form-group">
        <label for="pass">Kata sandi lama</label>
        <input type="password" class="form-control" name="passlama" value="{{old('passlama')}}" id="passlama">
        <div class="invalid-feedback">
            Kolom Password Lama belum di isi!
        </div>
        @error('passlama')
        <div class="err">
            {{$message}}
        </div>
        @enderror
    </div>
    <div class="form-group">
        <label for="npass">Kata sandi baru</label>
        <input type="password" class="form-control" name="passbaru" value="{{old('passbaru')}}" id="passbaru">
        <div class="invalid-feedback">
            Kolom Kata Sandi Baru belum di isi!
        </div>
        @error('passbaru')
        <div class="err">
            {{$message}}
        </div>
        @enderror
    </div>
    <div class="form-group">
        <label for="cpass">Konfirmasi kata sandi baru</label>
        <input type="password" class="form-control" name="cpassbaru" value="{{old('cpassbaru')}}" id="cpassbaru">
        <div class="invalid-feedback">
            Kolom Konfirmasi Kata Sandi Baru belum di isi!
        </div>
        @error('cpassbaru')
        <div class="err">
            {{$message}}
        </div>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary">Ubah</button>
</form>
@endsection
