@extends('layouts.admin')

@section('page-title')
    {{__('Employee')}}
@endsection

@section('action-button')
    <div class="all-button-box row d-flex justify-content-end">
        @can('Edit Employee')
            <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6">
                <a href="{{route('employee.edit',\Illuminate\Support\Facades\Crypt::encrypt($employee->id))}}" class="btn btn-xs btn-white btn-icon-only width-auto">
                    <i class="fa fa-edit"></i> {{ __('Edit') }}
                </a>
            </div>
        @endcan
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6 ">
            <div class="employee-detail-wrap">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">{{__('Personal Detail')}}</h6>
                    </div>
                    <div class="card-body employee-detail-body">
                        <div class="row">
                            <div class="col-3 mx-auto">
                                <img src="{{asset('storage/uploads/avatar/'.$employee->employee_photo)}}" class="img-fluid">

                            </div>
                        </div>
                        <br>
                        <div class="row">

                            <div class="col-md-7">
                                <div class="info text-sm">
                                    <strong>{{__('EmployeeId')}}</strong>
                                    <span>{{$employeesId}}</span>
                                </div>

                                <div class="info text-sm font-style">
                                    <strong>{{__('Full Name')}}</strong>
                                    <span>{{$employee->name." ".$employee->middle_name." ".$employee->last_name}}</span>
                                </div>

                                <div class="info text-sm font-style">
                                    <strong>{{__('Email')}}</strong>
                                    <span>{{$employee->email}}</span>
                                </div>

                                <div class="info text-sm font-style">
                                    <strong>{{__('Blood Group')}}</strong>
                                    <span>{{$employee->blood_group}}</span>
                                </div>

                                <div class="info text-sm">
                                    <strong>{{__('Salary Type')}}</strong>
                                    <span>{{!empty($employee->salaryType)?$employee->salaryType->name:''}}</span>
                                </div>
                                <div class="info text-sm">
                                    <strong>{{__('Aadhaar Number')}}</strong>
                                    <span>{{$employee->aadhaar_card_number}}</span>
                                </div>

                            </div>
                            <div class="col-md-5">
                                <div class="info text-sm">
                                    <strong>{{__('Old Employee Code')}}</strong>
                                    <span>{{$employee->old_employee_code}}</span>
                                </div>

                                <div class="info text-sm">
                                    <strong>{{__('Date of Birth')}}</strong>
                                    <span>{{\Auth::user()->dateFormat($employee->dob)}}</span>
                                </div>

                                <div class="info text-sm font-style">
                                    <strong>{{__('Gender')}}</strong>
                                    <span>{{$employee->gender}}</span>
                                </div>
                                <div class="info text-sm">
                                    <strong>{{__('Phone')}}</strong>
                                    <span>{{$employee->phone}}</span>
                                </div>
                                <div class="info text-sm">
                                    <strong>{{__('Basic Salary')}}</strong>
                                    <span>{{$employee->salary}}</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 ">
            <div class="employee-detail-wrap">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">{{__('Company Detail')}}</h6>
                    </div>
                    <div class="card-body employee-detail-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong>{{__('Branch')}}</strong>
                                    <span>{{!empty($employee->branch)?$employee->branch->name:''}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong>{{__('Department')}}</strong>
                                    <span>{{!empty($employee->department)?$employee->department->name:''}}</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong>{{__('Employee Code')}}</strong>
                                    <span>{{!empty($employee->employee_code)?$employee->employee_code:''}}</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong>{{__('Head Quarter')}}</strong>
                                    <span>{{!empty($employee->head_quarter)?$employee->head_quarter:''}}</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong>{{__('Designation')}}</strong>
                                    <span>{{!empty($employee->designation)?$employee->designation->name:''}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong>{{__('Date Of Joining')}}</strong>
                                    <span>{{\Auth::user()->dateFormat($employee->company_doj)}}</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="employee-detail-wrap">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">{{__('Bank Account Detail')}}</h6>
                    </div>
                    <div class="card-body employee-detail-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong>{{__('Account Holder Name')}}</strong>
                                    <span>{{$employee->account_holder_name}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong>{{__('Account Number')}}</strong>
                                    <span>{{$employee->account_number}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong>{{__('Bank Name')}}</strong>
                                    <span>{{$employee->bank_name}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong>{{__('Bank IFSC')}}</strong>
                                    <span>{{$employee->bank_identifier_code}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong>{{__('Branch Location')}}</strong>
                                    <span>{{$employee->branch_location}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong>{{__('Tax Payer Id')}}</strong>
                                    <span>{{$employee->tax_payer_id}}</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong>{{__('PAN Card Number')}}</strong>
                                    <span>{{$employee->pan_card_number}}</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 ">
            <div class="employee-detail-wrap">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">{{__('Document Detail')}}</h6>
                    </div>
                    <div class="card-body employee-detail-body">
                        <div class="row">
                            @php
                                $employeedoc = $employee->documents()->pluck('document_value',__('document_id'));
                            @endphp
                            @foreach($documents as $key=>$document)
                                <div class="col-md-12">
                                    <div class="info text-sm">
                                        <strong>{{$document->name }}</strong>
                                        <span><a href="{{ (!empty($employeedoc[$document->id])?asset(Storage::url('uploads/document')).'/'.$employeedoc[$document->id]:'') }}" target="_blank">{{ (!empty($employeedoc[$document->id])?$employeedoc[$document->id]:'') }}</a></span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 ">

        </div>
    </div>
@endsection

