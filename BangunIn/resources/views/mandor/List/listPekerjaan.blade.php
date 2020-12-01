@extends('mandor.navbar')

@section('content')
@if (isset($pesan))
    <script>
        swal("Bagus!", "{{$pesan}}","success");
    </script>
@endif
<h1>List Pekerjaan</h1>
<hr>
<div class="col-12 text-right">
    <a class="btn btn-primary"  href="/mandor/lihatHistoryPekerjaan">Lihat History Pekerjaan Selesai</a>
</div>
<br>
@if (count($pekerjaan) > 0)
    <div class="table-responsive">
        <table id="tabel-jenis" class="table table-bordered table-striped">
          <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Nama Pekerjaan</th>
                <th scope="col">Alamat</th>
                <th scope="col">Aksi</th>
            </tr>
          </thead>
          <tbody id="">
            @foreach ($pekerjaan as $item)
                <tr>
                    <th scope="row">{{$loop->iteration}}</th>
                    <td>{{$item->nama_pekerjaan}}</td>
                    <td>{{$item->alamat_pekerjaan}}</td>
                    <td>
                        <a href="/mandor/detWork/{{encrypt($item->kode_pekerjaan)}}" class="btn btn-warning">Detail</a>
                        <a href="/mandor/sProject/{{encrypt($item->kode_pekerjaan)}}" class="btn btn-danger">Selesaikan</a>

                    </td>
                </tr>
                @endforeach
          </tbody>
          <tfoot>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Nama Pekerjaan</th>
                <th scope="col">Alamat</th>
                <th scope="col">Persetujuan Harga Awal</th>
            </tr>
          </tfoot>
        </table>
        </div>

@else
    <h4>Tidak Ada Pekerjaan!</h4>
@endif
<script>
    $(document).ready(function() {
        $("#tabel-jenis").DataTable();
} );
</script>
@endsection
