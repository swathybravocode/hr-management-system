<div class="card bg-none card-box">
    {{Form::open(array('url'=>'branch','method'=>'post'))}}
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                {{Form::label('name',__('Branch Code'),['class'=>'form-control-label'])}}
                {{Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter Branch Code')))}}
                @error('name')
                <span class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="col-12">
            <div class="form-group">
                {{Form::label('branch_name',__('Branch Name'),['class'=>'form-control-label'])}}
                {{Form::text('branch_name',null,array('class'=>'form-control','placeholder'=>__('Enter Branch Name')))}}
                @error('branch_name')
                <span class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <input type="submit" value="{{__('Create')}}" class="btn-create badge-blue">
            <input type="button" value="{{__('Cancel')}}" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    {{Form::close()}}
</div>
