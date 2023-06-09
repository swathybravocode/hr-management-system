@extends('layouts.admin')
@section('page-title')
    {{__('Payslip')}}
@endsection
@section('action-button')
    @can('Create Pay Slip')
        {{Form::open(array('route'=>array('payslip.store'),'method'=>'POST','class'=>'w-50 float-left','id'=>'payslip_form'))}}
        <div class="row d-flex justify-content-end">
            <div class="col-xl-4 col-lg-4 col-md-6">
                <div class="all-select-box">
                    <div class="btn-box">
                        {{Form::label('month',__('Select Month'),['class'=>'text-type'])}}
                        {{Form::select('month',$month,null,array('class'=>'form-control month select2' ))}}
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6">
                <div class="all-select-box">
                    <div class="btn-box">
                        {{Form::label('year',__('Select Year'),['class'=>'text-type'])}}
                        {{Form::select('year',$year,null,array('class'=>'form-control year select2' ))}}
                    </div>
                </div>
            </div>
            <div class="col-auto my-auto text-right">
                <a href="#" class="apply-btn" onclick="document.getElementById('payslip_form').submit(); return false;"  data-toggle="tooltip" data-title="{{__('Apply')}}">
                    <span class="btn-inner--icon"><i class="fas fa-search"></i></span>
                </a>
            </div>
        </div>
        {{ Form::close() }}
    @endcan
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <form>
                        <div class="d-flex justify-content-between w-100">
                            <h6>{{__('Employee Salary')}}</h6>
                            <div class="float-right col-3">
                                <select class="form-control month_date select2" name="year" tabindex="-1" aria-hidden="true">
                                    <option value="--">--</option>
                                    @foreach($month as $k=>$mon)
                                        <option value="{{$k}}">{{$mon}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="float-right col-3">
                                {{Form::select('year',$year,null,array('class'=>'form-control year_date select2'))}}
                            </div>
                            <div class="float-right col-3">
                            <select class="form-control branch_id select2" name="branch_id" tabindex="-1" aria-hidden="true">
                                    <option value="0">All</option>
                                    @foreach($branches as $k=>$branche)
                                        <option value="{{$k}}">{{$branche}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @can('Create Pay Slip')
                                <input type="button" value="{{__('Bulk Payment')}}" class="btn-create badge-blue float-right search" id="bulk_payment">
                            @endcan
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0" id="dataTable1">
                            <thead>
                            <tr>
                                <th>{{__('Id')}}</th>
                                <th>{{__('Employee Code')}}</th>
                                <th>{{__('Name')}}</th>
                                <th>{{__('Payroll Type') }}</th>
                                <th>{{__('Salary') }}</th>
                                <th>{{__('Net Salary') }}</th>
                                <th>{{__('Status') }}</th>
                                <th>{{__('Action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-page')
    <script type="text/javascript">
        $(document).ready(function () {
            var table = $('#dataTable1').DataTable({
                "aoColumnDefs": [
                    {
                        "aTargets": [6],
                        "mData": null,
                        "mRender": function (data, type, full) {
                            var month = $(".month_date").val();
                            var year = $(".year_date").val();
                            var datePicker = year + '-' + month;
                            var id = data[0];

                            if (data[6] == 'Paid')
                                return '<div class="badge badge-pill badge-success"><a href="#" class="text-white">' + data[6] + '</a></div>';
                            else
                                return '<div class="badge badge-pill badge-danger"><a href="#" class="text-white">' + data[6] + '</a></div>';
                        }
                    },
                    {
                        "aTargets": [7],
                        "mData": null,
                        "mRender": function (data, type, full) {
                            var month = $(".month_date").val();
                            var year = $(".year_date").val();
                            var datePicker = year + '-' + month;

                            var id = data[0];
                            var payslip_id = data[7];

                            var clickToPaid = '';
                            var payslip = '';
                            var view = '';
                            var edit = '';

                            if (data[7] != 0) {
                                var payslip = '<a href="javascript:void(0);" data-url="{{ url('payslip/pdf/') }}/' + id + '/' + datePicker + '" data-size="md-pdf"  data-ajax-popup="true" class="view-btn yellow-bg" data-title="{{__('Employee Payslip')}}">' + '{{__('Payslip')}}' + '</a> ';
                            }

                            if (data[6] == "UnPaid" && data[7] != 0) {
                                clickToPaid = '<a href="{{ url('payslip/paysalary/') }}/' + id + '/' + datePicker + '"  class="view-btn green-bg">' + '{{__('Click To Paid')}}' + '</a>  ';
                            }

                            if (data[7] != 0) {
                                view = '<a href="javascript:void(0);" data-url="{{ url('payslip/showemployee/') }}/' + payslip_id + '"  data-ajax-popup="true" class="view-btn gray-bg" data-title="{{__('View Employee Detail')}}">' + '{{__('View')}}' + '</a>';
                            }

                            if (data[7] != 0 && data[6] == "UnPaid") {
                                edit = '<a href="javascript:void(0);" data-url="{{ url('payslip/editemployee/') }}/' + payslip_id + '"  data-ajax-popup="true" class="view-btn blue-bg" data-title="{{__('Edit Employee salary')}}">' + '{{__('Edit')}}' + '</a>';
                            }

                            return view + payslip + clickToPaid + edit;
                        }
                    },
                ]
            });

            function callback() {
                var month = $(".month_date").val();
                var year = $(".year_date").val(); 
                var branch_id = $(".branch_id").val();
                var datePicker = year + '-' + month;

                $.ajax({
                    url: '{{route('payslip.search_json')}}',
                    type: 'POST',
                    data: {
                        "datePicker": datePicker,"branch_id": branch_id, "_token": "{{ csrf_token() }}",
                    },
                    success: function (data) {

                        table.rows().remove().draw();
                        table.rows.add(data).draw();
                        table.column(0).visible(false);
                        $('[data-toggle="tooltip"]').tooltip();

                        if (!(data)) {
                            show_msg('error', 'Payslip Not Found!', 'error');
                        }
                    },
                    error: function (data) {

                    }
                });
            }

            $(document).on("change", ".month_date,.year_date", function () {
                callback();
            });

            //bulkpayment Click
            $(document).on("click", "#bulk_payment", function () {
                var month = $(".month_date").val();
                var year = $(".year_date").val();
                var datePicker = year + '_' + month;
                var branch_id = $(".branch_id").val();
            });
            $(document).on('click', '#bulk_payment', 'a[data-ajax-popup="true"], button[data-ajax-popup="true"], div[data-ajax-popup="true"]', function () {
                var month = $(".month_date").val();
                var year = $(".year_date").val();
                var branch_id = $(".branch_id").val();
                var datePicker = year + '-' + month;

                var title = 'Bulk Payment';
                var size = 'md';
                var url = 'payslip/bulk_pay_create/' + datePicker + '/' + branch_id;

                // return false;

                $("#commonModal .modal-title").html(title);
                $("#commonModal .modal-dialog").addClass('modal-' + size);
                $.ajax({
                    url: url,
                    success: function (data) {

                        // alert(data);
                        // return false;
                        if (data.length) {
                            $('#commonModal .modal-body').html(data);
                            $("#commonModal").modal('show');
                            // common_bind();
                        } else {
                            show_msg('Error', 'Permission denied.');
                            $("#commonModal").modal('hide');
                        }
                    },
                    error: function (data) {
                        data = data.responseJSON;
                        show_msg('Error', data.error);
                    }
                });
            });
        });


    </script>
@endpush
