@extends('kontraktor.navbar')

@section('content')
    @if (count($listClients) > 0)
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Client</th>
                    <th>Nomor Telepon</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                    @foreach ($listClients as $item)
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{$item->nama_client}}</td>
                            <td>{{$item->no_hp_client}}</td>
                            <td>
                                <a href="/kontraktor/detMandor/{{$item->kode_mandor}}}" class="badge badge-success">Detail</a>
                            </td>
                        </tr>
                    @endforeach
            </tbody>
        </table>
    @else
        <h1>Tidak Ada Client!</h1>
    @endif
@endsection
