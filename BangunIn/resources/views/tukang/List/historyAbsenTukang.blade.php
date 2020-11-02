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
                    @if ($mode == 2){{-- Komplain --}}
                        <th scope="col">Aksi</th>
                    @endif
                </tr>
              </thead>
              <tbody id="">
                  @if ($listHistory !== null)
                    @foreach ($listHistory as $item)
                            <tr>
                                <th scope="row">{{$loop->iteration}}</th>
                                <td>{{$item->tanggal_absen}}</td>
                                <td>
                                    @if ($item->status_komplain == '1')
                                        Komplain diajukan
                                    @elseif ($item->status_komplain == '2')
                                        Absen Terkonfirmasi
                                    @else
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
                                    @endif
                                </td>
                                @if ($item->bukti_foto_absen == '-')
                                    <td>-</td>
                                @else
                                <td><a target="_blank" href="/assets/absen_tukang/{{$item->bukti_foto_absen}}" alt="/assets/default_tukang.png">
                                    <img src="/assets/absen_tukang/{{$item->bukti_foto_absen}}"  alt="/assets/default_tukang.png">
                                  </a></td>
                                @endif
                                @if ($mode == 2 && $item->status_komplain == '0'){{-- Komplain --}}
                                    <td>
                                        <a class="btn btn-danger" href="/tukang/complainA/{{$item->kode_absen}}">Komplain</a>
                                    </td>
                                @elseif($mode == 2 && $item->status_komplain == '1')
                                    <td>
                                        <a class="btn btn-info" href="/tukang/batal/{{$item->kode_absen}}">Batal</a>
                                    </td>
                                @endif
                                <form action="/tukang/confirmAbsen" method="post">
                                    <input type="hidden" name="idAbsen[]" value="{{$item->kode_absen}}">
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
                    @if ($mode == 2){{-- Komplain --}}
                        <th scope="col">Aksi</th>
                    @endif
                </tr>
              </tfoot>
            </table>
        </div>
        @if ($mode == "1") {{-- gajian --}}
            <div class="option">
                    <input type="submit" value="Konfirmasi absen" class="btn btn-primary">
                </form>
                <a class="btn btn-danger" href="/tukang/komplain">Komplain</a>
            </div>
        @elseif($mode == "2") {{-- komplain --}}
            <div class="option">
                <a class="btn btn-secondary" href="/tukang/selesaiComplain">Selesai</a>
            </div>
        @endif
    <script>
        $(document).ready(function() {
            $("#tabel-history").DataTable();
    } );
    </script>
@endsection
