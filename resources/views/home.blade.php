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
                            <div class="form-group">
                                <label class="" for="name">Opportunity Status</label>
                                <select name="opportunity_status" id="opportunity_status"
                                        class="form-control {{ $errors->has('opportunity_status') ? 'is-invalid' : '' }}">
                                    @for($i = 0; $i <=10; $i++)
                                        <option value="{{ $i*10 }}">{{ $i*10 }}%
                                        </option>
                                    @endfor
                                </select>
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
    <div class="tableDatabase">

    </div>
@endsection
@section('scripts')
    @parent
    <script>
        $(function () {

            $('.submitData').click(function (e) {
                var startDate         = $('#date_start').val()
                var endDate           = $('#date_end').val()
                var opportunityStatus = $('#opportunity_status').val()
                $.ajax({
                    url: "{{ route('admin.homePost') }}",
                    type: 'POST',
                    data: {
                        date_start: startDate,
                        date_end: endDate,
                        opportunity_status: opportunityStatus,
                        _token: "{{ csrf_token() }}"
                    }, success: function (data) {
                        $('.tableDatabase').html(data)
                    },

                })
            })

            setTimeout(
                function () {
                    $('.submitData').trigger('click')
                },
                500)

        })
    </script>

@endsection
