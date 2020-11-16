@extends('mandor.navbar')

@section('content')
<h1>Request Dana</h1>
<div class="col-12 text-right mt-5 mb-5">
    <a class="btn btn-primary"  href="/mandor/lihatRequestDana" style="width:250px"><font size="3">Lihat Request Dana</font></a>
</div>
<form method="POST" action="/mandor/tambahRequestDana" class="needs-validation" novalidate>
    @csrf
    <div class="form-group">
        <label for="pekerjaan">Pekerjaan</label>
        <div class="my-1">
            <select class="custom-select mr-sm-2 pekerjaan" id="inlineFormCustomSelect" name="pekerjaan" id="pekerjaan">
                <option selected>-</option>
                @foreach ($listPekerjaan as $item)
                    <option value='{{$item['kode_pekerjaan']}}'>{{$item['nama_pekerjaan']}}</option>
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
        <label for="exampleInputEmail1">Gaji Tukang</label>
        <input type="text" class="form-control" name="gaji" id="gaji" readonly required>
    </div>
    <button type="submit" class="btn btn-primary">Tambah</button><br><br>
</form>
    <div id='tablesession'>
        @if (count($listReq)>0)


        <div class="table-responsive">
            <table id="tabel-req" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Pekerjaan</th>
                    <th>Pekerjaan Khusus</th>
                    <th>Total Pekerjaan Khusus</th>
                    <th>Total Nota</th>
                    <th>Total Gaji Tukang</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="">
                    @foreach ($listReq as $item)
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            @foreach ($listPekerjaan as $pek)
                                @if ($pek->kode_pekerjaan==$item["kodepek"])
                                    <td>{{$pek->nama_pekerjaan}}</td>
                                @endif
                            @endforeach
                            <td>
                                @if ($item["pekerjaankhusus"]!=null)
                                <ul>
                                    @php
                                        $pekkhusus = $item["pekerjaankhusus"];
                                            for($i=0;$i<count($pekkhusus);$i++){
                                                foreach ($listPk as $pkkhusus) {
                                                    if($pekkhusus[$i]==$pkkhusus->kode_pk){
                                                        echo "<li>$pkkhusus->keterangan_pk</li>";
                                                    }
                                                }
                                            }
                                    @endphp
                                </ul>
                                @endif
                            </td>
                            <td>{{$item["totalpk"]}}</td>
                            <td>{{$item["totalnota"]}}</td>
                            <td>{{$item["totalgaji"]}}</td>
                            <td>{{$item["subtotal"]}}</td>
                            <td>
                                <input type='hidden' name='kodeku' value='{{$item["kodepek"]}}'>
                                <a href='/mandor/tabelReq/{{$item["kodepek"]}}'><button type='submit' class="btn btn-danger">Batal</button></a>
                            </td>
                        </tr>
                    @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>No</th>
                    <th>Pekerjaan</th>
                    <th>Pekerjaan Khusus</th>
                    <th>Total Pekerjaan Khusus</th>
                    <th>Total Nota</th>
                    <th>Total Gaji Tukang</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            </table>
        </div>


        <form method="POST" action="/mandor/simpanReqDana" class="needs-validation" novalidate>
            @csrf
            <h4>Bon Tukang</h4>
            <div class="form-group">
                <input type="text" class="form-control" name="bon" id="bon" readonly required>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Total Keseluruhan</label>
                <input type="text" class="form-control" name="totalsistem" id="totalsistem" readonly required>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Total Request</label>
                <input type="text" class="form-control" name="totalrequest" id="totalrequest" value='{{old('totalrequest')}}'  required>
                @error('totalrequest')
                <div class="err">
                    {{$message}}
                </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Keterangan</label>
            <input type="text" class="form-control" name="keterangan" value="-" id="keterangan">
            </div>
            <button type="submit" class="btn btn-success" name='btnSimpan'>Simpan</button>
        </form>
    @endif
    </div>

<script>
    $(document).ready(function() {
        $("#tabel-req").DataTable();
} );

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
        const checkboxes = document.querySelectorAll('input[name="pk[]"]:checked');
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
        var value = $(this).val();
        var _token=$('input[name="_token"]').val();
        $.ajax({
            url:"{{route('querybon')}}",
            method:"POST",
            data:{value:value,_token:_token},
            success:function(result){
                //alert("Res"+result);
                $("#bon").val(result);
            }
        });
        $.ajax({
            url:"{{route('hitungtotal')}}",
            method:"POST",
            data:{value:value,_token:_token},
            success:function(result){
                //alert("Res"+result);
                $("#totalsistem").val(result);
                $("#totalrequest").val(result);
            }
        });
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
                $.ajax({
                    url:"{{route('querygaji')}}",
                    method:"POST",
                    data:{value:value,_token:_token},
                    success:function(result){
                        $("#gaji").val(result);
                    }
                });
                //alert('masuk');
            }
        });
    })
</script>
@endsection
