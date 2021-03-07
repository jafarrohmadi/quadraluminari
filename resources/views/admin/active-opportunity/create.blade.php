@extends('layouts.admin')
@section('content')
    <h3>{{ trans('global.create') }} Active Opportunity</h3>
    <br>
    <form method="POST" action="{{ route("admin.active-opportunity.store") }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Active Client
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <label class="required" for="name">Company Name</label>
                            <select class="cari form-control" style="width:500px;" name="cari" id="cari"
                                    required></select>
                            @if($errors->has('cari'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('cari') }}
                                </div>
                            @endif
                            <input type="hidden" name="active_client_id" id="active_client_id"
                                   value="{{old('active_client_id', '')}}">
                        </div>
                        <div class="form-group">
                            <label class="" for="name">Company Person Name</label>
                            <input class="form-control {{ $errors->has('contact_person_name') ? 'is-invalid' : '' }}"
                                   type="text" name="contact_person_name"
                                   id="contact_person_name" value="{{ old('contact_person_name', '') }}" disabled>
                            @if($errors->has('contact_person_name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('contact_person_name') }}
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label class="" for="name">Mailing Address</label>
                            <textarea
                                class="form-control {{ $errors->has('address_mailing_address') ? 'is-invalid' : '' }}"
                                name="address_mailing_address"
                                id="address_mailing_address"
                                disabled>{{ old('address_mailing_address', '') }}</textarea>
                            @if($errors->has('address_mailing_address'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('address_mailing_address') }}
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label class="" for="name">Number Of Students</label>
                            <input class="form-control {{ $errors->has('number_of_students') ? 'is-invalid' : '' }}"
                                   type="text" name="number_of_students"
                                   id="number_of_students" value="{{ old('number_of_students', '') }}" disabled>
                            @if($errors->has('number_of_students'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('number_of_students') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="" for="name">Number Of Lectures</label>
                            <input class="form-control {{ $errors->has('number_of_lecturers') ? 'is-invalid' : '' }}"
                                   type="text" name="number_of_lecturers"
                                   id="number_of_lecturers" value="{{ old('number_of_lecturers', '') }}" disabled>
                            @if($errors->has('number_of_lecturers'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('number_of_lecturers') }}
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Active Opportunity
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <label class="required" for="name">QO/PROJECT</label>
                            <input class="form-control {{ $errors->has('project') ? 'is-invalid' : '' }}"
                                   type="text" name="project" id="project" value="{{ old('project', '') }}" required>
                            @if($errors->has('project'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('project') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="required" for="name">Product Name</label>
                            <input class="form-control {{ $errors->has('product_name') ? 'is-invalid' : '' }}"
                                   type="text" name="product_name"
                                   id="product_name" value="{{ old('product_name', '') }}" required>
                            @if($errors->has('product_name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('product_name') }}
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label class="required" for="name">PIC</label>
                            @if(me()->id != 1)
                                <input class="form-control {{ $errors->has('project') ? 'is-invalid' : '' }}"
                                       value="{{ me()->username }}" disabled>
                                <input type="hidden" name="user_id" value="{{ me()->id }}">
                            @else
                                <select class="form-control select2 {{ $errors->has('project') ? 'is-invalid' : '' }}"
                                        name="user_id" id="user_id" required>
                                    @foreach($user as $users)
                                        <option value="{{$users->id}}">{{$users->username}}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('user_id'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('user_id') }}
                                    </div>
                                @endif
                            @endif
                        </div>

                        <div class="form-group">
                            <label class="" for="name">Value</label>
                            <div class="row">
                                <div class="col-md-3">
                                    <select
                                        class="form-control select2 {{ $errors->has('value_currency') ? 'is-invalid' : '' }}"
                                        name="value_currency" id="value_currency">
                                        <option
                                            value="{{\App\Models\ActiveOpportunity::CURRENCY_IDR}}">{{(new \App\Models\ActiveOpportunity)->getCurrency(\App\Models\ActiveOpportunity::CURRENCY_IDR)}}</option>
                                        <option
                                            value="{{\App\Models\ActiveOpportunity::CURRENCY_USD}}">{{(new \App\Models\ActiveOpportunity)->getCurrency(\App\Models\ActiveOpportunity::CURRENCY_USD)}}</option>
                                    </select>

                                    @if($errors->has('value_currency'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('value_currency') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-9">
                                    <input type="number" name="value" id="value"
                                           class="form-control {{ $errors->has('value') ? 'is-invalid' : '' }}">
                                    @if($errors->has('value'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('value') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required" for="name">Act History</label>
                                    <select
                                        class="form-control select2 {{ $errors->has('act_history') ? 'is-invalid' : '' }}"
                                        name="act_history" id="act_history">
                                        <option
                                            value="{{\App\Models\ActiveOpportunity::ACT_HISTORY_CALL}}">{{ (new \App\Models\ActiveOpportunity)->getActHistory(\App\Models\ActiveOpportunity::ACT_HISTORY_CALL) }}</option>
                                        <option
                                            value="{{\App\Models\ActiveOpportunity::ACT_HISTORY_EMAIL}}">{{ (new \App\Models\ActiveOpportunity)->getActHistory(\App\Models\ActiveOpportunity::ACT_HISTORY_EMAIL) }}</option>
                                        <option
                                            value="{{\App\Models\ActiveOpportunity::ACT_HISTORY_MEETING}}">{{ (new \App\Models\ActiveOpportunity)->getActHistory(\App\Models\ActiveOpportunity::ACT_HISTORY_MEETING) }}</option>
                                        <option
                                            value="{{\App\Models\ActiveOpportunity::ACT_HISTORY_PRESENTATION}}">{{ (new \App\Models\ActiveOpportunity)->getActHistory(\App\Models\ActiveOpportunity::ACT_HISTORY_PRESENTATION) }}</option>
                                        <option
                                            value="{{\App\Models\ActiveOpportunity::ACT_HISTORY_OTHER}}">{{ (new \App\Models\ActiveOpportunity)->getActHistory(\App\Models\ActiveOpportunity::ACT_HISTORY_OTHER) }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label class="" for="name">Act History Date</label>
                                        <div class="input-group">
                                            <input type="text" id="act_history_date" name="act_history_date"
                                                   class="form-control date">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group act_history_other_name d-none">
                            <label class="" for="name">Act History Other</label>
                            <input class="form-control {{ $errors->has('act_history_other_name') ? 'is-invalid' : '' }}"
                                   id="act_history_other_name"
                                   name="act_history_other_name" value="{{ old('act_history_other_name', '') }}">
                        </div>
                        <div class="form-group">
                            <label class="" for="name">Act History Remarks</label>
                            <textarea class="form-control {{ $errors->has('act_history_remarks') ? 'is-invalid' : '' }}"
                                      id="act_history_remarks"
                                      name="act_history_remarks">{{ old('act_history_remarks', '') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label class="" for="name">Opportunity Status</label>
                            <input class="form-control {{ $errors->has('opportunity_status') ? 'is-invalid' : '' }}"
                                   id="opportunity_status"
                                   name="opportunity_status" value="{{ old('opportunity_status', '') }}">
                        </div>

                        <div class="form-group">
                            <label class="" for="name">Opportunity Status Remarks</label>
                            <textarea
                                class="form-control {{ $errors->has('opportunity_status_remarks') ? 'is-invalid' : '' }}"
                                id="opportunity_status_remarks"
                                name="opportunity_status_remarks">{{ old('opportunity_status_remarks', '') }}</textarea>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                Reminder
            </div>

            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-9 col-form-label">
                        <div class="form-check checkbox">
                            <input class="form-check-input" type="checkbox" value="{{ old('reminder', '1') }}"
                                   id="reminder" name="reminder">
                            <label class="form-check-label" for="check1">
                                Reminder
                            </label>
                        </div>
                    </div>
                    @if($errors->has('reminder'))
                        <div class="invalid-feedback">
                            {{ $errors->first('reminder') }}
                        </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="required" for="name">Act Reminder</label>
                            <select
                                class="form-control select2 {{ $errors->has('act_history_reminder') ? 'is-invalid' : '' }}"
                                name="act_history_reminder" id="act_history_reminder">
                                <option
                                    value="{{\App\Models\ActiveOpportunity::ACT_HISTORY_CALL}}">{{ (new \App\Models\ActiveOpportunity)->getActHistory(\App\Models\ActiveOpportunity::ACT_HISTORY_CALL) }}</option>
                                <option
                                    value="{{\App\Models\ActiveOpportunity::ACT_HISTORY_EMAIL}}">{{ (new \App\Models\ActiveOpportunity)->getActHistory(\App\Models\ActiveOpportunity::ACT_HISTORY_EMAIL) }}</option>
                                <option
                                    value="{{\App\Models\ActiveOpportunity::ACT_HISTORY_MEETING}}">{{ (new \App\Models\ActiveOpportunity)->getActHistory(\App\Models\ActiveOpportunity::ACT_HISTORY_MEETING) }}</option>
                                <option
                                    value="{{\App\Models\ActiveOpportunity::ACT_HISTORY_PRESENTATION}}">{{ (new \App\Models\ActiveOpportunity)->getActHistory(\App\Models\ActiveOpportunity::ACT_HISTORY_PRESENTATION) }}</option>
                                <option
                                    value="{{\App\Models\ActiveOpportunity::ACT_HISTORY_OTHER}}">{{ (new \App\Models\ActiveOpportunity)->getActHistory(\App\Models\ActiveOpportunity::ACT_HISTORY_OTHER) }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="" for="name">Reminder Date</label>
                                <div class="input-group">
                                    <input type="text" id="act_history_date_reminder" name="act_history_date_reminder"
                                           class="form-control date">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group act_history_other_name_reminder d-none">
                    <label class="" for="name">Act Reminder Other</label>
                    <input
                        class="form-control {{ $errors->has('act_history_other_name_reminder') ? 'is-invalid' : '' }}"
                        id="act_history_other_name_reminder"
                        name="act_history_other_name_reminder" value="{{ old('act_history_other_name_reminder', '') }}">
                </div>

                <div class="form-group">
                    <label class="" for="name">Act Order Reminder</label>
                    <textarea class="form-control {{ $errors->has('act_history_order_reminder') ? 'is-invalid' : '' }}"
                              id="act_history_order_reminder"
                              name="act_history_order_reminder">{{ old('act_history_order_reminder', '') }}</textarea>
                </div>

                <div class="form-group">
                    <label class="" for="name">Act Notes</label>
                    <textarea class="form-control {{ $errors->has('act_history_notes_reminder') ? 'is-invalid' : '' }}"
                              id="act_history_notes_reminder"
                              name="act_history_notes_reminder">{{ old('act_history_notes_reminder', '') }}</textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </div>

        </div>
    </form>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('#cari').select2({
                placeholder: 'Search Name Company...',
                minimumInputLength: 2,
                delayTime: 250,
                ajax: {
                    url: '{{url('admin/get-active-client')}}',
                    dataType: 'json',
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.name,
                                    id: item.id,
                                    itemData: item
                                }
                            })
                        }
                    },
                },
                cache: true
            }).on('select2:select', function (e) {
                var data = e.params.data
                $('#active_client_id').val(data.id)
                $('#contact_person_name').val(data.itemData.contact_person_name)
                $('#address_mailing_address').val(data.itemData.address_mailing_address)
                $('#number_of_students').val(data.itemData.number_of_students)
                $('#number_of_lecturers').val(data.itemData.number_of_lecturers)
                console.log(data)
            })

            $('#act_history_date').datetimepicker({
                format: 'LT',
                minDate: new Date()
            })
            $('#act_history_date_reminder').datetimepicker({
                format: 'LT',
                minDate: new Date()
            })
        })

        $('#act_history').on('change', function () {
            if(this.value == "{{ \App\Models\ActiveOpportunity::ACT_HISTORY_OTHER }}") {
                $('.act_history_other_name').removeClass('d-none')
            } else {
                $('.act_history_other_name').removeClass('d-none')
                $('.act_history_other_name').addClass('d-none')
            }
        })

        $('#act_history_reminder').on('change', function () {
            if(this.value == "{{ \App\Models\ActiveOpportunity::ACT_HISTORY_OTHER }}") {
                $('.act_history_other_name_reminder').removeClass('d-none')
            } else {
                $('.act_history_other_name_reminder').removeClass('d-none')
                $('.act_history_other_name_reminder').addClass('d-none')
            }
        })
    </script>
@endsection
