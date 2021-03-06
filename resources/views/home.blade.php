@extends('layouts.admin')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        Dashboard
                    </div>

                    <div class="card-body">
                        @if(session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="form-group row">
                            <div class="col-md-3">
                                <label class="" for="name">Date Start</label>
                                <div class="input-group">
                                    <input type="text" id="date_start"
                                           name="date_start"
                                           class="form-control date">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="" for="name">Date End</label>
                                <div class="input-group">
                                    <input type="text" id="date_end"
                                           name="date_end"
                                           class="form-control date">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="" for="name">Opportunity Status</label>
                                <div class="input-group">
                                    <input type="text" id="opportunity_status"
                                           name="opportunity_status"
                                           class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-danger submitData" type="submit" id="submitData">
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card" id="activeClick" style="display: none">
        <div class="card-header">
            Active Client {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <table class="table table-bordered table-striped table-hover datatable-HistoryShip" width="100%">
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
            </table>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        let dtButtons         = $.extend(true, [], $.fn.dataTable.defaults.buttons)
        let dtOverrideGlobals = {
            buttons: dtButtons,
            processing: true,
            serverSide: true,
            retrieve: true,
            aaSorting: [],
            ajax: {
                url: "{{ route('admin.homePost') }}",
                type: 'POST',
                data: function (data) {
                    var startDate         = $('#date_start').val()
                    var endDate           = $('#date_end').val()
                    var opportunityStatus = $('#opportunity_status').val()
                    data.date_start         = startDate
                    data.date_end           = endDate
                    data.opportunity_status = opportunityStatus
                    data._token             = "{{ csrf_token() }}"
                }
            },
            columns: [
                { data: 'placeholder', name: 'placeholder' },
                { data: 'updated_at', name: 'updated_at' },
                { data: 'product_name', name: 'product_name' },
                { data: 'active_client_id', name: 'active_client_id' },
                { data: 'mailing_address', name: 'activeClientData.address_mailing_address' },
                { data: 'city_id', name: 'activeClientData.contact_person_city_id' },
                { data: 'postal_code', name: 'activeClientData.address_postal_code' },
                { data: 'contact_person_name', name: 'activeClientData.contact_person_name' },
                { data: 'contact_person_grade', name: 'activeClientData.contact_person_grade' },
                { data: 'phone', name: 'activeClientData.contact_person_name' },
                { data: 'mobile_phone', name: 'activeClientData.contact_person_mobile_phone' },
                { data: 'email', name: 'activeClientData.contact_person_mobile_email' },
                { data: 'user_id', name: 'user_id' },
                { data: 'value', name: 'value' },
                { data: 'act_history_date', name: 'act_history_date' },
                { data: 'act_history', name: 'act_history' },
                { data: 'act_history_remarks', name: 'act_history_remarks' },
                { data: 'opportunity_status', name: 'opportunity_status' },
                { data: 'opportunity_status_remarks', name: 'opportunity_status_remarks' },
                { data: 'reminder', name: 'reminder' },
                {
                    data: 'act_history_date_reminder',
                    name: 'activeOpportunityHistoryReminderData.act_history_date_reminder'
                },
                { data: 'act_history_reminder', name: 'activeOpportunityHistoryReminderData.act_history_reminder' },
                {
                    data: 'act_history_order_reminder',
                    name: 'activeOpportunityHistoryReminderData.act_history_order_reminder'
                },
                {
                    data: 'act_history_notes_reminder',
                    name: 'activeOpportunityHistoryReminderData.act_history_notes_reminder'
                },

            ], colReorder: {
                order: [1]
            },
            order: [[1, 'desc']],
            responsive: true,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
            pageLength: -1
        }

        $('.submitData').click(function (e) {
            var table = $('.datatable-HistoryShip').DataTable(dtOverrideGlobals)
            $('#activeClick').show()
            table.draw()
        })

        setTimeout(
            function () {
                $('.submitData').trigger('click')
            },
            500)
    </script>
@endsection
