@can($viewGate)
    <a class="btn btn-xs btn-primary" href="{{ route('admin.' . $crudRoutePart . '.show', $row->id) }}">
        {{ trans('global.view') }}
    </a>
@endcan
@can($editGate)
    <a class="btn btn-xs btn-info " data-toggle="modal" data-target="#exampleModal{{ $row->id }}">
        {{ trans('global.edit') }}
    </a>
@endcan
@can($deleteGate)
    <form action="{{ route('admin.' . $crudRoutePart . '.destroy', $row->id) }}" method="POST"
          onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
    </form>
@endcan


<!-- Modal -->
<div class="modal fade" id="exampleModal{{ $row->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Active Opportunity History</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST"
                  action="{{ route("admin.active-opportunity-history.update", [$row->id]) }}"
                  enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="required" for="name">Product Name</label>
                        <input class="form-control {{ $errors->has('product_name') ? 'is-invalid' : '' }}"
                               type="text" name="product_name"
                               id="product_name" value="{{ old('product_name', $row->product_name) }}"
                               disabled>
                        @if($errors->has('product_name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('product_name') }}
                            </div>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="required" for="name">Act History</label>
                                <select
                                    class="form-control select2 {{ $errors->has('act_history') ? 'is-invalid' : '' }}"
                                    name="act_history" id="act_history{{$row->id}}">
                                    <option
                                        value="{{\App\Models\ActiveOpportunity::ACT_HISTORY_CALL}}"
                                        @if($row->act_history == \App\Models\ActiveOpportunity::ACT_HISTORY_CALL) selected @endif >{{ (new \App\Models\ActiveOpportunity)->getActHistory(\App\Models\ActiveOpportunity::ACT_HISTORY_CALL) }}</option>
                                    <option
                                        value="{{\App\Models\ActiveOpportunity::ACT_HISTORY_EMAIL}}"
                                        @if($row->act_history == \App\Models\ActiveOpportunity::ACT_HISTORY_EMAIL) selected @endif >{{ (new \App\Models\ActiveOpportunity)->getActHistory(\App\Models\ActiveOpportunity::ACT_HISTORY_EMAIL) }}</option>
                                    <option
                                        value="{{\App\Models\ActiveOpportunity::ACT_HISTORY_MEETING}}"
                                        @if($row->act_history == \App\Models\ActiveOpportunity::ACT_HISTORY_MEETING) selected @endif >{{ (new \App\Models\ActiveOpportunity)->getActHistory(\App\Models\ActiveOpportunity::ACT_HISTORY_MEETING) }}</option>
                                    <option
                                        value="{{\App\Models\ActiveOpportunity::ACT_HISTORY_PRESENTATION}}"
                                        @if($row->act_history == \App\Models\ActiveOpportunity::ACT_HISTORY_PRESENTATION) selected @endif >{{ (new \App\Models\ActiveOpportunity)->getActHistory(\App\Models\ActiveOpportunity::ACT_HISTORY_PRESENTATION) }}</option>
                                    <option
                                        value="{{\App\Models\ActiveOpportunity::ACT_HISTORY_OTHER}}"
                                        @if($row->act_history == \App\Models\ActiveOpportunity::ACT_HISTORY_OTHER) selected @endif >{{ (new \App\Models\ActiveOpportunity)->getActHistory(\App\Models\ActiveOpportunity::ACT_HISTORY_OTHER) }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label class="" for="name">Act History Date</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control date act_history_date" id="act_history_date{{$row->id}}"
                                               name="act_history_date"
                                               value="{{ old('$row', $row->act_history_date) }}" disabled>
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="form-group act_history_other_name{{$row->id}} @if($row->act_history != \App\Models\ActiveOpportunity::ACT_HISTORY_OTHER) d-none @endif ">
                        <label class="" for="name">Act History Other</label>
                        <input class="form-control {{ $errors->has('act_history_other_name') ? 'is-invalid' : '' }}"
                               id="act_history_other_name"
                               name="act_history_other_name"
                               value="{{ old('act_history_other_name', $row->act_history_other_name) }}">
                    </div>
                    <div class="form-group">
                        <label class="" for="name">Act History Remarks</label>
                        <textarea class="form-control {{ $errors->has('act_history_remarks') ? 'is-invalid' : '' }}"
                                  id="act_history_remarks"
                                  name="act_history_remarks">{!!  old('act_history_remarks', $row->act_history_remarks)  !!}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="" for="name">Opportunity Status</label>
                        <input class="form-control {{ $errors->has('opportunity_status') ? 'is-invalid' : '' }}"
                               id="opportunity_status"
                               name="opportunity_status"
                               value="{{ old('opportunity_status', $row->opportunity_status) }}">
                    </div>

                    <div class="form-group">
                        <label class="" for="name">Opportunity Status Remarks</label>
                        <textarea
                            class="form-control {{ $errors->has('opportunity_status_remarks') ? 'is-invalid' : '' }}"
                            id="opportunity_status_remarks"
                            name="opportunity_status_remarks">{!! old('opportunity_status_remarks', $row->opportunity_status_remarks) !!}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>

    $('#act_history{{$row->id}}').on('change', function () {
        if(this.value == "{{ \App\Models\ActiveOpportunity::ACT_HISTORY_OTHER }}") {
            $('.act_history_other_name{{$row->id}}').removeClass('d-none')
        } else {
            $('.act_history_other_name{{$row->id}}').removeClass('d-none')
            $('.act_history_other_name{{$row->id}}').addClass('d-none')
        }
    })
</script>
