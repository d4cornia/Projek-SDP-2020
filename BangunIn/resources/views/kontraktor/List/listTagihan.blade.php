@extends('kontraktor.navbar')

@section('content')
<div class="option" style="float: right;margin:5px 0px 40px 0px;">
    <a href="/kontraktor/inputTagihan" class="btn btn-primary">Input Tagihan</a><br>
</div>
<br><br>
    @if (count($listDataTagihan) > 0)
        <div class="table-responsive">
            <table id="tabel-tagihan" class="table table-bordered table-striped">
              <thead>
                <tr>
                    <th>No</th>
                    <th>Pekerjaan</th>
                    <th>Keterangan</th>
                    <th>Tanggal Tagihan</th>
                    <th>Jumlah Tagihan</th>
                    <th>Sisa Tagihan</th>
                    <th>Action</th>
                </tr>
              </thead>
              <tbody id="">
                @foreach ($listDataTagihan as $item)
                    <tr>
                        <th scope="row">{{$loop->iteration}}</th>
                        <td>{{$item->nama_pekerjaan}}</td>
                        <td>Tagihan ke - {{$item->keterangan}}</td>
                        <td>{{$item->tanggal_tagihan}}</td>
                        <td>Rp. {{number_format($item->jumlah_tagihan)}}</td>
                        <td>Rp. {{number_format($item->sisa_tagihan)}}</td>
                        <td>
                        <a href="/kontraktor/hapusTagihan/{{encrypt($item->id_tagihan)}}" class="btn btn-danger delete">Hapus</a>
                        </td>
                    </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                    <th>No</th>
                    <th>Pekerjaan</th>
                    <th>Keterangan</th>
                    <th>Tanggal Tagihan</th>
                    <th>Jumlah Tagihan</th>
                    <th>Sisa Tagihan</th>
                    <th>Action</th>
                </tr>
              </tfoot>
            </table>
            </div>
    @else
        <h1>Tidak Ada Tagihan!</h1>
    @endif
    <script>
        $(document).ready(function() {
            $("#tabel-tagihan").DataTable();
    } );
    </script>
@endsection

