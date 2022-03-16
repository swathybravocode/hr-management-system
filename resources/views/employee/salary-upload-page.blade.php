@extends('layouts.admin')
@section('page-title')
Upload Employee Salary
@endsection
@section('content')
    <div class="row">
        <form method="post" action="{{route('employee.salary.upload.data')}}" enctype="multipart/form-data">
        @csrf
    </div>
    <div class="row">
        <div class="col-md-6 ">
            <div class="card ">
                <div class="card-header"><h6 class="mb-0">{{__('Choose Details')}}</h6></div>
                <div class="card-body ">
                    <div class="row">
                    </div>
                    <div class="form-group">
                        <div class="float-left col-4">
                            <label for="document" class="float-left pt-1 form-control-label">File (xlsx) <span class="text-danger">*</span> </label>
                        </div>
                        <div class="float-right col-8">
                            <input type="hidden" name="emp_photo" id="" value="">
                            <div class="choose-file form-group">
                                <label for="document">
                                    <div>{{__('Choose File')}}</div>
                                    <input class="form-control border-0"  required name="employee_salary_data" type="file" id="employee_data" data-filename="{{'_filename'}}">
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
