@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.pemeriksaan.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.pemeriksaans.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.pemeriksaan.fields.id') }}
                        </th>
                        <td>
                            {{ $pemeriksaan->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pemeriksaan.fields.subjektif') }}
                        </th>
                        <td>
                            {{ $pemeriksaan->subjektif }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pemeriksaan.fields.objektif') }}
                        </th>
                        <td>
                            {{ $pemeriksaan->objektif }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pemeriksaan.fields.penilaian') }}
                        </th>
                        <td>
                            {{ $pemeriksaan->penilaian }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pemeriksaan.fields.plan') }}
                        </th>
                        <td>
                            {{ $pemeriksaan->plan }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.pemeriksaans.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>


    </div>
</div>
@endsection