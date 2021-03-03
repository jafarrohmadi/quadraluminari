<div class="card">
    <div class="card-header">
        Active Opportunity History {{ trans('global.list') }}
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
                    Company Name
                </th>
                <th>
                    Date Act/ Opp
                </th>
                <th>
                    Act History
                </th>
                <th>
                    Act History Remarks
                </th>
                <th>
                    Opportunity Status
                </th>
                <th>
                    Opportunity Status Remarks
                </th>
                <th>
                    Created By
                </th>
                @if (me()->id == 1)
                    <th style="min-width: 115px;">
                        &nbsp;
                    </th>
                @endif
            </tr>
            </thead>
        </table>
    </div>
</div>


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
                ajax: "{{ route('admin.get-active-opportunity-history.index', $activeOpportunity->id ) }}",
                columns: [
                    { data: 'placeholder', name: 'placeholder' },
                    { data: 'updated_at', name: 'updated_at' },
                    { data: 'product_name', name: 'product_name' },
                    { data: 'active_client_id', name: 'active_client_id' },
                    { data: 'act_history_date', name: 'act_history_date' },
                    { data: 'act_history', name: 'act_history' },
                    { data: 'act_history_remarks', name: 'act_history_remarks' },
                    { data: 'opportunity_status', name: 'opportunity_status' },
                    { data: 'opportunity_status_remarks', name: 'opportunity_status_remarks' },
                    { data: 'created_by', name: 'created_by' },
                        @if (me()->id == 1)
                    {
                        data: 'actions', name: '{{ trans('global.actions') }}', searchable: false, orderable: false
                    },
                    @endif
                ], colReorder: {
                    order: [1]
                },
                order: [[1, 'desc']],
                pageLength: 10,
            }

            var table = $('.datatable-HistoryShip').DataTable(dtOverrideGlobals)
            $('.navbar-toggler').click(function (e) {
                table.columns.adjust().draw()
            })

        })
    </script>
@endsection
