@extends('kontraktor.navbar')

@section('content')
<a href="/kontraktor/inputTagihan" class="btn btn-primary">Input Tagihan</a><br><br>
    @if (count($listDataTagihan) > 0)
        <div class="table-responsive">
            <table id="tabel-tagihan" class="table table-bordered table-striped">
              <thead>
                <tr>
                    <th>No</th>
                    <th>Pekerjaan</th>
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
                        <td>{{$item->tanggal_tagihan}}</td>
                        <td>Rp. {{number_format($item->jumlah_tagihan)}}</td>
                        <td>Rp. {{number_format($item->sisa_tagihan)}}</td>
                        <td>
                            <a href="" class="btn btn-success">Detail</a>
                            <a href="" class="btn btn-danger delete">Hapus</a>
                        </td>
                    </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                    <th>No</th>
                    <th>Pekerjaan</th>
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

