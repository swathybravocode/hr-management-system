@extends('layouts.admin')
@section('page-title')
    {{__('Create Employee')}}
@endsection
@section('content')
    <div class="row">
        <form method="post" action="{{route('employee.store')}}" enctype="multipart/form-data">
        @csrf
    </div>
    <div class="row">
        <div class="col-md-6 ">
            <div class="card ">
                <div class="card-header"><h6 class="mb-0">{{__('Personal Detail')}}</h6></div>
                <div class="card-body ">
                    <div class="row">
                        <div class="form-group col-md-4">
                            {!! Form::label('name', __('First Name'),['class'=>'form-control-label']) !!}<span class="text-danger pl-1">*</span>
                            {!! Form::text('name', old('name'), ['class' => 'form-control','required' => 'required']) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! Form::label('middle_name', __('Middle Name'),['class'=>'form-control-label']) !!}
                            {!! Form::text('middle_name', old('middle_name'), ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! Form::label('last_name', __('Last Name'),['class'=>'form-control-label']) !!}<span class="text-danger pl-1">*</span>
                            {!! Form::text('last_name', old('last_name'), ['class' => 'form-control','required' => 'required']) !!}
                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('phone', __('Phone'),['class'=>'form-control-label']) !!}<span class="text-danger pl-1">*</span>
                            {!! Form::number('phone',old('phone'), ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('dob', __('Date of Birth'),['class'=>'form-control-label']) !!}<span class="text-danger pl-1">*</span>
                                {!! Form::text('dob', old('dob'), ['class' => 'form-control', 'id'=> 'date_picker']) !!}
                            </div>
                        </div>



                        <div class="col-md-6 ">
                            <div class="form-group ">
                                {!! Form::label('gender', __('Gender'),['class'=>'form-control-label']) !!}<span class="text-danger pl-1">*</span>
                                <div class="d-flex radio-check">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="g_male" value="Male" name="gender" class="custom-control-input">
                                        <label class="custom-control-label" for="g_male">{{__('Male')}}</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="g_female" value="Female" name="gender" class="custom-control-input">
                                        <label class="custom-control-label" for="g_female">{{__('Female')}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('blood_group', __('Blood Group'),['class'=>'form-control-label']) !!}<span class="text-danger pl-1">*</span>
                            {!! Form::text('blood_group',old('blood_group'), ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('employee_alternate_contact', __('Alternate Contact Number'),['class'=>'form-control-label']) !!}<span class="text-danger pl-1">*</span>
                            {!! Form::number('employee_alternate_contact',old('employee_alternate_contact'), ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('aadhaar_card_number', __('Aadhar Number'),['class'=>'form-control-label']) !!}<span class="text-danger pl-1">*</span>
                            {!! Form::number('aadhaar_card_number',old('aadhaar_card_number'), ['class' => 'form-control']) !!}
                        </div>

                        <div class="form-group col-md-6">
                            {!! Form::label('email', __('Email'),['class'=>'form-control-label']) !!}<span class="text-danger pl-1">*</span>
                            {!! Form::email('email',old('email'), ['class' => 'form-control','required' => 'required']) !!}
                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('password', __('Password'),['class'=>'form-control-label']) !!}<span class="text-danger pl-1">*</span>
                            {!! Form::password('password', ['class' => 'form-control','required' => 'required']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('address', __('Address'),['class'=>'form-control-label']) !!}<span class="text-danger pl-1">*</span>
                        {!! Form::textarea('address',old('address'), ['class' => 'form-control','rows'=>2]) !!}
                    </div>
                    <div class="form-group">
                        <div class="float-left col-4">
                            <label for="document" class="float-left pt-1 form-control-label">Photo <span class="text-danger">*</span> </label>
                        </div>
                        <div class="float-right col-8">
                            <input type="hidden" name="emp_photo" id="" value="">
                            <div class="choose-file form-group">
                                <label for="document">
                                    <div>{{__('Choose File')}}</div>
                                    <input class="form-control border-0"  required name="employee_photo" type="file" id="employee_photo" data-filename="{{'_filename'}}">
                                </label>
                                <p class="{{'_filename'}}"></p>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 ">
            <div class="card">
                <div class="card-header"><h6 class="mb-0">{{__('Company Detail')}}</h6></div>
                <div class="card-body employee-detail-create-body">
                    <div class="row">
                        @csrf

                        <div class="form-group col-md-12">
                            {!! Form::label('employee_id', __('Employee ID'),['class'=>'form-control-label']) !!}
                            {!! Form::text('employee_id', $employeesId, ['class' => 'form-control','disabled'=>'disabled']) !!}
                        </div>

                        <div class="form-group col-md-6">
                            {{ Form::label('branch_id', __('Branch'),['class'=>'form-control-label']) }}
                            {{ Form::select('branch_id', $branches, null, array('class' => 'form-control  select2','required'=>'required')) }}

                        </div>

                        <div class="form-group col-md-6">
                            {{ Form::label('department_id', __('Department'),['class'=>'form-control-label']) }}
                            {{ Form::select('department_id', $departments,null, array('class' => 'form-control  select2','id'=>'department_id','required'=>'required')) }}
                        </div>


                        <div class="form-group col-md-6">
                            {!! Form::label('old_employee_code', __('Old Employee Code'),['class'=>'form-control-label']) !!}
                            {!! Form::text('old_employee_code', "", ['id'=>'old_employee_code', 'class' => 'form-control']) !!}
                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('employee_code', __('New Employee Code'),['class'=>'form-control-label']) !!}
                            {!! Form::text('employee_code', "", ['id'=>'employee_code', 'class' => 'form-control']) !!}
                        </div>
                        <div class="form-group col-md-12">
                            {!! Form::label('head_quarter', __('Head Quarter'), ['class'=>'form-control-label']) !!}
                            {!! Form::text('head_quarter', "", ['id'=>'head_quarter', 'class' => 'form-control']) !!}
                        </div>

                        <div class="form-group col-md-6">
                            {{ Form::label('designation_id', __('Designation'),['class'=>'form-control-label']) }}
                            <select class="select2 form-control select2-multiple" id="designation_id" name="designation_id" data-toggle="select2" data-placeholder="{{ __('Select Designation ...') }}">
                                <option value="">{{__('Select any Designation')}}</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6 ">
                            {!! Form::label('company_doj', __('Company Date Of Joining'),['class'=>'form-control-label']) !!}
                            {!! Form::text('company_doj', null, ['class' => 'form-control datepicker','required' => 'required']) !!}
                        </div>
                        <div class="form-group col-md-12">
                            {{ Form::label('role_id', __('Report to'),['class'=>'form-control-label']) }}
                            <select class="select2 form-control select2-multiple" id="report_to" name="report_to" data-toggle="select2" data-placeholder="{{ __('Select Manager ...') }}">
                                <option value="">{{__('Select Manager')}}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 ">
            <div class="card">
                <div class="card-header"><h6 class="mb-0">{{__('Document')}}</h6></div>
                <div class="card-body employee-detail-create-body">
                    @foreach($documents as $key=>$document)
                        <div class="row">
                            <div class="form-group col-12">
                                <div class="float-left col-4">
                                    <label for="document" class="float-left pt-1 form-control-label">{{ $document->name }} @if($document->is_required == 1) <span class="text-danger">*</span> @endif</label>
                                </div>
                                <div class="float-right col-8">
                                    <input type="hidden" name="emp_doc_id[{{ $document->id}}]" id="" value="{{$document->id}}">
                                    <div class="choose-file form-group">
                                        <label for="document[{{ $document->id }}]">
                                            <div>{{__('Choose File')}}</div>
                                            <input class="form-control  @error('document') is-invalid @enderror border-0" @if($document->is_required == 1) required @endif name="document[{{ $document->id}}]" type="file" id="document[{{ $document->id }}]" data-filename="{{ $document->id.'_filename'}}">
                                        </label>
                                        <p class="{{ $document->id.'_filename'}}"></p>
                                    </div>

                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-6 ">
            <div class="card">
                <div class="card-header"><h6 class="mb-0">{{__('Bank Account Detail')}}</h6></div>
                <div class="card-body employee-detail-create-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            {!! Form::label('account_holder_name', __('Account Holder Name'),['class'=>'form-control-label']) !!}
                            {!! Form::text('account_holder_name', old('account_holder_name'), ['class' => 'form-control']) !!}

                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('account_number', __('Account Number'),['class'=>'form-control-label']) !!}
                            {!! Form::number('account_number', old('account_number'), ['class' => 'form-control']) !!}

                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('bank_name', __('Bank Name'),['class'=>'form-control-label']) !!}
                            {!! Form::text('bank_name', old('bank_name'), ['class' => 'form-control']) !!}

                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('bank_identifier_code', __('Bank Identifier Code'),['class'=>'form-control-label']) !!}
                            {!! Form::text('bank_identifier_code',old('bank_identifier_code'), ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('branch_location', __('Branch Location'),['class'=>'form-control-label']) !!}
                            {!! Form::text('branch_location',old('branch_location'), ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('tax_payer_id', __('Tax Payer Id'),['class'=>'form-control-label']) !!}
                            {!! Form::text('tax_payer_id',old('tax_payer_id'), ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('pan_card_number', __('PAN Card Number'),['class'=>'form-control-label']) !!}
                            {!! Form::text('pan_card_number',old('pan_card_number'), ['class' => 'form-control', 'required' => 'required']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            {!! Form::submit('Create', ['class' => 'btn btn-xs badge-blue float-right radius-10px']) !!}
            </form>
        </div>
    </div>
@endsection

@push('script-page')

    <script>

        $(function() {
  $('input[name="dob"]').daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    minYear: 1940,
    maxYear: parseInt(moment().format('YYYY'),10),
    locale: {
      format: 'YYYY-MM-DD'
    }
  }, function(start, end, label) {

  });
});

        $(document).ready(function () {
            var d_id = $('#department_id').val();
            var branch_id = $("#branch_id").val();

            getDesignation(d_id);
            getBranchEmployeeCode(branch_id);
        });

        $(document).on('change', 'select[name=department_id]', function () {
            var department_id = $(this).val();
            getDesignation(department_id);
        });

        $(document).on('change', 'select[name=branch_id]', function () {
            var branch_id = $(this).val();

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

        function getBranchEmployeeCode(bid)
        {
            var employee_nuber = "{{$employee_number}}";

            $.ajax({
                url: '{{route('branchcode.get')}}',
                type: 'POST',
                data: {
                    "branch_id": bid, "_token": "{{ csrf_token() }}",
                },
                success: function (data) {

                    var d = JSON.parse(data);

                    $("#old_employee_code").val(d.old_code);
                    $("#employee_code").val(d.new_code);

                }
            });

        }

        function getDesignation(did) {

            $.ajax({
                url: '{{route('employee.json')}}',
                type: 'POST',
                data: {
                    "department_id": did, "_token": "{{ csrf_token() }}",
                },
                success: function (data) {
                    $('#designation_id').empty();
                    $('#designation_id').append('<option value="">{{__('Select any Designation')}}</option>');
                    $.each(data, function (key, value) {
                        $('#designation_id').append('<option value="' + key + '">' + value + '</option>');
                    });
                }
            });
        }
    </script>
@endpush
