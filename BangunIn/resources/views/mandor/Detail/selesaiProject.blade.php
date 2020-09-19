@extends('mandor.navbar');

@section('content')
    <form action="/" method="post" enctype="multipart/form-data">
        <div class="input-group">
            <div class="custom-file">
              <input type="file" onchange="mylist()" id="gambar" class="custom-file-input" id="inputGroupFile04" multiple accept="png|jpg">
              <label class="custom-file-label" for="inputGroupFile04">Choose file</label>
            </div>
            <div class="input-group-append">
              <button class="btn btn-outline-secondary" type="button">Clear</button>
            </div>
        </div>
    </form>
    <script>
        function mylist(){
            for (var i = 0; i < $('#gambar').length; i++)
            {
                alert(this.files[i].name);
            }
        }
    </script>
@endsection
