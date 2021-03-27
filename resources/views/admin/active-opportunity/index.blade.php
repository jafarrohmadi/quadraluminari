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
            <table class="table table-striped table-bordered datatable-User">
                <thead>
                <tr>
                    <th width="10">
                        No
                    </th>
                    <th>
                        Updated At
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
                        Opportunity Status
                    </th>
                    <th>
                        Value
                    </th>

                    <th style="min-width: 115px;">
                        &nbsp;Action
                    </th>
                </tr>
                </thead>
                <tbody>

                @foreach($query as $key => $data)
                    <tr>
                        <td>{{$key +1}}</td>
                        <td>{{$data->updated_at ?? ''}}</td>
                        <td>{{$data->activeClientData->name ?? ''}}</td>
                        <td>{{$data->userData->name ?? ''}}</td>
                        <td>{{$data->act_history_date ?? ''}}</td>
                        <td>{{ $data->act_history != \App\Models\ActiveOpportunity::ACT_HISTORY_OTHER ? (new \App\Models\ActiveOpportunity)->getActHistory($data->act_history) : $data->act_history_other_name ?? '' }}</td>
                        <td>{{ $data->opportunity_status ?? '' }}%</td>
                        <td>{{ $data->value ? (new \App\Models\ActiveOpportunity)->getCurrency($data->value_currency) . ' ' . number_format($data->value, 2, ',', '.') : ''}}</td>
                        <td>
                            @can('active_opportunity_view')
                                <a class="btn btn-xs btn-primary"
                                   href="{{ route('admin.active-opportunity.show', $data->id) }}">
                                    {{ trans('global.view') }}
                                </a>
                            @endcan

                            @can('active_opportunity_edit')
                                <a class="btn btn-xs btn-info"
                                   href="{{ route('admin.active-opportunity.edit', $data->id) }}">
                                    {{ trans('global.edit') }}
                                </a>
                            @endcan

                            @can('active_opportunity_delete')
                                <form action="{{ route('admin.active-opportunity.destroy', $data->id) }}" method="POST"
                                      onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                      style="display: inline-block;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-xs btn-danger"
                                           value="{{ trans('global.delete') }}">
                                </form>
                            @endcan

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
@section('scripts')
    @parent
    <script>
        $(function () {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

            $.extend(true, $.fn.dataTable.defaults, {
                order: [[1, 'desc']],
                pageLength: 100,
            })

            var table = $('.datatable-User:not(.ajaxTable)').DataTable({
                buttons: dtButtons, responsive: true, columnDefs: [
                    { targets: '_all', orderable: false }
                ]
            })

            function changeOrder (clickedIndex)
            {
                var currentSort  = table.order()
                var newOrder     = []
                var clickedOrder = 'asc'
                var addAtEnd     = true

                for (var col in currentSort) {

                    if(currentSort[col][0] === clickedIndex) {
                        addAtEnd     = false
                        clickedOrder = currentSort[col][1]
                        if(clickedOrder === 'asc') {
                            clickedOrder = 'desc'
                            newOrder.push([clickedIndex, clickedOrder])
                        }
                    } else {
                        newOrder.push(currentSort[col])
                    }
                }

                if(addAtEnd) {
                    newOrder.push([clickedIndex, clickedOrder])
                }
                table.order(newOrder).draw()
            }

            table.columns().every(function () {
                var index  = this.index()
                var header = $('.datatable-User thead th:eq(' + index + ')')

                header.addClass('sorting')
                header.removeClass('sorting_disable')
                header.click(function () {
                    changeOrder(index)
                })
            })

            $('.navbar-toggler').click(function (e) {
                table.columns.adjust().draw()
                // $('table.dataTable thead > tr > th.sorting_asc, table.dataTable thead > tr > th.sorting_desc, table.dataTable thead > tr > th.sorting, table.dataTable thead > tr > td.sorting_asc, table.dataTable thead > tr > td.sorting_desc, table.dataTable thead > tr > td.sorting').trigger('click')
            })

        })

    </script>
@endsection
