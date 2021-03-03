@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.user.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.users.update", [$user->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.user.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="name">Username </label>
                <input class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}" type="text"
                       name="username" id="username" value="{{ old('username', $user->username) }}" required>
                @if($errors->has('username'))
                    <div class="invalid-feedback">
                        {{ $errors->first('username') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="email">{{ trans('cruds.user.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="text" name="email" id="email" value="{{ old('email', $user->email) }}" required>
                @if($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.email_helper') }}</span>
            </div>

            <div class="form-group">
                <label class="required" for="password">{{ trans('cruds.user.fields.password') }}</label>
                <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password" id="password">
                @if($errors->has('password'))
                    <div class="invalid-feedback">
                        {{ $errors->first('password') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.password_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="roles">Permission</label>
                <div class="row">
                    <div class="col-md-6">
                        <h4>Dashboard</h4>
                        @foreach($permission->where('id', 9) as  $permissions)
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" name="permissions[]"
                                           value="{{$permissions->id}}"
                                           id="defaultCheck{{$permissions->id}}" {{ (in_array($permissions->id, old('permissions', [])) || $user->permission->contains($permissions->id)) ? 'checked' : '' }}> {{$permissions->name}}
                                </label>
                            </div>
                        @endforeach
                        <br>
                        <h4>Active Client</h4>
                        @foreach($permission->whereIn('id', [1,2,3,4]) as  $permissions)
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" name="permissions[]"
                                           value="{{$permissions->id}}"
                                           id="defaultCheck{{$permissions->id}}" {{ (in_array($permissions->id, old('permissions', [])) || $user->permission->contains($permissions->id)) ? 'checked' : '' }}> {{$permissions->name}}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <div class="col-md-6">
                        <h4>Active Opportunity</h4>
                        @foreach($permission->whereIn('id', [5,6,7,8]) as  $permissions)
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" name="permissions[]"
                                           value="{{$permissions->id}}"
                                           id="defaultCheck{{$permissions->id}}" {{ (in_array($permissions->id, old('permissions', [])) || $user->permission->contains($permissions->id)) ? 'checked' : '' }}> {{$permissions->name}}
                                </label>
                            </div>
                        @endforeach
{{--                        <br>--}}
{{--                        <h4>User Management</h4>--}}
{{--                        @foreach($permission->whereIn('id', [10,11,12,13]) as  $permissions)--}}
{{--                            <div class="form-check">--}}
{{--                                <label class="form-check-label">--}}
{{--                                    <input type="checkbox" class="form-check-input" name="permissions[]"--}}
{{--                                           value="{{$permissions->id}}"--}}
{{--                                           id="defaultCheck{{$permissions->id}}" {{ (in_array($permissions->id, old('permissions', [])) || $user->permission->contains($permissions->id)) ? 'checked' : '' }}> {{$permissions->name}}--}}
{{--                                </label>--}}
{{--                            </div>--}}
{{--                        @endforeach--}}
                    </div>
                </div>
                @if($errors->has('permission'))
                    <div class="invalid-feedback">
                        {{ $errors->first('permission') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.roles_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>


    </div>
</div>
@endsection
