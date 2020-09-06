@extends('kontraktor.navbar')

@section('content')
    @if (count($listAdmin) > 0)
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Username</th>
                    <th scope="col">Nama Admin</th>
                    <th scope="col">Nomor HP</th>
                    <th scope="col">Email</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                    @foreach ($listAdmin as $item)
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{$item->username_admin}}</td>
                            <td>{{$item->nama_admin}}</td>
                            <td>{{$item->no_hp_admin}}</td>
                            <td>{{$item->email_admin}}</td>
                            <td>
                                <a href="/kontraktor/detAdmin/{{$item->kode_admin}}}" class="badge badge-success">Detail</a>
                            </td>
                        </tr>
                    @endforeach
            </tbody>
        </table>
    @else
        <h1>Tidak Ada Admin!</h1>
    @endif
@endsection
