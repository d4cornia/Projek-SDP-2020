@extends('mandor.navbar')

@section('content')
    <h1>Jenis Tukang yang Telah Dihapus</h1>
    <hr>
    <div class="option" style="margin-left:78%">
        <a class="btn btn-primary"  href="/mandor/lihatJenisTukang" style="width:250px"><font size="3">Lihat Jenis Tukang yang Aktif</font></a>
    </div>
    <br>
    @if (count($listDelJenisTukangs) > 0)
        <div class="table-responsive">
            <table id="tabel-jenis" class="table table-bordered table-striped">
              <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Jenis</th>
                    <th>Gaji Pokok</th>
                    <th>Action</th>
                </tr>
              </thead>
              <tbody id="">
                @foreach ($listDelJenisTukangs as $item)
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{$item->nama_jenis}}</td>
                            <td align="right">Rp. {{number_format($item->gaji_pokok)}}</td>
                            <td>
                                <a href="/mandor/rollbackJenisTukang/{{$item->kode_jenis}}" class="btn btn-info">Pulihkan</a>
                            </td>
                        </tr>
                    @endforeach
              </tbody>
              <tfoot>
                <tr>
                    <th>No</th>
                    <th>Nama Jenis</th>
                    <th>Gaji Pokok</th>
                    <th>Action</th>
                </tr>
              </tfoot>
            </table>
            </div>
    @else
        <h4>Tidak Ada Jenis Tukang yang Dihapus!</h4>
    @endif
    <script>
        $(document).ready(function() {
            $("#tabel-jenis").DataTable();
    } );
    </script>
@endsection

