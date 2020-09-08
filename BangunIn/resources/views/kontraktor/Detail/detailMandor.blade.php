@extends('kontraktor.navbar')

@section('content')
<form method="POST" action="/kontraktor/updMandor" class="needs-validation" novalidate>
    @csrf
    <div class="form-group">
        <label for="exampleInputEmail1">Nama Mandor</label>
        <input type="text" class="form-control" name="name" value="{{$mandor[0]['nama_mandor']}}">
        @error('name')
        <div class="err">
            {{$message}}
        </div>
        @enderror
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">No Telepon</label>
        <input type="text" class="form-control" name="no" value="{{$mandor[0]['no_hp_mandor']}}">
        <div class="invalid-feedback">
        </div>
        @error('no')
        <div class="err">
            {{$message}}
        </div>
        @enderror
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Nama Pengguna</label>
        <input type="text" class="form-control" name="username" value="{{$mandor[0]['username_mandor']}}">
        @error('username')
        <div class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Alamat E-mail</label>
        <input type="email" class="form-control" name="email" value="{{$mandor[0]['email_mandor']}}" id="email" aria-describedby="emailHelp">
        @error('email')
        <div class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
    </div>
    <div class="form-group">
        <label for="salary">Gaji Mandor</label>
        <input type="number" class="form-control" name="salary" value="{{$mandor[0]['salary']}}" id="salary">
        @error('salary')
            <div class="err">
                {{$message}}
            </div>
        @enderror
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Kata sandi</label>
        <input type="password" class="form-control" name="pass" value="{{$mandor[0]['password_mandor']}}" id="pass">
        @error('pass')
        <div class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
    </div>
    <input type="hidden" name="id" value="{{$mandor[0]['kode_mandor']}}">
    <button type="submit" class="btn btn-primary">Ubah</button>
</form>
@endsection
