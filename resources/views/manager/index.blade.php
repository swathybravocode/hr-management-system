@extends('layouts.admin')
@section('page-title')
    {{__('Managers')}}
@endsection

@section('action-button')
    <div class="all-button-box row d-flex justify-content-end">
        @can('Create Employee')
            <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6">
                <a href="{{ route('manager.create') }}" class="btn btn-xs btn-white btn-icon-only width-auto">
                    <i class="fa fa-plus"></i> {{ __('Create') }}
                </a>
            </div>
        @endcan
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body py-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0 dataTable">
                            <thead>
                            <tr>
                                <th>{{__('Manager Id')}}</th>
                                <th>{{__('Branch') }}</th>
                                <th>{{__('Name')}}</th>
                                <th>{{__('Email')}}</th>
                                {{-- <th>{{__('Contact') }}</th> --}}
                                <th>{{__('Department') }}</th>
                                <th>{{__('Designation') }}</th>
                                @if(Gate::check('Edit Employee') || Gate::check('Delete Employee'))
                                    <th width="200px">{{__('Action')}}</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($managers as $employee)
                                <tr>
                                    <td class="Id">
                                        @can('Show Employee')
                                            <a href="{{route('employee.show',\Illuminate\Support\Facades\Crypt::encrypt($employee->id))}}">{{ \Auth::user()->managerIdFormat($employee->manager_id) }}</a>
                                        @else
                                            <a href="#">{{ \Auth::user()->managerIdFormat($employee->manager_id) }}</a>
                                        @endcan
                                    </td>
                                    <td class="font-style">{{!empty(\Auth::user()->getBranch($employee->manager_branch_id ))?\Auth::user()->getBranch($employee->manager_branch_id )->name:''}}</td>

                                    <td class="font-style">{{ $employee->manager_name}}</td>
                                    <td>{{ $employee->manager_email}}</td>
                                    {{-- <td class="font-style">{{ $employee->manager_contact}}</td> --}}
                                    <td class="font-style">{{!empty(\Auth::user()->getDepartment($employee->manager_department_id ))?\Auth::user()->getDepartment($employee->manager_department_id )->name:''}}</td>
                                    <td class="font-style">{{!empty(\Auth::user()->getDesignation($employee->manager_type))?\Auth::user()->getDesignation($employee->manager_type )->name:''}}</td>

                                    @if(Gate::check('Edit Employee') || Gate::check('Delete Employee'))
                                        <td>

                                                @can('Edit Employee')
                                                    <a href="{{route('manager.edit',\Illuminate\Support\Facades\Crypt::encrypt($employee->manager_id))}}" class="edit-icon" data-toggle="tooltip" data-original-title="{{__('Edit')}}"><i class="fas fa-pencil-alt"></i></a>
                                                @endcan
                                                @can('Delete Employee')
                                                    <a href="#" class="delete-icon" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$employee->manager_id}}').submit();"><i class="fas fa-trash"></i></a>
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['employee.destroy', $employee->manager_id],'id'=>'delete-form-'.$employee->manager_id]) !!}
                                                    {!! Form::close() !!}
                                                @endcan

                                        </td>
                                    @endif
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


