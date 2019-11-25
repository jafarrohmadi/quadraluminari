@extends('layouts.pendaftaran')
@section('content')
    <div class="container">
        <div class="card mt-5">
            <div class="card-header text-center"><strong>TRANSACTIONS</strong>
            </div>
            <div class="card-body">
                <form method="post" action="/transactions/store">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label>Customer Name</label>
                        <input type="text" name="customer_name" class="form-control" placeholder="Customer Name">

                        @if($errors->has('customer_name'))
                            <div class="text-danger">
                                {{ $errors->first('customer_name')}}
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Item Id</label>
                        <select name='item_id' class="form-control">
                            @foreach($item as $p)
                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                            @endforeach
                        </select> 

                        @if($errors->has('item_id'))
                            <div class="text-danger">
                                {{ $errors->first('item_id')}}
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