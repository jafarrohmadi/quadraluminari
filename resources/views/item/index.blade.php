@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card mt-5">
            <div class="card-header text-center">
                CRUD Item
            </div>
            <div class="card-body">
                <a href="{{ url('/item/create') }}" class="btn btn-primary">Input Item</a>
                <br/>
                <br/>
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($item as $p)
                        <tr>
                            <td>{{ $p->name }}</td>
                            <td>
                                <a href="/item/edit/{{ $p->id }}" class="btn btn-warning">Edit</a>
                                <a href="/item/delete/{{ $p->id }}" class="btn btn-danger">Hapus</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection