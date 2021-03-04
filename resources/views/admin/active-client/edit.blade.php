@extends('layouts.admin')
@section('content')
    <h3>{{ trans('global.create') }} Active Client</h3>
    <br>
    <form method="POST" action="{{ route("admin.active-client.update", [$activeClient->id]) }}"
          enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Primary Information
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <label class="required" for="name">Company Name</label>
                            <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text"
                                   name="name"
                                   id="name" value="{{ old('name', $activeClient->name) }}" required>
                            @if($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="required" for="name">Status</label>
                            <select class="form-control" name="status" id="status">
                                <option value="{{\App\Models\ActiveClient::Status_Active}}"
                                        @if($activeClient->status == \App\Models\ActiveClient::Status_Active) selected @endif> {{ (new \App\Models\ActiveClient)->getStatus(\App\Models\ActiveClient::Status_Active) }}</option>
                                <option
                                    value="{{\App\Models\ActiveClient::Status_Non_Active}}"
                                    @if($activeClient->status == \App\Models\ActiveClient::Status_Non_Active) selected @endif> {{ (new \App\Models\ActiveClient)->getStatus(\App\Models\ActiveClient::Status_Non_Active) }}</option>
                            </select>
                            @if($errors->has('status'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('status') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="" for="name">Number Of Students</label>
                            <input class="form-control {{ $errors->has('number_of_students') ? 'is-invalid' : '' }}"
                                   type="text" name="number_of_students"
                                   id="number_of_students"
                                   value="{{ old('number_of_students', $activeClient->number_of_students) }}">
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
                                   id="number_of_lecturers" value="{{ old('number_of_lecturers', $activeClient->number_of_lecturers) }}">
                            @if($errors->has('number_of_lecturers'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('number_of_lecturers') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="" for="name">Remark</label>
                            <textarea class="form-control {{ $errors->has('remark') ? 'is-invalid' : '' }}"
                                      name="remark">{{ old('remark', $activeClient->remark) }}</textarea>
                            @if($errors->has('remark'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('remark') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Contact Person
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="" for="name">Company Person Name</label>
                            <input class="form-control {{ $errors->has('contact_person_name') ? 'is-invalid' : '' }}"
                                   type="text" name="contact_person_name"
                                   id="contact_person_name" value="{{ old('contact_person_name', $activeClient->contact_person_name) }}">
                            @if($errors->has('contact_person_name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('contact_person_name') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="" for="name">Jabatan</label>
                            <input class="form-control {{ $errors->has('contact_person_grade') ? 'is-invalid' : '' }}"
                                   type="text" name="contact_person_grade"
                                   id="contact_person_grade" value="{{ old('contact_person_grade', $activeClient->contact_person_grade) }}">
                            @if($errors->has('contact_person_grade'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('contact_person_grade') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="name" class="">Province</label>
                            <select name="contact_person_province_id" id="select-province"
                                    class="select2 form-control select-province">
                                <option value="">Select Province</option>
                                @foreach($province as $provinces)
                                    <option value="{{$provinces->id}}" @if($activeClient->contact_person_province_id == $provinces->id) selected @endif> {{ $provinces->name }}</option>
                                @endforeach
                            </select>

                        </div><!--form-group-->

                        <div class="control-group form-group">
                            <label for="name" class="">City</label>

                            <select name="contact_person_city_id" id="select-city" class="select2 form-control city_id">
                                <option value="">Select City</option>
                                @foreach($cityContactPerson as $city)
                                    <option value="{{$city->id}}" @if($activeClient->contact_person_city_id == $city->id) selected @endif> {{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div><!--form-group-->

                        <div class="form-group">
                            <label class="" for="name">Address</label>
                            <textarea
                                class="form-control {{ $errors->has('contact_person_address') ? 'is-invalid' : '' }}"
                                name="contact_person_address">{{ old('contact_person_address', $activeClient->contact_person_address) }}</textarea>

                            @if($errors->has('contact_person_address'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('contact_person_address') }}
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label class="" for="name">Phone</label>
                            <input class="form-control {{ $errors->has('contact_person_phone') ? 'is-invalid' : '' }}"
                                   type="text" name="contact_person_phone"
                                   id="contact_person_phone" value="{{ old('contact_person_phone', $activeClient->contact_person_phone) }}">
                            @if($errors->has('contact_person_phone'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('contact_person_phone') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="" for="name">Mobile Phone</label>
                            <input
                                class="form-control {{ $errors->has('contact_person_mobile_phone') ? 'is-invalid' : '' }}"
                                type="text" name="contact_person_mobile_phone"
                                id="contact_person_mobile_phone" value="{{ old('contact_person_mobile_phone', $activeClient->contact_person_mobile_phone) }}">
                            @if($errors->has('contact_person_mobile_phone'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('contact_person_mobile_phone') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="" for="name">Email</label>
                            <input
                                class="form-control {{ $errors->has('contact_person_mobile_email') ? 'is-invalid' : '' }}"
                                type="text" name="contact_person_mobile_email"
                                id="contact_person_mobile_email" value="{{ old('contact_person_mobile_email', $activeClient->contact_person_mobile_email) }}">
                            gunakan tanda ; jika email lebih dari 1<br> example: abc@abc.com;cde@cde.com;def@def.com
                            @if($errors->has('contact_person_mobile_email'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('contact_person_mobile_email') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                Addresses
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="" for="name">Mailing Address</label>
                    <textarea class="form-control {{ $errors->has('address_mailing_address') ? 'is-invalid' : '' }}"
                              name="address_mailing_address"
                              id="address_mailing_address">{{ old('address_mailing_address', $activeClient->address_mailing_address) }}</textarea>
                    @if($errors->has('address_mailing_address'))
                        <div class="invalid-feedback">
                            {{ $errors->first('address_mailing_address') }}
                        </div>
                    @endif
                </div>

{{--                <div class="form-group">--}}
{{--                    <label class="" for="name">Country</label>--}}
{{--                    <input class="form-control {{ $errors->has('address_country') ? 'is-invalid' : '' }}"--}}
{{--                           type="text" name="address_country"--}}
{{--                           id="address_country" value="{{ old('address_country', $activeClient->address_country) }}">--}}
{{--                    @if($errors->has('address_country'))--}}
{{--                        <div class="invalid-feedback">--}}
{{--                            {{ $errors->first('address_country') }}--}}
{{--                        </div>--}}
{{--                    @endif--}}
{{--                </div>--}}

                <div class="form-group">
                    <label for="name" class="">Province</label>

                    <select name="address_province_id" id="select-province2"
                            class="select2 form-control select-province">
                        <option value="">Select Province</option>
                        @foreach($province as $provinces)
                            <option value="{{$provinces->id}}" @if( $activeClient->address_province_id == $provinces->id ) selected @endif> {{ $provinces->name }}</option>
                        @endforeach
                    </select>

                </div><!--form-group-->

                <div class="control-group form-group">
                    <label for="name" class="">City</label>
                    <select name="address_city_id" id="select-city2" class="select2 form-control city_id ">
                        <option value="">Select City</option>
                        @foreach($cityAddress as $city)
                            <option value="{{$city->id}}" @if($activeClient->address_city_id == $city->id) selected @endif> {{ $city->name }}</option>
                        @endforeach
                    </select>
                </div><!--form-group-->

                <div class="form-group">
                    <label class="" for="name">Postal Code</label>
                    <input class="form-control {{ $errors->has('address_postal_code') ? 'is-invalid' : '' }}"
                           type="text" name="address_postal_code"
                           id="address_postal_code" value="{{ old('address_postal_code', $activeClient->address_postal_code) }}">
                    @if($errors->has('address_postal_code'))
                        <div class="invalid-feedback">
                            {{ $errors->first('address_postal_code') }}
                        </div>
                    @endif
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
        $('#select-province').change(function () {
            var host = "{{ url('admin/getCityByProvinceId') }}"

            $('#select-city').html('')
            $('#select-city').append('<option>Select City</option>')
            $.getJSON(host + '/' + $('#select-province option:selected').val(), function (data) {
                var temp = []
                $.each(data, function (key, value) {
                    temp.push({ v: value, k: key })
                })

                temp.sort(function (a, b) {
                    if(a.v > b.v) { return 1}
                    if(a.v < b.v) { return -1}
                    return 0
                })

                $.each(temp, function (key, obj) {
                    $('#select-city').append('<option value="' + obj.k + '">' + obj.v + '</option>')
                })
            })
        })
        $('#select-province2').change(function () {
            var host = "{{ url('admin/getCityByProvinceId') }}"

            $('#select-city2').html('')
            $('#select-cit2y').append('<option>Select City</option>')
            $.getJSON(host + '/' + $('#select-province2 option:selected').val(), function (data) {
                var temp = []
                $.each(data, function (key, value) {
                    temp.push({ v: value, k: key })
                })

                temp.sort(function (a, b) {
                    if(a.v > b.v) { return 1}
                    if(a.v < b.v) { return -1}
                    return 0
                })

                $.each(temp, function (key, obj) {
                    $('#select-city2').append('<option value="' + obj.k + '">' + obj.v + '</option>')
                })
            })
        })
    </script>
@endsection
