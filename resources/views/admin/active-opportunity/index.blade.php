@extends('layouts.admin')
@section('content')
    @can('active_client_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route("admin.active-opportunity.create") }}">
                    {{ trans('global.add') }} Active Opportunity
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            Active Opportunity {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-HistoryShip">
                <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        Updated At
                    </th>
                    <th>
                        Product Name
                    </th>
                    <th>
                        Active Client
                    </th>
                    <th>
                        PIC
                    </th>
                    <th>
                        Date
                    </th>
                    <th>
                        History
                    </th>
                    <th>
                        Status
                    </th>
                    <th>
                        Value
                    </th>

                    <th style="min-width: 115px;">
                        &nbsp;
                    </th>
                </tr>
                </thead>
            </table>
        </div>
    </div>

@endsection
@section('scripts')
    @parent
    <script>
        $(function () {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('active_opportunity_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton      = {
                text: deleteButtonTrans,
                url: "{{ route('admin.active-opportunity.massDestroy') }}",
                className: 'btn-danger',
                action: function (e, dt, node, config) {
                    var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
                        return entry.id
                    })

                    if(ids.length === 0) {
                        alert('{{ trans('global.datatables.zero_selected') }}')

                        return
                    }

                    if(confirm('{{ trans('global.areYouSure') }}')) {
                        $.ajax({
                            headers: { 'x-csrf-token': _token },
                            method: 'POST',
                            url: config.url,
                            data: { ids: ids, _method: 'DELETE' }
                        })
                            .done(function () {
                                location.reload()
                            })
                    }
                }
            }
            dtButtons.push(deleteButton)
            @endcan

            let dtOverrideGlobals = {
                buttons: dtButtons,
                processing: true,
                serverSide: true,
                retrieve: true,
                aaSorting: [],
                ajax: "{{ route('admin.active-opportunity.index') }}",
                columns: [
                    { data: 'placeholder', name: 'placeholder' },
                    { data: 'updated_at', name: 'updated_at' },
                    { data: 'product_name', name: 'product_name' },
                    { data: 'active_client_id', name: 'active_client_id' },
                    { data: 'user_id', name: 'user_id' },
                    { data: 'act_history_date', name: 'act_history_date' },
                    { data: 'act_history', name: 'act_history' },
                    { data: 'opportunity_status', name: 'opportunity_status' },
                    { data: 'value', name: 'value' },
                    { data: 'actions', name: '{{ trans('global.actions') }}', searchable: false, orderable: false },
                ], colReorder: {
                    order: [1]
                },
                order: [[1, 'desc']],
                pageLength: 10,
            }

            var table = $('.datatable-HistoryShip').DataTable(dtOverrideGlobals)
            $('.navbar-toggler').click(function (e){
                table.columns.adjust().draw();
            })

        })

    </script>
@endsection
