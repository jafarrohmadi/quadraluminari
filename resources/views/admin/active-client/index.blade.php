@extends('layouts.admin')
@section('content')
    @can('active_client_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route("admin.active-client.create") }}">
                    {{ trans('global.add') }} Active Client
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
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
            @can('active_client_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton      = {
                text: deleteButtonTrans,
                url: "{{ route('admin.active-client.massDestroy') }}",
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
                ajax: "{{ route('admin.active-client.index') }}",
                columns: [
                    { data: 'placeholder', name: 'placeholder' },
                    { data: 'updated_at', name: 'updated_at' },
                    { data: 'name', name: 'name' },
                    { data: 'contact_person_name', name: 'contact_person_name'},
                    { data: 'contact_person_mobile_email', name: 'contact_person_mobile_email'},
                    { data: 'contact_person_phone', name: 'contact_person_phone'},
                    { data: 'address_city_id', name: 'address_city_id'},
                    { data: 'number_of_students', name: 'number_of_students'},
                    { data: 'number_of_lecturers', name: 'number_of_lecturers'},
                    { data: 'status', name: 'status'},
                    { data: 'actions', name: '{{ trans('global.actions') }}', searchable: false, orderable: false },

                ], colReorder: {
                    order: [1]
                },
                order: [[1, 'desc']],
                pageLength: 100,
            }
            $('.datatable-HistoryShip').DataTable(dtOverrideGlobals)
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust()
            })
        })

    </script>
@endsection
