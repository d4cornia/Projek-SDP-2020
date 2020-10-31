@extends('mandor.navbar')

@section('content')
<h1>Request Dana</h1>
<div class="option" style="margin-left:78%">
    <a class="btn btn-primary"  href="/mandor/lihatJenisTukang" style="width:250px"><font size="3">Lihat Request Dana</font></a>
</div>
<form method="POST" action="/mandor/submitRegJenisTukang" class="needs-validation" novalidate>
    @csrf
    <div class="form-group">
        <label for="pekerjaan">Pekerjaan</label>
        <div class="my-1">
            <select class="custom-select mr-sm-2 pekerjaan" id="inlineFormCustomSelect" name="pekerjaan" id="pekerjaan">
                <option selected>-</option>
                @foreach ($listPekerjaan as $item)
                    <option value="{{$item['kode_pekerjaan']}}">{{$item['nama_pekerjaan']}}</option>
                @endforeach
            </select>
        </div>
    </div>
    {{ csrf_field() }}
    <div class="form-group">
        <label for="exampleInputEmail1">Pekerjaan Khusus</label>
        <div class="my-1 mypk" id='mypk'>
        </div>
    </div>
    <div class="form-group">
        <input type="text" class="form-control" name="pkh" id="pkh" readonly required>
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Claim Nota Pembelian</label>
        <input type="text" class="form-control" name="nota" id="nota" readonly required>
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Request Bon Tukang</label>
        <input type="text" class="form-control" name="bon" id="bon" readonly required>
    </div>

    <button type="submit" class="btn btn-primary">Tambah</button>
</form>


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
<script>
    function ganti(){
        //alert('oi');
        var _token=$('input[name="_token"]').val();
        const checkboxes = document.querySelectorAll('input[name="pk"]:checked');
        let values = [];
        checkboxes.forEach((checkbox) => {
            values.push(checkbox.value);
        });
        //alert(values);
        //return values;
                //
        $.ajax({
            url:"{{route('hitungpk')}}",
            method:"POST",
            data:{_token:_token,pktake:values},
            success:function(result){
                //alert("Res"+result);
                $("#pkh").val(result);
            }
        });

    }
    $(document).ready(function(){
       //alert("hai");

        $('.pekerjaan').change(function(){
            //alert('masuk');

            if($(this).val()!=''){
                //alert($(this).val());

                var value = $(this).val();
                var _token=$('input[name="_token"]').val();
                $.ajax({
                    url:"{{route('querypkall')}}",
                    method:"POST",
                    data:{value:value,_token:_token},
                    success:function(result){
                        //alert("Res"+result);
                        $("#mypk").html(result);
                    }
                });
                $.ajax({
                    url:"{{route('queryjumpkall')}}",
                    method:"POST",
                    data:{value:value,_token:_token},
                    success:function(result){
                        //alert("Res"+result);
                        $("#pkh").val(result);
                    }
                });
                $.ajax({
                    url:"{{route('querynota')}}",
                    method:"POST",
                    data:{value:value,_token:_token},
                    success:function(result){
                        //alert("Res"+result);
                        $("#nota").val(result);
                    }
                });
                //alert('masuk');
                $.ajax({
                    url:"{{route('querybon')}}",
                    method:"POST",
                    data:{value:value,_token:_token},
                    success:function(result){
                        //alert("Res"+result);
                        $("#bon").val(result);
                    }
                });
            }
        });
    })
</script>
@endsection
