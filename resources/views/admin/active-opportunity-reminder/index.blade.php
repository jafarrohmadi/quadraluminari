@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            Active Opportunity  Reminder {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-HistoryShip">
                <thead>
                <tr>
                    <th> </th>
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
                        Reminder
                    </th>

                    <th>
                        Act Order
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
            let dtOverrideGlobals = {
                buttons: dtButtons,
                processing: true,
                serverSide: true,
                retrieve: true,
                aaSorting: [],
                ajax: "{{ route('admin.active-opportunity-reminder.index') }}",
                columns: [
                    { data: 'placeholder', name: 'placeholder' },
                    { data: 'updated_at', name: 'updated_at' },
                    { data: 'product_name', name: 'product_name' },
                    { data: 'active_client_id', name: 'active_client_id' },
                    { data: 'user_id', name: 'user_id' },
                    { data: 'act_history_date', name: 'act_history_date' },
                    { data: 'act_history', name: 'act_history' },
                    { data: 'opportunity_status', name: 'opportunity_status' },
                    { data: 'act_history_date_reminder', name: 'act_history_date_reminder' },
                    { data: 'act_history_order_reminder', name: 'act_history_order_reminder' },
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
