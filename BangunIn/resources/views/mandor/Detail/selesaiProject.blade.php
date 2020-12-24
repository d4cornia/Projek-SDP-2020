@extends('mandor.navbar')

@section('content')

    <form action="/mandor/finishWork" method="post" enctype="multipart/form-data">
        @csrf
        <h6>Upload Bukti Project Selesai</h6>
        <input type="file" name="bukti[]" multiple><br>
        <small>Dalam proses upload bisa memilih lebih dari 1 foto</small><br><br>
    <input type="hidden" name="id" value="{{$id}}">
        <input class="btn btn-warning" type="submit" value="Selesain Project">
    </form>
@endsection
