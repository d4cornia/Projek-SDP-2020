@extends('mandor.navbar');

@section('content')
    <form action="/mandor/finishWork" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" name="bukti[]" multiple>
    <input type="hidden" name="id" value="{{$id}}">
        <input class="btn btn-warning" type="submit" value="Selesain Project">
    </form>

@endsection
