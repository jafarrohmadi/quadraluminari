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
                            <button class="btn btn-danger submitData" type="submit">
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card scriptActive" style="display: none">
        <div class="card-header">
            Active Client {{ trans('global.list') }}
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
                        Company Name
                    </th>
                    <th>
                        PIC
                    </th>
                    <th>
                        Email
                    </th>
                    <th>
                        Phone
                    </th>
                    <th>
                        City
                    </th>
                    <th>
                        Student
                    </th>
                    <th>
                        Lecture
                    </th>
                    <th>
                        Status
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

        $('.submitData').click(function (e) {
            load_data($('#date_start').val(), $('#date_end').val())
            $('.scriptActive').show()
        })

        function load_data (date_start = '', date_end = '')
        {
            let dtButtons         = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            let dtOverrideGlobals = {
                buttons: dtButtons,
                processing: true,
                serverSide: true,
                retrieve: true,
                aaSorting: [],
                ajax: {
                    url: "{{ route('admin.home') }}",
                    data: { date_start: date_start, date_end: date_end }
                },
                columns: [
                    { data: 'placeholder', name: 'placeholder' },
                    { data: 'updated_at', name: 'updated_at' },
                    { data: 'name', name: 'name' },
                    { data: 'contact_person_name', name: 'contact_person_name' },
                    { data: 'contact_person_mobile_email', name: 'contact_person_mobile_email' },
                    { data: 'contact_person_phone', name: 'contact_person_phone' },
                    { data: 'address_city_id', name: 'address_city_id' },
                    { data: 'number_of_students', name: 'number_of_students' },
                    { data: 'number_of_lecturers', name: 'number_of_lecturers' },
                    { data: 'status', name: 'status' },
                ], colReorder: {
                    order: [1]
                },
                order: [[1, 'desc']],
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
                pageLength: -1
            }

            $('.datatable-HistoryShip').DataTable(dtOverrideGlobals)
        }

        $('.navbar-toggler').click(function (e) {
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust()
        })


    </script>
@endsection
