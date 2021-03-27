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
            <table class="table table-striped table-bordered datatable-User"  width="100%">
                <thead>
                <tr>
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
                        &nbsp;Action
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($query as $key => $user)
                    <tr data-entry-id="{{ $user->id }}">
                        <td>
                            {{$user->updated_at}}
                        </td>
                        <td>
                            {{ $user->name ?? '' }}
                        </td>
                        <td>
                            {{ $user->contactPersonData->first()->contact_person_name ?? '' }}
                        </td>
                        <td>
                            <?php
                            $data = [];
                            if (isset($user->contactPersonData->first()->contact_person_mobile_email)) {
                                $explode = explode(";", $user->contactPersonData->first()->contact_person_mobile_email);

                                foreach ($explode as $email) {
                                    $data [] = sprintf('<span class="badge badge-info">%s</span>', $email);
                                }
                            }
                            echo $data ? implode(" ", $data) : '';
                            ?>

                        </td>
                        <td>
                            {{ $user->contactPersonData->first()->contact_person_mobile_phone ?? '' }}
                        </td>
                        <td>
                            {{ $user->addressCityData->name ?? '' }}
                        </td>
                        <td>
                            {{ $user->number_of_students ?? '' }}
                        </td>
                        <td>
                            {{ $user->number_of_lecturers ?? '' }}
                        </td>
                        <td>
                            {{ (new \App\Models\ActiveClient)->getStatus($user->status) ?? '' }}
                        </td>
                        <td>
                            @can('active_client_view')
                                <a class="btn btn-xs btn-primary"
                                   href="{{ route('admin.active-client.show', $user->id) }}">
                                    {{ trans('global.view') }}
                                </a>
                            @endcan

                            @can('active_client_edit')
                                <a class="btn btn-xs btn-info" href="{{ route('admin.active-client.edit', $user->id) }}">
                                    {{ trans('global.edit') }}
                                </a>
                            @endcan

                            @can('active_client_delete')
                                <form action="{{ route('admin.active-client.destroy', $user->id) }}" method="POST"
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
{{--            @can('active_client_delete')--}}
{{--            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'--}}
{{--            let deleteButton      = {--}}
{{--                text: deleteButtonTrans,--}}
{{--                url: "{{ route('admin.active-client.massDestroy') }}",--}}
{{--                className: 'btn-danger',--}}
{{--                action: function (e, dt, node, config) {--}}
{{--                    var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {--}}
{{--                        return entry.id--}}
{{--                    })--}}

{{--                    if(ids.length === 0) {--}}
{{--                        alert('{{ trans('global.datatables.zero_selected') }}')--}}

{{--                        return--}}
{{--                    }--}}

{{--                    if(confirm('{{ trans('global.areYouSure') }}')) {--}}
{{--                        $.ajax({--}}
{{--                            headers: { 'x-csrf-token': _token },--}}
{{--                            method: 'POST',--}}
{{--                            url: config.url,--}}
{{--                            data: { ids: ids, _method: 'DELETE' }--}}
{{--                        })--}}
{{--                            .done(function () {--}}
{{--                                location.reload()--}}
{{--                            })--}}
{{--                    }--}}
{{--                }--}}
{{--            }--}}
{{--            dtButtons.push(deleteButton)--}}
{{--            @endcan--}}

            $.extend(true, $.fn.dataTable.defaults, {
                order: [[1, 'desc']],
                pageLength: 100,
            })

            var table = $('.datatable-User:not(.ajaxTable)').DataTable({ buttons: dtButtons, responsive:true, columnDefs: [
                    { targets: '_all', orderable: false }
                ]})

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
                table.columns.adjust().draw();
               // $('table.dataTable thead > tr > th.sorting_asc, table.dataTable thead > tr > th.sorting_desc, table.dataTable thead > tr > th.sorting, table.dataTable thead > tr > td.sorting_asc, table.dataTable thead > tr > td.sorting_desc, table.dataTable thead > tr > td.sorting').trigger('click')
            })
        })
    </script>
@endsection
