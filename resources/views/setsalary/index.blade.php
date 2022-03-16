@extends('layouts.admin') @section('page-title') {{__('Manage Employee Salary')}} @endsection @section('content')
<div class="row">
    <div class="col-12">
        <div class="row d-flex justify-content-end">
            <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6 text-right">
                <a href="{{ route('employee.salary.upload.page') }}" class="btn btn-xs btn-white btn-icon-only width-auto">
                    <i class="fa fa-upload"></i> {{ __('Upload') }}
                </a>
            </div>
        </div>
        <div class="card">
            <div class="card-body py-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0 dataTable">
                        <thead>
                            <tr>
                                <th>{{__('Employee Id')}}</th>
                                <th>{{__('Employee Code')}}</th>
                                <th>{{__('Name')}}</th>
                                <th>{{__('Payroll Type') }}</th>
                                <th>{{__('Salary') }}</th>
                                <th>{{__('Net Salary') }}</th>
                                <th width="200px">{{__('Action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employees as $employee)
                            <tr>
                                <td>{{ \Auth::user()->employeeIdFormat($employee->employee_id) }}</td>
                                <td>{{$employee->employee_code }}</td>

                                <td>{{ $employee->name }}</td>
                                <td>{{ $employee->salary_type() }}</td>
                                <td>{{ \Auth::user()->priceFormat($employee->salary) }}</td>
                                <td>{{ !empty($employee->get_net_salary()) ?\Auth::user()->priceFormat($employee->get_net_salary()):'' }}</td>
                                <td>
                                    @if($employee->is_active==1)
                                    <a href="{{route('setsalary.show',$employee->id)}}" class="edit-icon bg-success" data-toggle="tooltip" data-original-title="{{__('View')}}">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @else
                                    <i class="fas fa-lock"></i> Inactive @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection