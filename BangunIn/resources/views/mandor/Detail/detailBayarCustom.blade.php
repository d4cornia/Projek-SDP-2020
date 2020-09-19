@extends('mandor.navbar')

@section('content')
<h1>Lihat Pembayaran Bon</h1>
<h3>Mandor : {{$mandor}}</h3>
<h4>Tanggal Pembayaran :
    @php
        $tahun = substr($tgl,0,4);
        $bulan = substr($tgl,5,2);
        $tanggal = substr($tgl,8);
        echo $tanggal."-".$bulan."-".$tahun;
        //echo $tgl;
        $total=0;
    @endphp
</h4>
@foreach ($listBayar as $item)
    @foreach ($detBayar as $item2)
        @if ($item->kode_pembayaran_bon==$item2->kode_pembayaran_bon)
            @php
                $total+=$item2->jumlah_pembayaran_bon;
            @endphp
        @endif
    @endforeach
@endforeach
<h4>Penerimaan Pembayaran Bon : Rp
    @php
        echo number_format($total);
    @endphp
</h4>



<script>
    $(document).ready(function() {
        $("#tabel-bayar").DataTable();
} );
</script>
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
    $(document).ready(function(){
       //alert("hai");
        $('.dynamic').change(function(){
            //alert('masuk');

            if($(this).val()!=''){
                // alert($(this).val());

                var value = $(this).val();
                var _token=$('input[name="_token"]').val();
                $.ajax({
                    url:"{{route('dynamicdependent.fetch')}}",
                    method:"POST",
                    data:{value:value,_token:_token},
                    success:function(result){
                        //alert("Res"+result);
                        $(".isi").html("");
                        $(".isi").html(result);
                    }
                })
            }
        });
    })
</script>
@endsection
