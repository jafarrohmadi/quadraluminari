<div class="card" id="activeClick">
    <div class="card-header">
        Active Client {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped table-hover datatable-User" width="100%">
            <thead>
            <tr>
                <th width="10">
                    No
                </th>
                <th>
                    Updated At
                </th>

                <th>
                    Company Name
                </th>
                <th>
                    Mailing Address
                </th>
                <th>
                    City
                </th>
                <th>
                    Postal Code
                </th>
                <th>
                    Contact Person
                </th>
                <th>
                    Jabatan
                </th>
                <th>
                    Phone
                </th>
                <th>
                    Mobile Phone
                </th>
                <th>
                    Email
                </th>
                <th>
                    PIC
                </th>
                <th>
                    Value
                </th>
                <th>
                    Date Acc/Opp
                </th>
                <th>
                    Act
                </th>
                <th>
                    Act Remarks
                </th>
                <th>
                    Opp Status
                </th>
                <th>
                    Opp Status Remarks
                </th>
                <th>
                    Reminder
                </th>
                <th>
                    Reminder Date
                </th>
                <th>
                    Act Reminder
                </th>
                <th>
                    Act Order
                </th>
                <th>
                    Notes
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($query as $key => $row)
                <tr>
                    <td width="10">
                        {{$key + 1}}
                    </td>
                    <td>
                        {{ $row->updated_at }}
                    </td>

                    <td>
                        {{$row->activeClientData->name ?? ''}}
                    </td>
                    <td>
                        {{$row->activeClientData->address_mailing_address ?? ''}}
                    </td>
                    <td>
                        {{$row->activeClientData->addressCityData->name ?? ''}}
                    </td>
                    <td>
                        {{$row->activeClientData->address_postal_code ?? ''}}
                    </td>
                    <td>
                        {{$row->activeClientData->contact_person_name ?? ''}}
                    </td>
                    <td>
                        {{$row->activeClientData->contact_person_name ?? ''}}
                    </td>
                    <td>
                        {{$row->activeClientData->contact_person_phone ?? ''}}
                    </td>
                    <td>
                        {{$row->activeClientData->contact_person_mobile_phone ?? ''}}
                    </td>
                    <td>
                        {{$row->activeClientData->contact_person_mobile_email ?? ''}}
                    </td>
                    <td>
                        {{$row->userData->name ?? ''}}
                    </td>
                    <td>
                        {{ $row->value_currency ? (new \App\Models\ActiveOpportunity)->getCurrency($row->value_currency) . ' ' .
                   number_format($row->value, 2, ',', '.') : ''}}
                    </td>
                    <td>
                        {{ $row->act_history_date ?? '' }}
                    </td>
                    <td>
                        {{$row->act_history ? $row->act_history !=
                   \App\Models\ActiveOpportunity::ACT_HISTORY_OTHER ? (new \App\Models\ActiveOpportunity)->getActHistory($row->act_history) : $row->act_history_other_name: ''}}
                    </td>
                    <td>
                        {{$row->act_history_remarks ?? ''}}
                    </td>
                    <td>
                        {{$row->opportunity_status ?? 0}} %
                    </td>
                    <td>
                        {{$row->opportunity_status_remarks ?? ''}}
                    </td>
                    <td>
                        {{$row->reminder == 1 ? 'Ya' : 'Tidak'}}
                    </td>
                    <td>
                        {{$row->activeOpportunityHistoryReminderData->last()->act_history_date_reminder ?? ''}}
                    </td>
                    <td>
                        {{ $row->activeOpportunityHistoryReminderData->last()->act_history_reminder ?  $row->activeOpportunityHistoryReminderData->last()->act_history_reminder !=
                   \App\Models\ActiveOpportunity::ACT_HISTORY_OTHER ? (new \App\Models\ActiveOpportunity)->getActHistory($row->activeOpportunityHistoryReminderData->last()->act_history_reminder) : $row->activeOpportunityHistoryReminderData->last()->act_history_other_name_reminder : ''}}
                    </td>
                    <td>
                        {{$row->activeOpportunityHistoryReminderData->last()->act_history_order_reminder ?? ''}}
                    </td>
                    <td>
                        {{$row->activeOpportunityHistoryReminderData->last()->act_history_notes_reminder ?? ''}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

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
