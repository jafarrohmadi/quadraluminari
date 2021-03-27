@extends('layouts.admin')
@section('content')
    <h3>{{ trans('global.create') }} Active Client</h3>
    <br>
    <form method="POST" action="{{ route("admin.active-client.store") }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Primary Information
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <label class="required" for="name">Company Name</label>
                            <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text"
                                   name="name"
                                   id="name" value="{{ old('name', '') }}" required>
                            @if($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="" for="name">Npwp</label>
                            <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text"
                                   name="npwp" id="npwp" value="{{ old('npwp', '') }}">
                            @if($errors->has('npwp'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('npwp') }}
                                </div>
                            @endif
                        </div>
                        <input type="hidden" name="status" value="{{\App\Models\ActiveClient::Status_Non_Active}}">
                        {{--                        <div class="form-group">--}}
                        {{--                            <label class="required" for="name">Status</label>--}}
                        {{--                            <select class="form-control" name="status" id="status">--}}
                        {{--                                <option--}}
                        {{--                                    value="{{\App\Models\ActiveClient::Status_Active}}"> {{ (new \App\Models\ActiveClient)->getStatus(\App\Models\ActiveClient::Status_Active) }}</option>--}}
                        {{--                                <option--}}
                        {{--                                    value="{{\App\Models\ActiveClient::Status_Non_Active}}"> {{ (new \App\Models\ActiveClient)->getStatus(\App\Models\ActiveClient::Status_Non_Active) }}</option>--}}
                        {{--                            </select>--}}
                        {{--                            @if($errors->has('status'))--}}
                        {{--                                <div class="invalid-feedback">--}}
                        {{--                                    {{ $errors->first('status') }}--}}
                        {{--                                </div>--}}
                        {{--                            @endif--}}
                        {{--                        </div>--}}
                        <div class="form-group">
                            <label class="" for="name">Number Of Students</label>
                            <input class="form-control {{ $errors->has('number_of_students') ? 'is-invalid' : '' }}"
                                   type="text" name="number_of_students"
                                   id="number_of_students" value="{{ old('number_of_students', '') }}">
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
                                   id="number_of_lecturers" value="{{ old('number_of_lecturers', '') }}">
                            @if($errors->has('number_of_lecturers'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('number_of_lecturers') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="" for="name">Company Phone Number</label>
                            <input class="form-control {{ $errors->has('phone_number') ? 'is-invalid' : '' }}" type="text"
                                   name="phone_number" id="phone_number" value="{{ old('phone_number', '') }}">
                            @if($errors->has('phone_number'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('phone_number') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="" for="name">Remark</label>
                            <textarea class="form-control {{ $errors->has('remark') ? 'is-invalid' : '' }}"
                                      name="remark">{{ old('remark', '') }}</textarea>
                            @if($errors->has('remark'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('remark') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="name" class="">Province</label>

                            <select name="address_province_id" id="select-province2"
                                    class="select2 form-control select-province">
                                <option value="">Select Province</option>
                                @foreach($province as $provinces)
                                    <option value="{{$provinces->id}}"> {{ $provinces->name }}</option>
                                @endforeach
                            </select>

                        </div><!--form-group-->

                        <div class="control-group form-group">
                            <label for="name" class="">City</label>

                            <select name="address_city_id" id="select-city2" class="select2 form-control city_id ">
                            </select>
                        </div><!--form-group-->

                        <div class="form-group">
                            <label class="" for="name">Postal Code</label>
                            <input class="form-control {{ $errors->has('address_postal_code') ? 'is-invalid' : '' }}"
                                   type="text" name="address_postal_code"
                                   id="address_postal_code" value="{{ old('address_postal_code', '') }}">
                            @if($errors->has('address_postal_code'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('address_postal_code') }}
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label class="" for="name">Mailing Address</label>
                            <textarea
                                class="form-control {{ $errors->has('address_mailing_address') ? 'is-invalid' : '' }}"
                                name="address_mailing_address"
                                id="address_mailing_address">{{ old('address_mailing_address', '') }}</textarea>
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
                        {{--                           id="address_country" value="{{ old('address_country', '') }}">--}}
                        {{--                    @if($errors->has('address_country'))--}}
                        {{--                        <div class="invalid-feedback">--}}
                        {{--                            {{ $errors->first('address_country') }}--}}
                        {{--                        </div>--}}
                        {{--                    @endif--}}
                        {{--                </div>--}}


                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <span class="contactPerson">
                <div class="card ">
                    <div class="card-header">
                        Contact Person
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="" for="name">Company Person Name</label>
                            <input class="form-control {{ $errors->has('contact_person_name[0]') ? 'is-invalid' : '' }}"
                                   type="text" name="contact_person_name[0]"
                                   id="contact_person_name[0]" value="{{ old('contact_person_name[0]', '') }}">
                            @if($errors->has('contact_person_name[0]'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('contact_person_name[0]') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="" for="name">Jabatan</label>
                            <input
                                class="form-control {{ $errors->has('contact_person_grade[0]') ? 'is-invalid' : '' }}"
                                type="text" name="contact_person_grade[0]"
                                id="contact_person_grade[0]" value="{{ old('contact_person_grade[0]', '') }}">
                            @if($errors->has('contact_person_grade[0]'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('contact_person_grade[0]') }}
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label class="" for="name">Phone</label>
                            <input
                                class="form-control {{ $errors->has('contact_person_phone[0]') ? 'is-invalid' : '' }}"
                                type="text" name="contact_person_phone[0]"
                                id="contact_person_phone[0]" value="{{ old('contact_person_phone[0]', '') }}">
                            @if($errors->has('contact_person_phone[0]'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('contact_person_phone[0]') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="" for="name">Mobile Phone</label>
                            <input
                                class="form-control {{ $errors->has('contact_person_mobile_phone[0]') ? 'is-invalid' : '' }}"
                                type="text" name="contact_person_mobile_phone[0]"
                                id="contact_person_mobile_phone[0]"
                                value="{{ old('contact_person_mobile_phone[0]', '') }}">
                            @if($errors->has('contact_person_mobile_phone[0]'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('contact_person_mobile_phone[0]') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="" for="name">Email</label>
                            <input
                                class="form-control {{ $errors->has('contact_person_mobile_email[0]') ? 'is-invalid' : '' }}"
                                type="text" name="contact_person_mobile_email[0]"
                                id="contact_person_mobile_email[0]"
                                value="{{ old('contact_person_mobile_email[0]', '') }}">
                            gunakan tanda ; jika email lebih dari 1<br> example: abc@abc.com;cde@cde.com;def@def.com
                            @if($errors->has('contact_person_mobile_email[0]'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('contact_person_mobile_email[0]') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                    </span>
                <span class="contactPersonData"></span>
                <div class="form-group">
                    <button class="btn btn-info" type="button" id="addContactPerson">
                        Add Data Contact Person
                    </button>
                </div>

            </div>
        </div>

        <div class="form-group">
            <button class="btn btn-danger" type="submit">
                {{ trans('global.save') }}
            </button>
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

        var i = 1

        $('#addContactPerson').click(function (e) {
            console.log('er')
            var newaddress = $('span.contactPerson').eq(0).clone()
            newaddress.find("input").val("");
            newaddress.find('input').each(function () {
                this.name = this.name.replace('[0]', '[' + i + ']')
                this.id   = this.id.replace('[0]', '[' + i + ']')
            })
            i++

            $('.contactPersonData').append(newaddress)
        })
    </script>
@endsection
