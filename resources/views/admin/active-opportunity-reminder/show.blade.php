@extends('layouts.admin')
@section('content')
    <h3>{{ trans('global.show') }} Active Client</h3>

    <div class="form-group">
        <a class="btn btn-default" href="{{ route('admin.active-opportunity-reminder.index') }}">
            {{ trans('global.back_to_list') }}
        </a>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Active Client
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <table class="table table-bordered table-striped">
                            <tbody>
                            <tr>
                                <th>
                                    {{ trans('cruds.user.fields.id') }}
                                </th>
                                <td>
                                    {{ $activeOpportunity->id }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Company Name
                                </th>
                                <td>
                                    {{ $activeOpportunity->activeClientData->name ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Company Person Name
                                </th>
                                <td>
                                    {{ $activeOpportunity->activeClientData->contact_person_name ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Mailing Address
                                </th>
                                <td>
                                    {!!  $activeOpportunity->activeClientData->address_mailing_address ?? '' !!}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Number Of Students
                                </th>
                                <td>
                                    {{  $activeOpportunity->activeClientData->number_of_students ?? ''}}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Number Of Lectures
                                </th>
                                <td>
                                    {{ $activeOpportunity->activeClientData->number_of_lecturers ?? ''}}
                                </td>
                            </tr>
                            </tbody>
                        </table>
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
                        <table class="table table-bordered table-striped">
                            <tbody>
                            <tr>
                                <th>
                                    PROJECT
                                </th>
                                <td>
                                    {{ $activeOpportunity->project ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    PIC
                                </th>
                                <td>
                                    {{  $activeOpportunity->userData->name ?? ''}}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Value
                                </th>
                                <td>
                                    {{(new \App\Models\ActiveOpportunity)->getCurrency($activeOpportunity->value_currency)}} {{ $activeOpportunity->value ?? ''}}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Act History
                                </th>
                                <td>
                                    {{$activeOpportunity->act_history != \App\Models\ActiveOpportunity::ACT_HISTORY_OTHER ? (new \App\Models\ActiveOpportunity)->getActHistory($activeOpportunity->act_history) : $activeOpportunity->act_history_other_name }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Act History Date
                                </th>
                                <td>
                                    {{ $activeOpportunity->act_history_date}}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Act History Other
                                </th>
                                <td>
                                    {{ $activeOpportunity->act_history_other_name }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Act History Remarks
                                </th>
                                <td>
                                    {{ $activeOpportunity->act_history_remarks }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Opportunity Status
                                </th>
                                <td>
                                    {{ $activeOpportunity->opportunity_status }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Opportunity Status Remarks
                                </th>
                                <td>
                                    {{ $activeOpportunity->opportunity_status_remarks }}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <span class="contactPerson">
        @foreach($activeOpportunity->projectDetailData as $key => $projectDetails)
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            Detail Project
                        </div>

                        <div class="text-right col-md-6"> <a
                                href="{{url("admin/detail-project-history/$projectDetails->id")}}"
                                class="btn btn-info"
                                target="_blank"> History</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <table class="table table-bordered table-striped">
                            <tbody>
                            <tr>
                                <th>
                                    Produk
                                </th>
                                <td>
                                    {{ $projectDetails->detail_name ?? '' }}
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    Qty
                                </th>
                                <td>
                                    {{  $projectDetails->detail_qty ?? ''}}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Total
                                </th>
                                <td>

                                    {{  $projectDetails->detail_value ?? ''}}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Notes
                                </th>
                                <td>

                                    {{  $projectDetails->detail_notes ?? ''}}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    </span>
    
    @include('admin.active-opportunity-history.index')

    <a class="btn btn-default" href="{{ route('admin.active-opportunity-reminder.index') }}">
        {{ trans('global.back_to_list') }}
    </a>

@endsection
