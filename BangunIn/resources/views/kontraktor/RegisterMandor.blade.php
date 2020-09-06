@extends('kontraktor.navbar')

@section('content')
<form method="POST" action="/submitRegMandor">
    @csrf
    <div class="form-group">
        <label for="exampleInputEmail1">Nama Mandor</label>
        <input type="text" class="form-control" name="name" required>
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">No HP</label>
        <input type="text" class="form-control" name="no" required>
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Nama Pengguna</label>
        <input type="text" class="form-control" name="username" required>
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Alamat E-mail</label>
        <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" required>
        <small id="emailHelp" class="form-text text-muted">Masukan Email utama anda</small>
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Kata sandi</label>
        <input type="password" class="form-control" name="pass" id="pass" required>
    </div>
    <button type="submit" class="btn btn-primary">Add</button>
</form>
@endsection

