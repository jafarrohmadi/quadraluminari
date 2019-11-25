@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card mt-5">
            <div class="card-header text-center"><strong>TAMBAH DATA ITEM</strong>
            </div>
            <div class="card-body">
                <a href="/item" class="btn btn-primary">Kembali</a>
                <br/>
                <br/>
                
                <form method="post" action="/item/store">

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
                        <input type="submit" class="btn btn-success" value="Simpan">
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection