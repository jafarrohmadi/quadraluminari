@extends('layouts.admin')
@section('content')
@can('pemeriksaan_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.pemeriksaans.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.pemeriksaan.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.pemeriksaan.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Pemeriksaan">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.pemeriksaan.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.pemeriksaan.fields.subjektif') }}
                        </th>
                        <th>
                            {{ trans('cruds.pemeriksaan.fields.objektif') }}
                        </th>
                        <th>
                            {{ trans('cruds.pemeriksaan.fields.penilaian') }}
                        </th>
                        <th>
                            {{ trans('cruds.pemeriksaan.fields.plan') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pemeriksaans as $key => $pemeriksaan)
                        <tr data-entry-id="{{ $pemeriksaan->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $pemeriksaan->id ?? '' }}
                            </td>
                            <td>
                                {{ $pemeriksaan->subjektif ?? '' }}
                            </td>
                            <td>
                                {{ $pemeriksaan->objektif ?? '' }}
                            </td>
                            <td>
                                {{ $pemeriksaan->penilaian ?? '' }}
                            </td>
                            <td>
                                {{ $pemeriksaan->plan ?? '' }}
                            </td>
                            <td>
                                @can('pemeriksaan_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.pemeriksaans.show', $pemeriksaan->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('pemeriksaan_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.pemeriksaans.edit', $pemeriksaan->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('pemeriksaan_delete')
                                    <form action="{{ route('admin.pemeriksaans.destroy', $pemeriksaan->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('pemeriksaan_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.pemeriksaans.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    order: [[ 1, 'desc' ]],
    pageLength: 10,
  });
  $('.datatable-Pemeriksaan:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection