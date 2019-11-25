@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card mt-5">
            <div class="card-header text-center"><strong>TAMBAH DATA USERS</strong>
            </div>
            <div class="card-body">
                <a href="/users" class="btn btn-primary">Kembali</a>
                <br/>
                <br/>
                
                <form method="post" action="/users/store">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Name ..">

                        @if($errors->has('name'))
                            <div class="text-danger">
                                {{ $errors->first('name')}}
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Username ..">

                        @if($errors->has('username'))
                            <div class="text-danger">
                                {{ $errors->first('username')}}
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" name="email" class="form-control" placeholder="Email ..">

                        @if($errors->has('email'))
                            <div class="text-danger">
                                {{ $errors->first('email')}}
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Role Id</label>
                        <input type="radio" name="role_Id" value="1"> Admin<br>
                        <input type="radio" name="role_id" value="2"> Pendaftaran<br>

                        @if($errors->has('role_id'))
                            <div class="text-danger">
                                {{ $errors->first('role_id')}}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-success" value="Simpan">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection