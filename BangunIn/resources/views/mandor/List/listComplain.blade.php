@extends('mandor.navbar')

@section('content')
<style>
    img {
      border: 1px solid #ddd; /* Gray border */
      border-radius: 4px;  /* Rounded border */
      padding: 5px; /* Some padding */
      width: 120px; /* Set a small width */
      height: 100px;
    }

    /* Add a hover effect (blue shadow) */
    img:hover {
      box-shadow: 0 0 2px 1px rgba(0, 140, 186, 0.5);
    }
</style>

<h1>Komplain Absen Tukang</h1>
<hr>
<div class="table-responsive">
    <table id="tabel-history" class="table table-bordered table-striped">
      <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">Tanggal</th>
            <th scope="col">Status</th>
            <th scope="col">Bukti</th>
            <th scope="col">Aksi</th>
        </tr>
      </thead>
      <tbody id="">
        @if ($listComp !== null)
            @foreach ($listComp as $item)
                    <tr>
                        <th scope="row">{{$loop->iteration}}</th>
                        <td>{{$item->tanggal_absen}}</td>
                        <td>
                            @if ($item->konfirmasi_absen == '1')
                                Disetujui Mandor!
                            @else
                                @if ($item->konfirmasi_absen == '2')
                                    Tidak disetujui Mandor!
                                @else
                                    @if ($item->konfirmasi_absen == '3')
                                        Tidak Absen!
                                    @else
                                        Belum disetujui Mandor!
                                    @endif
                                @endif
                            @endif
                        </td>
                        @if ($item->bukti_foto_absen == '-')
                            <td>-</td>
                        @else
                        <td><a target="_blank" href="/assets/absen_tukang/{{$item->bukti_foto_absen}}" alt="/assets/default_tukang.png">
                            <img src="/assets/absen_tukang/{{$item->bukti_foto_absen}}"  alt="/assets/default_tukang.png">
                          </a></td>
                        @endif
                        <td>
                            <a class="btn btn-success" href="/mandor/accComp/{{$item->kode_absen}}">Setuju</a>
                            <a class="btn btn-danger" href="/mandor/decComp/{{$item->kode_absen}}">Tidak Setuju</a>
                        </td>
                    </tr>
            @endforeach
        @endif
      </tbody>
      <tfoot>
        <tr>
            <th scope="col">No</th>
            <th scope="col">Tanggal</th>
            <th scope="col">Status</th>
            <th scope="col">Bukti</th>
            <th scope="col">Aksi</th>
        </tr>
      </tfoot>
    </table>
</div>


<script>
    $(document).ready(function() {
        $("#tabel-history").DataTable();
} );
</script>
@endsection
