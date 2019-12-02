@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.pemeriksaan.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.pemeriksaans.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="subjektif">{{ trans('cruds.pemeriksaan.fields.subjektif') }}</label>
                <input class="form-control {{ $errors->has('subjektif') ? 'is-invalid' : '' }}" type="text" name="subjektif" id="subjektif" value="{{ old('subjektif', '') }}" required>
                @if($errors->has('subjektif'))
                    <div class="invalid-feedback">
                        {{ $errors->first('subjektif') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.pemeriksaan.fields.subjektif_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="objektif">{{ trans('cruds.pemeriksaan.fields.objektif') }}</label>
                <input class="form-control {{ $errors->has('objektif') ? 'is-invalid' : '' }}" type="text" name="objektif" id="objektif" value="{{ old('objektif', '') }}" required>
                @if($errors->has('objektif'))
                    <div class="invalid-feedback">
                        {{ $errors->first('objektif') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.pemeriksaan.fields.objektif_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="penilaian">{{ trans('cruds.pemeriksaan.fields.penilaian') }}</label>
                <input class="form-control {{ $errors->has('penilaian') ? 'is-invalid' : '' }}" type="text" name="penilaian" id="penilaian" value="{{ old('penilaian', '') }}" required>
                @if($errors->has('penilaian'))
                    <div class="invalid-feedback">
                        {{ $errors->first('penilaian') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.pemeriksaan.fields.penilaian_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="plan">{{ trans('cruds.pemeriksaan.fields.plan') }}</label>
                <input class="form-control {{ $errors->has('plan') ? 'is-invalid' : '' }}" type="text" name="plan" id="plan" value="{{ old('plan', '') }}" required>
                @if($errors->has('plan'))
                    <div class="invalid-feedback">
                        {{ $errors->first('plan') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.pemeriksaan.fields.plan_helper') }}</span>
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