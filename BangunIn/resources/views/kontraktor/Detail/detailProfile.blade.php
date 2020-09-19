@extends('kontraktor.navbar')
@section('content')
<form action="/kontraktor/updProfilePerusahaan" class="form-horizontal" method="post" enctype="multipart/form-data">
    @csrf
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputEmail3" class="col-sm-12 col-form-label">Nama Perushaan</label>
                <div class="col-sm-12">
                <input type="text" class="form-control" id="nama" placeholder="Nama Perusahaaan" name="nmperusahaan"  value="{{$nama}}" required>
                </div>
            </div>
            <div class="form-group col-md-6">
                <label for="inputPassword3" class="col-sm-12 col-form-label">Nomer Telephone Perushaan</label>
                <div class="col-sm-12">
                <input type="text" class="form-control" id="nomer" pattern="[0-9]{10,}" title="Nomer Telp Harus Angka" placeholder="Nomer Telephone Perusahaan" name="noperusahaan" value="{{$nomer}}"  required>
                </div>
            </div>
        </div>
        <div class="form-group row" style="margin-bottom:5px">
            <div class="form-group col-md-12">
                <label for="inputPassword3" class="col-sm-12 col-form-label">Alamat Perusahaan</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" id="email" placeholder="Alamat Perusahaan" name="alperusahaan" value="{{$alamat}}"  required>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="form-group col-md-12">
                <label for="inputPassword3" class="col-sm-12 col-form-label">Logo Perusahaan</label>
                    <div class="custom-file">
                        <div class="col-12">
                            <input type="file" class="custom-file-input" id="inputGroupFile04" name="logo" aria-describedby="inputGroupFileAddon04">
                            <label class="custom-file-label" for="inputGroupFile04" >Choose file</label>
                            <small>Kalau Tidak ingin mengganti logo kosongkan aja</small>
                        </div>
                    </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-12 p-4">
                <input type="submit" class="col-sm-12 btn btn-info" style="margin: auto;" name="btnRegister" value="Simpan Profile Perusahaan">
            </div>
        </div>
</form>
@endsection
<script>
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
</script>
