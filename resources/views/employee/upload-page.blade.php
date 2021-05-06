@extends('layouts.admin')
@section('page-title')
    {{__('Upload Employee Data')}}
@endsection
@section('content')
    <div class="row">
        <form method="post" action="{{route('employee.upload.data')}}" enctype="multipart/form-data">
        @csrf
    </div>
    <div class="row">
        <div class="col-md-6 ">
            <div class="card ">
                <div class="card-header"><h6 class="mb-0">{{__('Choose Details')}}</h6></div>
                <div class="card-body ">
                    <div class="row">
                    <div class="form-group col-md-6">
                        {{ Form::label('branch_id', __('Branch'),['class'=>'form-control-label']) }} <span class="text-danger">*</span>
                        {{ Form::select('branch_id', $branches, null, array('class' => 'form-control  select2','required'=>'required')) }}

                    </div>

                    <div class="form-group col-md-6">
                        {{ Form::label('department_id', __('Department'),['class'=>'form-control-label']) }} <span class="text-danger">*</span>
                        {{ Form::select('department_id', $departments,null, array('class' => 'form-control  select2','id'=>'department_id','required'=>'required')) }}
                    </div>
                    </div>
                    <div class="form-group">
                        <div class="float-left col-4">
                            <label for="document" class="float-left pt-1 form-control-label">File (CSV) <span class="text-danger">*</span> </label>
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

    </div>

    <div class="row">
        <div class="col-12">
            {!! Form::submit('Upload', ['class' => 'btn btn-xs badge-blue float-right radius-10px']) !!}
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
    </script>
@endpush
