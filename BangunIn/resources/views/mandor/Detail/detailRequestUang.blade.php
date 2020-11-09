@extends('mandor.navbar')

@section('content')
    <h1>Detail Request Dana</h1>
    <br>
    @if ($header->konfirmasi_kontraktor_telah_transfer==1)
        <img style='width:200px;height:200px;' src="/assets/buktikontraktor/{{$header->bukti_trf_req}}">
    @endif
    <h3>Nama : {{$nama}}</h3>
    <h4 style='color:red;'>Bon : Rp {{number_format($sisa)}}</h4>
    <h3>Tanggal : {{$header->tanggal_permintaan_uang}}</h3>
    <h5>Total dari Pekerjaan : Rp {{number_format($header->total_detail)}}</h5>
    <h5>Jumlah Bon Minggu Ini: Rp {{number_format($header->total_bon)}}</h5>
    <h3>Jumlah Keseluruhan : Rp {{number_format($header->total_sistem)}}</h3>
    <h3>Jumlah Request : Rp {{number_format($header->real_total)}}</h3>
    <h3>Keterangan : {{$header->keterangan}}</h3>
    <hr>
    <table border='1'>
        <tr>
            <th>Pekerjaan</th>
            <th>Pekerjaan Khusus</th>
            <th>Total Nota</th>
            <th>Total Gaji Tukang</th>
            <th>Total Pekerjaan Khusus</th>
            <th>Subtotal</th>
        </tr>
    @foreach ($detail as $item)
        <tr>
        @php
            $p="";
            foreach($pekerjaan as $pek){
                if($pek->kode_pekerjaan==$item->kode_pekerjaan){
                    $p=$pek->nama_pekerjaan;
                }
            }
            echo "<td>".$p."</td>";
        @endphp
        <td>
            @php
                $listPK = $pekerjaan_khusus->where('id_detail_permintaan_uang',$item->id_detail_permintaan_uang)->where('kode_pekerjaan',$item->kode_pekerjaan);
                if($listPK!=null){
                    echo "<ul>";
                        foreach ($listPK as $items) {
                            echo "<li>".$items->keterangan_pk."</li>";
                        }
                    echo "</ul>";
                }
                else{
                    echo "-";
                }
            @endphp
        </td>
        <td style='text-align:right;'>Rp {{number_format($item->claim_nota_pembelian)}}</td>
        <td style='text-align:right;'>Rp {{number_format($item->total_gaji_tukang)}}</td>
        <td style='text-align:right;'>Rp {{number_format($item->total_pk)}}</td>
        <td style='text-align:right;'>Rp {{number_format($item->subtotal)}}</td>
        </tr>
    @endforeach
    </table>
    <br>
    <a class="btn btn-secondary" href="/mandor/lihatRequestDana">Kembali</a>

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
