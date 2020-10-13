@extends('admin.navbar')

@section('content')
<h1 class="mb-3">Toko Bangunan</h1>
<div class="option col-12 text-right mb-5" style="margin-top: 0px">
    <a class="btn btn-primary"  href="/admin/lihatToko" style="width:250px"><font size="3">Lihat Toko Bangunan</font></a>
</div>

<div class="row">
    <div class="col-5">
    <form style='margin-top:50px' method="POST" action="/admin/submitToko" class="needs-validation" novalidate>
            @csrf

        <div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="false" style="width:100%;">
            <div class="carousel-inner">
                @php $i=0; @endphp
                @foreach ($listFoto as $item)
                    @if($i==0)
                        <div class="carousel-item active">
                            <img src="/assets/nota_beli/{{$item->file_bukti}}" class="d-block w-100" alt="...">
                        </div>
                    @else
                        <div class="carousel-item">
                            <img src="/assets/nota_beli/{{$item->file_bukti}}" class="d-block w-100" alt="...">
                        </div>

                    @endif
                    @php $i++; @endphp
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#carouselExampleFade" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only" style="color: black">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleFade" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
    <div class="col-7">
        <div class="form-group">
            <label for="exampleInputEmail1">Nama Toko</label>
            <input type="text" class="form-control" name="name" value="{{old('name')}}" required>
            <div class="invalid-feedback">
                Kolom nama belum di isi!
            </div>
            @error('name')
            <div class="err">
                {{$message}}
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Alamat Toko</label>
            <input type="text" class="form-control" name="alamat" value="{{old('alamat')}}" required>
            <div class="invalid-feedback">
                Kolom Alamat belum di isi!
            </div>
            @error('alamat')
            <div class="err">
                {{$message}}
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">No Telepon Toko</label>
            <input type="text" class="form-control" name="telepon" value="{{old('telepon')}}" required>
            <div class="invalid-feedback">
                Kolom No Telp belum di isi!
            </div>
            @error('telepon')
            <div class="err">
                {{$message}}
            </div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Tambah</button>
    </div>
</form>
</div>
<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
      'use strict';
      window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
          form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add('was-validated');
          }, false);
        });
      }, false);
    })();
</script>
@endsection
