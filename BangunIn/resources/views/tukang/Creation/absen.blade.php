@extends('tukang.navbar')

@section('content')
<style>
    .preview{
        width: 800px;
        height: 650px;
        margin-top: 40px;
        margin-bottom: 40px;
    }

    .imgprev{
        width: 100%;
        height: 100%;
        background-attachment: fixed;
        background-size: cover;
        border: 0px;
    }

</style>

<h1>Absen</h1>
<hr>
@if ($buka)
<form  method="POST" action="/tukang/upload" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <div class="preview">
            <img id="blah" src="/assets/default_tukang.png" alt="" class="imgprev"/>
        </div>
    </div>

    <div class="form-group">
        <input type='file' name='bukti' onchange="readURL(this);"/>
        @error('bukti')
        <div class="err">
            {{$message}}
        </div>
        @enderror
    </div>
    <div class="form-group">
        <input type="submit" value="Upload" class="btn btn-info">
    </div>
    <input type="hidden" name="kode_tukang" value="{{encrypt($kode)}}">
</form>

<script>
  function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah')
                    .attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@else
<h2>Absen ditutup! {{$msg}}</h2>
@endif
@endsection
