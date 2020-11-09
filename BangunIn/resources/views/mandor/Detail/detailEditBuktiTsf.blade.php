@extends('mandor.navbar')

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
<form method="POST" action="/mandor/confirmEditBukti" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <div class="preview">
            <img id="blah" src="/assets/bukti_dana_pk/{{$pk_dana->bukti_tsf_dana}}" alt="" class="imgprev"/>
        </div>
        <input type='file' name="buktiBaru"  onchange="readURL(this);" />
    </div>

    <div class="form-group">
        <a class="btn btn-secondary" href="/mandor/backToEditSpWork">Kembali</a>
        <input type="submit" value="Ubah" class="btn btn-info">
    </div>
    <input type="hidden" name="kode_pk_dana" value={{$pk_dana->kode_pk_dana}}>
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
@endsection
