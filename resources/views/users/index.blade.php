@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card mt-5">
            <div class="card-header text-center">
                CRUD User
            </div>
            <div class="card-body">
                <a href="{{ url('/users/create') }}" class="btn btn-primary">Input User</a>
                <br/>
                <br/>
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role Id</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $p)
                        <tr>
                            <td>{{ $p->name }}</td>
                            <td>{{ $p->username }}</td>
                            <td>{{ $p->email }}</td>
                            <td>{{ $p->role_id == 1 ? 'admin' : 'pendaftaran' }}</td>
                            <td>
                                <a href="/users/edit/{{ $p->id }}" class="btn btn-warning">Edit</a>
                                <a href="/users/delete/{{ $p->id }}" class="btn btn-danger">Hapus</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection