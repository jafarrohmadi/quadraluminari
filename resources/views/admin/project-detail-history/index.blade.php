@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            Project Detail History
        </div>

        <div class="card-body">
            <table class="table table-striped table-bordered datatable-User"  width="100%">
                <thead>
                <tr>
                    <th>
                        No
                    </th>
                    <th>
                        Updated At
                    </th>
                    <th>
                         Produk
                    </th>
                    <th>
                        QTY
                    </th>
                    <th>
                        Total
                    </th>
                    <th>
                        Notes
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $key => $user)
                    <tr data-entry-id="{{ $user->id }}">
                        <td>
                            {{$key + 1}}
                        </td>
                        <td>
                            {{$user->updated_at ?? ''}}
                        </td>
                        <td>
                            {{ $user->detail_name ?? '' }}
                        </td>
                        <td>
                            {{ $user->detail_qty ?? '' }}
                        </td>
                        <td>
                            {{ $user->detail_value ?? '' }}
                        </td>
                        <td>
                            {{ $user->detail_notes ?? '' }}
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
