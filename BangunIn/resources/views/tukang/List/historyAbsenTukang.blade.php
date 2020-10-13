@extends('tukang.navbar')

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
@isset($succ)
<div class="succ"  id="succ">
    {{$succ}}
</div>
@endisset
    <h1>Riwayat Absen</h1>
    <hr>
        @if ($buka)
            <div class="option" style="float: right; margin:5px 0px 40px 0px;">
                <a class="btn btn-primary" href="/tukang/absen">Absen hari ini</a>
            </div>
        @endif
        <div class="table-responsive">
            <table id="tabel-history" class="table table-bordered table-striped">
              <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Status</th>
                    <th scope="col">Bukti</th>
                </tr>
              </thead>
              <tbody id="">
                  @if ($listHistory !== null)
                    @foreach ($listHistory as $item)
                            <tr>
                                <th scope="row">{{$loop->iteration}}</th>
                                <td>{{$item->tanggal_absen}}</td>
                                <td>@if ($item->konfirmasi_absen == '1')
                                        Disetujui Mandor!
                                    @else
                                        Belum disetujui Mandor!
                                @endif</td>
                                <td><a target="_blank" href="/assets/absen_tukang/{{$item->bukti_foto_absen}}" alt="/assets/no_pic">
                                    <img src="/assets/absen_tukang/{{$item->bukti_foto_absen}}"  alt="/assets/no_pic">
                                  </a></td>
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
