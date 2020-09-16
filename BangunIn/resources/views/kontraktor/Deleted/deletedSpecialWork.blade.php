@extends('kontraktor.navbar')

@section('content')
    @if ($listDelSpWork !== null)
    <h1>Daftar Pekerjaan Khusus Yang Dihapus</h1>
        <div class="row-first">
            <form action="/kontraktor/search" method="post">
                @csrf
                <span class="form-group">
                    <label for="work">Nama Pekerjaan</label>
                    <div class="my-1">
                        <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="work" id="work" disabled>
                            <option selected>-</option>
                            @foreach ($listWork as $item)
                                <option value="{{$item['kode_pekerjaan']}}" @if ($item['kode_pekerjaan'] == $id)
                                    selected
                                @endif>{{$item['nama_pekerjaan']}}</option>
                            @endforeach
                        </select>
                    </div>
                </span>
            </form>
        </div>
        <div class="row-second">
            <div class="table-responsive">
            <table id="tabel-work" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Keterangan Pekerjaan Khusus</th>
                    <th scope="col">Total Bahan</th>
                    <th scope="col">Total Jasa</th>
                    <th scope="col">Total Keseluruhan</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody id="">
                @foreach ($listDelSpWork as $item)
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{$item->keterangan_pk}}</td>
                            <td>{{$item->total_bahan}}</td>
                            <td>{{$item->total_jasa}}</td>
                            <td>{{$item->total_keseluruhan}}</td>
                            <td>
                                <a href="/kontraktor/rollbackSpWorkMenu/{{encrypt($item->kode_pk)}}" class="btn btn-info">Pulihkan</a>
                            </td>
                        </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Keterangan Pekerjaan Khusus</th>
                    <th scope="col">Total Bahan</th>
                    <th scope="col">Total Jasa</th>
                    <th scope="col">Total Keseluruhan</th>
                    <th scope="col">Aksi</th>
                </tr>
            </tfoot>
            </table>
            </div>
        </div>
        <div class="option">
            <a class="btn btn-primary" href="/kontraktor/iSpWork">Kembali</a>
        </div>
    @else
    <div class="row-second">
        <h2>Tidak ada pekerjaan khusus yang dihapus!</h2>
        <div class="option">
            <a class="btn btn-primary" href="/kontraktor/iSpWork">Kembali</a>
        </div>
    </div>
    @endif
    <script>
        $(document).ready(function() {
            $("#tabel-work").DataTable();
    } );
    </script>
@endsection
