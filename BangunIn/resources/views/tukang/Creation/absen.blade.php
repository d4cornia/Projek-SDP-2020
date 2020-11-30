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
            <div class="row">
                <div class="col-lg-6 col-sm-12">
                    <h4>Camera</h4>
                    <div id="my_camera" style="width: 100%"></div>
                    <br/>
                    <input type=button value="Take Snapshot" onClick="take_snapshot()">
                    <input type="hidden" name="image" class="image-tag">
                </div>
                <div class="col-lg-6 col-sm-12">
                    <div class="w-100">
                        <h4>Your captured image will appear here...</h4>
                        <div id="results" class="imgprev" style="width: 100%;"></div>
                    </div>
                    <input type="hidden" name="hasilfoto" id="hasilfoto">
                </div>
                <div class="col-md-12 text-center">
                    <br/>
                </div>
            </div>
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

    Webcam.set({
        width: 490,
        height: 390,
        image_format: 'jpeg',
        jpeg_quality: 90
    });

    Webcam.attach( '#my_camera' );

    function take_snapshot() {
        Webcam.snap( function(data_uri) {
            $(".image-tag").val(data_uri);
            $("#hasilfoto").val(data_uri);

            document.getElementById('results').innerHTML = '<img  class="imgprev" src="'+data_uri+'"/>';
        } );
    }
</script>
@else
<h2>Absen ditutup! {{$msg}}</h2>
@endif
@endsection
