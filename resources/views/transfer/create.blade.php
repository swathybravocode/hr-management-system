<div class="card bg-none card-box">
    {{Form::open(array('url'=>'transfer','method'=>'post'))}}
    <div class="row">
        <div class="form-group col-lg-6 col-md-6">
            {{ Form::label('employee_id', __('Employee'),['class'=>'form-control-label'])}}
            {{ Form::select('employee_id', $employees,null, array('class' => 'form-control select2','required'=>'required')) }}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('branch_id',__('Branch'),['class'=>'form-control-label'])}}
            {{Form::select('branch_id',$branches,null,array('class'=>'form-control select2'))}}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('old_employee_code', __('Recent Employee Code'),['class'=>'form-control-label']) }}
            {{ Form::text('old_employee_code', $employee_details[0]->employee_code, array('class' => 'form-control', 'id'=> 'old_employee_code','required'=>'required')) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('employee_code', __('Employee Code'),['class'=>'form-control-label']) }}
            {{ Form::text('employee_code', $employee_details[0]->employee_code, array('class' => 'form-control', 'id'=> 'employee_code','required'=>'required')) }}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('department_id',__('Department'),['class'=>'form-control-label'])}}
            {{Form::select('department_id', $departments,null,array('class'=>'form-control select2'))}}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('transfer_date',__('Transfer Date'),['class'=>'form-control-label'])}}
            {{Form::text('transfer_date',null,array('class'=>'form-control datepicker'))}}
        </div>
        <div class="form-group col-lg-12">
            {{Form::label('description',__('Description'),['class'=>'form-control-label'])}}
            {{Form::textarea('description',null,array('class'=>'form-control','placeholder'=>__('Enter Description')))}}
        </div>
        <input type="hidden" value="{{$employee_details[0]->branch_id}}" id="old_branch_id" name="old_branch_id" >
        <input type="hidden" value="{{$employee_details[0]->department_id}}" id="old_department_id" name="old_department_id" >

        <div class="col-12">
            <input type="submit" value="{{__('Create')}}" class="btn-create badge-blue">
            <input type="button" value="{{__('Cancel')}}" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    {{Form::close()}}
</div>
