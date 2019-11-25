@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card mt-5">
            <div class="card-header text-center">
                <strong>EDIT DATA Item</strong>
            </div>
            <div class="card-body">
                <a href="/users" class="btn btn-primary">Kembali</a>
                <br/>
                <br/>
                

                <form method="post" action="/users/update/{{ $users->id }}">

                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Nama users .." value=" {{ $users->name }}">

                        @if($errors->has('name'))
                            <div class="text-danger">
                                {{ $errors->first('name')}}
                            </div>
                        @endif

                    </div>

                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Username .." value=" {{ $users->username }}">

                        @if($errors->has('username'))
                            <div class="text-danger">
                                {{ $errors->first('username')}}
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" name="email" class="form-control" placeholder="Email .." value=" {{ $users->email }}">

                        @if($errors->has('email'))
                            <div class="text-danger">
                                {{ $errors->first('email')}}
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Role Id</label>
                        <input type="radio" name="role_id" value="1" <?php echo $users->role_id == 1 ? 'checked':'' ;?> > Admin<br>
                        <input type="radio" name="role_id" value="2" <?php echo $users->role_id == 2 ? 'checked':''; ?> > Pendaftaran<br>

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