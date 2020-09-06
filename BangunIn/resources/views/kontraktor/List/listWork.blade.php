@extends('kontraktor.navbar')

@section('content')
    @if (count($listWork) > 0)
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Pekerjaan</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                    @foreach ($listWork as $item)
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{$item->nama_pekerjaan}}</td>
                            <td>{{$item->alamat_pekerjaan}}</td>
                            <td>{{$item->status_selesai}}</td>
                            <td>
                                <a href="/kontraktor/detWork/{{$item->kode_pekerjaan}}}" class="badge badge-success">Detail</a>
                            </td>
                        </tr>
                    @endforeach
            </tbody>
        </table>
    @else
        <h1>Tidak Ada Pekerjaan!</h1>
    @endif
@endsection
