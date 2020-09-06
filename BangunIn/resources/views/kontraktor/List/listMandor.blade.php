@extends('kontraktor.navbar')

@section('content')
    @if (count($listMandor) > 0)
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Username</th>
                    <th scope="col">Nama Mandor</th>
                    <th scope="col">Nomor HP</th>
                    <th scope="col">Email</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                    @foreach ($listMandor as $item)
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{$item->username_mandor}}</td>
                            <td>{{$item->nama_mandor}}</td>
                            <td>{{$item->no_hp_mandor}}</td>
                            <td>{{$item->email_mandor}}</td>
                            <td>
                                <a href="/kontraktor/detMandor/{{$item->kode_mandor}}}" class="badge badge-success">Detail</a>
                            </td>
                        </tr>
                    @endforeach
            </tbody>
        </table>
    @else
        <h1>Tidak Ada Mandor!</h1>
    @endif
@endsection
