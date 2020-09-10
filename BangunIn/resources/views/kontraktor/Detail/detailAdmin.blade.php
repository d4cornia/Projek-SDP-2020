@extends('kontraktor.navbar')

@section('content')
<form method="POST" action="/kontraktor/updAdmin" class="needs-validation" novalidate>
    @csrf
    <div class="form-group">
        <label for="exampleInputEmail1">Nama Admin</label>
        <input type="text" class="form-control" name="name" value="{{$admin[0]['nama_admin']}}">
        @error('name')
        <div class="err">
            {{$message}}
        </div>
        @enderror
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">No Telepon</label>
        <input type="text" class="form-control" name="no" value="{{$admin[0]['no_hp_admin']}}">
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
        <input type="text" class="form-control" name="username" value="{{$admin[0]['username_admin']}}">
        @error('username')
        <div class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Alamat E-mail</label>
        <input type="email" class="form-control" name="email" value="{{$admin[0]['email_admin']}}" id="email" aria-describedby="emailHelp">
        @error('email')
        <div class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
    </div>
    <div class="form-group">
        <label for="salary">Gaji Admin</label>
        <input type="number" class="form-control" name="salary" value="{{$admin[0]['salary']}}" id="salary">
        @error('salary')
            <div class="err">
                {{$message}}
            </div>
        @enderror
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Kata sandi</label>
        <input type="password" class="form-control" name="pass" value="{{$admin[0]['password_admin']}}" id="pass">
        @error('pass')
        <div class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
    </div>
    <input type="hidden" name="id" value="{{$admin[0]['kode_admin']}}">
    <button type="submit" class="btn btn-primary">Ubah</button>
</form>
@endsection