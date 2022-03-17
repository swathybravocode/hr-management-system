@extends('layouts.admin')
@section('page-title')
{{__('Edit Employee')}}
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        {{ Form::model($employee, array('route' => array('employee.update', $employee->id), 'method' => 'PUT' , 'enctype' => 'multipart/form-data')) }}
        @csrf
    </div>
</div>
<div class="row">
    <div class="col-md-6 ">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">{{__('Personal Detail')}}</h6>
            </div>
            <div class="card-body employee-detail-edit-body">
                <div class="row">
                    <div class="form-group col-md-4">
                        {!! Form::label('name', __('Name'),['class'=>'form-control-label']) !!}<span
                            class="text-danger pl-1">*</span>
                        {!! Form::text('name', null, ['class' => 'form-control','required' =>
                        'required',\Auth::user()->type != 'super admin'?"readonly":""]) !!}
                    </div>
                    <input type="hidden" name="user_id" value="{{$employee->user_id}}">
                    <div class="form-group col-md-4">
                        {!! Form::label('middle_name', __('Middle Name'),['class'=>'form-control-label']) !!}
                        {!! Form::text('middle_name', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group col-md-4">
                        {!! Form::label('last_name', __('Last Name'),['class'=>'form-control-label']) !!}<span
                            class="text-danger pl-1">*</span>
                        {!! Form::text('last_name', null, ['class' => 'form-control','required' =>
                        'required',\Auth::user()->type != 'super admin'?"readonly":""]) !!}
                    </div>
                    <div class="form-group col-md-6">
                        {!! Form::label('phone', __('Phone'),['class'=>'form-control-label']) !!}<span
                            class="text-danger pl-1">*</span>
                        {!! Form::number('phone',null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('dob', __('Date of Birth'),['class'=>'form-control-label']) !!}<span
                                class="text-danger pl-1">*</span>
                            {!! Form::text('dob', null, ['class' => 'form-control datepicker']) !!}
                        </div>
                    </div>
                    <div class="col-md-6 ">
                        <div class="form-group ">
                            {!! Form::label('gender', __('Gender'),['class'=>'form-control-label']) !!}<span
                                class="text-danger pl-1">*</span>
                            <div class="d-flex radio-check">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="g_male" value="Male" name="gender"
                                        class="custom-control-input" {{($employee->gender == 'Male')?'checked':''}}>
                                    <label class="custom-control-label" for="g_male">{{__('Male')}}</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="g_female" value="Female" name="gender"
                                        class="custom-control-input" {{($employee->gender == 'Female')?'checked':''}}>
                                    <label class="custom-control-label" for="g_female">{{__('Female')}}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        {!! Form::label('blood_group', __('Blood Group'),['class'=>'form-control-label']) !!}<span
                            class="text-danger pl-1">*</span>
                        {!! Form::text('blood_group', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group col-md-6">
                        {!! Form::label('employee_alternate_contact', __('Alternate Contact
                        Number'),['class'=>'form-control-label']) !!}<span class="text-danger pl-1">*</span>
                        {!! Form::number('employee_alternate_contact', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group col-md-6">
                        {!! Form::label('aadhaar_card_number', __('Aadhar Number'),['class'=>'form-control-label'])
                        !!}<span class="text-danger pl-1">*</span>
                        {!! Form::number('aadhaar_card_number', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('email', __('Email'),['class'=>'form-control-label']) !!}<span
                        class="text-danger pl-1">*</span>
                    {!! Form::text('email',null, ['class' => 'form-control',\Auth::user()->type != 'super
                    admin'?"readonly":""]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('address', __('Address'),['class'=>'form-control-label']) !!}<span
                        class="text-danger pl-1">*</span>
                    {!! Form::textarea('address',null, ['class' => 'form-control','rows'=>2]) !!}
                </div>
                <div class="form-group">
                    <div class="float-left col-4">
                        <label for="document" class="float-left pt-1 form-control-label">Photo <span
                                class="text-danger">*</span> </label>
                    </div>
                    <div class="float-right col-8">
                        <input type="hidden" name="emp_photo" id="" value="">
                        <div class="choose-file form-group">
                            <label for="document">
                                <div>{{__('Choose File')}}</div>
                                <input class="form-control border-0" name="employee_photo" type="file"
                                    id="employee_photo" data-filename="{{'_filename'}}">
                            </label>
                            <p class="{{'_filename'}}"></p>
                        </div>
                        @if(!empty($employee->employee_photo))
                        <br>
                        <span class="text-xs">
                            <a href="{{ (!empty($employee->employee_photo)?asset(Storage::url('uploads/avatar')).'/'.$employee->employee_photo:'') }}"
                                target="_blank">{{ (!empty($employee->employee_photo)?$employee->employee_photo:'') }}</a>
                        </span>
                        @endif
                    </div>
                </div>
                @if(\Auth::user()->type=='employee')
                {!! Form::submit('Update', ['class' => 'btn-create btn-xs badge-blue radius-10px float-right']) !!}
                @endif
            </div>
        </div>
    </div>
    @if(\Auth::user()->type!='employee')
    <div class="col-md-6 ">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">{{__('Company Detail')}}</h6>
            </div>
            <div class="card-body employee-detail-edit-body">
                <div class="row">
                    @csrf
                    <div class="form-group col-md-12">
                        {!! Form::label('employee_id', __('Employee ID'),['class'=>'form-control-label']) !!}
                        {!! Form::text('employee_id',$employeesId, ['class' => 'form-control','disabled'=>'disabled'])
                        !!}
                    </div>
                    <input type="hidden" name="user_id" value="{{$employee->user_id}}">
                    <div class="form-group col-md-6">
                        {{ Form::label('branch_id', __('Branch'),['class'=>'form-control-label']) }}
                        {{ Form::select('branch_id', $branches,null, array('class' => 'form-control select2','required'=>'required')) }}
                    </div>
                    <div class="form-group col-md-6">
                        {{ Form::label('department_id', __('Department'),['class'=>'form-control-label']) }}
                        {{ Form::select('department_id', $departments,null, array('class' => 'form-control select2','required'=>'required')) }}
                    </div>
                    <div class="form-group col-md-6">
                        {!! Form::label('old_employee_code', __('Old Employee Code'),['class'=>'form-control-label'])
                        !!}
                        {!! Form::text('old_employee_code', null, ['id'=>'old_employee_code', 'class' =>
                        'form-control',\Auth::user()->type != 'super admin'?"readonly":""]) !!}
                    </div>
                    <div class="form-group col-md-6">
                        {!! Form::label('employee_code', __('New Employee Code'),['class'=>'form-control-label']) !!}
                        {!! Form::text('employee_code', null, ['id'=>'employee_code', 'class' =>
                        'form-control',\Auth::user()->type != 'super admin'?"readonly":""]) !!}
                    </div>
                    <div class="form-group col-md-12">
                        {!! Form::label('head_quarter', __('Head Quarter'), ['class'=>'form-control-label']) !!}
                        {!! Form::text('head_quarter', null, ['id'=>'head_quarter', 'class' => 'form-control']) !!}
                    </div>
                    <div class="form-group col-md-6">
                        {{ Form::label('designation_id', __('Designation'),['class'=>'form-control-label']) }}
                        <select class="select2 form-control select2-multiple" id="designation_id" name="designation_id"
                            data-toggle="select2" data-placeholder="{{ __('Select Designation ...') }}">
                            <option value="">{{__('Select any Designation')}}</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        {!! Form::label('company_doj', 'Company Date Of Joining',['class'=>'form-control-label']) !!}
                        {!! Form::text('company_doj', null, ['class' => 'form-control datepicker','required' =>
                        'required']) !!}
                    </div>
                    <div class="form-group col-md-12">
                        {{ Form::label('role_id', __('Report to'),['class'=>'form-control-label']) }}
                        <select class="select2 form-control select2-multiple" id="report_to" name="report_to"
                            data-toggle="select2" data-placeholder="{{ __('Select Manager ...') }}">
                            <option value="">{{__('Select Manager')}}</option>
                            @foreach ($roles as $role_item)
                            <option value="{{$role_item->id}}" @if($employee->report_to == $role_item->id) selected
                                @endif>{{$role_item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="col-md-6 ">
        <div class="employee-detail-wrap ">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">{{__('Company Detail')}}</h6>
                </div>
                <div class="card-body employee-detail-edit-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info">
                                <strong>{{__('Branch')}}</strong>
                                <span>{{!empty($employee->branch)?$employee->branch->name:''}}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info font-style">
                                <strong>{{__('Department')}}</strong>
                                <span>{{!empty($employee->department)?$employee->department->name:''}}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info font-style">
                                <strong>{{__('Designation')}}</strong>
                                <span>{{!empty($employee->designation)?$employee->designation->name:''}}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info">
                                <strong>{{__('Date Of Joining')}}</strong>
                                <span>{{\Auth::user()->dateFormat($employee->company_doj)}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@if(\Auth::user()->type!='employee')
<div class="row">
    <div class="col-md-6 ">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">{{__('Document')}}</h6>
            </div>
            <div class="card-body employee-detail-edit-body">
                @foreach($documents as $key=>$document)
                @foreach($employeedocs as $employeedockey=>$employeedoc)
                <div class="row">
                    <div class="form-group col-md-8">
                        {!! Form::label($document->name, $document->name,['class'=>'form-control-label'])
                        !!} @if($document->is_required
                        == 1) <span class="text-danger">*</span> @endif
                        {!! Form::text('document['.$document->id.'][description]', $employeedoc['document_id'] ==
                        $document->id?$employeedoc['description']:'', ['id'=>'description', 'class'
                        =>
                        'form-control']) !!}
                    </div>
                    <div class="form-group col-md-4 mt-4 p-2">
                        <input type="hidden" name="emp_doc_id[{{ $document->id}}]" id="" value="{{$document->id}}">
                        <div class="choose-file form-group">
                            <label for="document[{{ $document->id }}]">
                                <div>{{__('Choose File')}}</div>
                                <input class="form-control  border-0 @error('document') is-invalid @enderror"
                                    name="document[{{$document->id}}][file]" type="file" id="document[{{ $document->id }}]
                                    data-filename=" {{ $document->id.'_filename'}}">
                            </label>
                            <p class="{{ $document->id.'_filename'}}"></p>
                        </div>
                    </div>
                    @if($employeedoc['document_id'] == $document->id && !empty($employeedoc['document_value']))
                    <div class="form-group col-md-12">
                        <span class="text-xs"><a
                                href="{{ asset(Storage::url('uploads/document')).'/'.$employeedoc['document_value'] }}"
                                target="_blank">{{ ($employeedoc['document_value']) }}</a>
                        </span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
            @endforeach
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">{{__('Bank Account Detail')}}</h6>
            </div>
            <div class="card-body employee-detail-edit-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        {!! Form::label('account_holder_name', __('Account Holder
                        Name'),['class'=>'form-control-label'])
                        !!}
                        {!! Form::text('account_holder_name', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group col-md-6">
                        {!! Form::label('account_number', __('Account Number'),['class'=>'form-control-label']) !!}
                        {!! Form::number('account_number', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group col-md-6">
                        {!! Form::label('bank_name', __('Bank Name'),['class'=>'form-control-label']) !!}
                        {!! Form::text('bank_name', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group col-md-6">
                        {!! Form::label('bank_identifier_code', __('Bank Identifier
                        Code'),['class'=>'form-control-label'])
                        !!}
                        {!! Form::text('bank_identifier_code',null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group col-md-6">
                        {!! Form::label('branch_location', __('Branch Location'),['class'=>'form-control-label']) !!}
                        {!! Form::text('branch_location',null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group col-md-6">
                        {!! Form::label('tax_payer_id', __('Tax Payer Id'),['class'=>'form-control-label']) !!}
                        {!! Form::text('tax_payer_id',null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group col-md-6">
                        {!! Form::label('pan_card_number', __('PAN Card Number'),['class'=>'form-control-label']) !!}
                        {!! Form::text('pan_card_number', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="row">
    <div class="col-md-6 ">
        <div class="employee-detail-wrap">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">{{__('Document Detail')}}</h6>
                </div>
                <div class="card-body employee-detail-edit-body">
                    <div class="row">
                        @php
                        $employeedoc = $employee->documents()->pluck('document_value',__('document_id'));
                        @endphp
                        @foreach($documents as $key=>$document)
                        <div class="col-md-12">
                            <div class="info">
                                <strong>{{$document->name }}</strong>
                                <span><a href="{{ (!empty($employeedoc['document_id'])?asset(Storage::url('uploads/document')).'/'.$employeedoc['document_id']:'') }}"
                                        target="_blank">{{ (!empty($employeedoc['document_id'])?$employeedoc['document_id']:'') }}</a></span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 ">
        <div class="employee-detail-wrap">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">{{__('Bank Account Detail')}}</h6>
                </div>
                <div class="card-body employee-detail-edit-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info">
                                <strong>{{__('Account Holder Name')}}</strong>
                                <span>{{$employee->account_holder_name}}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info font-style">
                                <strong>{{__('Account Number')}}</strong>
                                <span>{{$employee->account_number}}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info font-style">
                                <strong>{{__('Bank Name')}}</strong>
                                <span>{{$employee->bank_name}}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info">
                                <strong>{{__('Bank Identifier Code')}}</strong>
                                <span>{{$employee->bank_identifier_code}}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info">
                                <strong>{{__('Branch Location')}}</strong>
                                <span>{{$employee->branch_location}}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info">
                                <strong>{{__('Tax Payer Id')}}</strong>
                                <span>{{$employee->tax_payer_id}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@if(\Auth::user()->type != 'employee')
<div class="row">
    <div class="col-12">
        <input type="submit" value="{{__('Update')}}" class="btn-create btn-xs badge-blue radius-10px float-right">
    </div>
</div>
@endif
<div class="row">
    <div class="col-12">
        {!! Form::close() !!}
    </div>
</div>
@endsection

@push('script-page')
    <script type="text/javascript">
        function getDesignation(did) {
            $.ajax({
                url: '{{route('employee.json')}}',
                type: 'POST',
                data: {
                    "department_id": did, "_token": "{{ csrf_token() }}",
                },
                success: function (data) {
                    $('#designation_id').empty();
                    $('#designation_id').append('<option value="">Select any Designation</option>');
                    $.each(data, function (key, value) {
                        var select = '';
                        if (key == '{{ $employee->designation_id }}') {
                            select = 'selected';
                        }
                        $('#designation_id').append('<option value="' + key + '"  ' + select + '>' + value + '</option>');
                    });
                }
            });
        }
        $(document).ready(function () {
            var d_id = $('#department_id').val();
            var designation_id = '{{ $employee->designation_id }}';
            getDesignation(d_id);
        });
        $(document).on('change', 'select[name=department_id]', function () {
            var department_id = $(this).val();
            getDesignation(department_id);
        });
        $(document).on('change', 'select[name=branch_id]', function () {
            var branch_id = $(this).val();
            var employee_nuber = "{{$employee_number}}";
            $.ajax({
                url: '{{route('branchcode.get')}}',
                type: 'POST',
                data: {
                    "branch_id": branch_id, "_token": "{{ csrf_token() }}",
                },
                success: function (data) {
                    var d = JSON.parse(data);
                    $("#old_employee_code").val(d.old_code);
                    $("#employee_code").val(d.new_code);
                }
            });
        });
    </script>
@endpush