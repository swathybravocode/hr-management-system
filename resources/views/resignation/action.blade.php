<div class="card bg-none card-box">
    {{Form::open(array('url'=>'resignation/changeaction','method'=>'post'))}}
    <div class="row">
        <div class="col-12">
            <table class="table table-striped mb-0 dataTable no-footer">
                <tr role="row">
                    <th>{{__('Employee')}}</th>
                    <td>{{ !empty($employee->name)?$employee->name:'' }}</td>
                </tr>
                <tr>
                    <th>{{__('Appplied On')}}</th>
                    <td>{{\Auth::user()->dateFormat( $resignation->notice_date) }}</td>
                </tr>
                <tr>
                    <th>{{__('Resignation Date')}}</th>
                    <td>{{ \Auth::user()->dateFormat($resignation->resignation_date) }}</td>
                </tr>
                <tr>
                    <th>{{__('Resign Reason')}}</th>
                    <td>{{ !empty($resignation->description)?$resignation->description:'' }}</td>
                </tr>
                <tr>
                    <th>{{__('Status')}}</th>
                    <td>{{ !empty($resignation->status)?$resignation->status:'' }}</td>
                </tr>

                <input type="hidden" value="{{ $resignation->id }}" name="resign_id">
            </table>
        </div>
        <div class="col-12">
            <input type="submit" class="btn-create badge-success" value="{{__('Approval')}}" name="status">
            <input type="submit" class="btn-create bg-danger" value="{{__('Reject')}}" name="status">
        </div>
    </div>
    {{Form::close()}}
</div>
