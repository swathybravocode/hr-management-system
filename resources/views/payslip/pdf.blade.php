@php $logo=asset(Storage::url('uploads/logo/')); $company_logo=Utility::getValByName('company_logo'); @endphp
<style>
    address {
        text-align: justify;
    }

    address span {
        float: right;
    }

    #payslip-table {
        border-radius: 3px;
    }

    table.GeneratedTable {
        width: 100%;
        background-color: #ccc;
        border-collapse: collapse;
        border-width: 2px;
        border-color: #ccc;
        border-style: solid;
        color: rgb(156, 155, 155);
        text-align: left;
    }

    table.GeneratedTable td,
    table.GeneratedTable th {
        border-width: 2px;
        border-color: #ccc;
        border-style: solid;
        padding: 10px;
    }

    table.GeneratedTable thead {
        background-color: #ccc;
    }

    .GeneralDetailsTable tr,
    .GeneralDetailsTable td,
    .GeneralDetailsTable th {
        padding: 0px !important;
        border: none !important;
    }

    .trucate {
        width: 180px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
<div class="card bg-none card-box">
    <div class="col-md-12 table-responsive">
        <table class="table table-md GeneralDetailsTable">
            <tr>
                <td>
                    <div class="text-md-left mb-2">
                        <h6 class="mb-3">{{__('Payslip')}}</h6>
                    </div>
                </td>
                <td>
                    <div class="text-md-right mb-2">
                        <a href="#" class="btn btn-xs rounded-pill btn-warning" onclick="saveAsPDF()"><span class="fa fa-download"></span></a>
                        <a title="Mail Send" href="#" class="btn btn-xs rounded-pill btn-primary mail-send"><span class="fa fa-paper-plane"></span></a> {!! Form::hidden('employee_id',$employee->id, ['class' => 'form-control']) !!} {!! Form::hidden('payslip_salary_month',$payslip->salary_month,
                        ['class' => 'form-control']) !!}
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div class="invoice" id="printableArea">
        <div class="invoice-print">
            <div class="row">
                <div class="col-lg-3">
                    <div class="invoice-title">
                        <div class="invoice-number">
                            <img src="{{$logo.'/'.(isset($company_logo) && !empty($company_logo)?$company_logo:'logo.png')}}" width="170px;">
                        </div>
                    </div>
                </div>
                <div class="col-lg-9" style="display: flex; align-items: center;">
                    <div class=" invoice-title text-justify px-3">
                        <h6 class="mb-3">
                           Eysys Pharmaceutical Private Limited, E A Chambers Tower II, 5th Floor, 49/50L, Whites Road, Royapettah Chennai - 600002
                        </h6>
                    </div>
                </div>
                <div class="col-lg-12">
                    <hr>
                    <div class="row text-sm">
                        <div class="col-md-12 table-responsive">
                            <table class="table table-md GeneralDetailsTable">
                                <tr>
                                    <td><strong>{{__('Name')}}</strong></td>
                                    <td>&nbsp;:&nbsp;</td>
                                    <td><span class="trucate">{{$employee->name}}</span></td>
                                    <td><strong>{{__('Pay Slip')}}</strong></td>
                                    <td>&nbsp;:&nbsp;</td>
                                    <td class="text-right">{{ \Auth::user()->dateFormat( $payslip->salary_month)}}</td>
                                </tr>
                                <tr>
                                    <td><strong>{{__('Division')}}</strong></td>
                                    <td>&nbsp;:&nbsp;</td>
                                    <td><span class="trucate">{{$employee->department->name}}</span> </td>
                                    <td><strong>{{__('Employee Code')}}</strong></td>
                                    <td>&nbsp;:&nbsp;</td>
                                    <td class="text-right">{{ $employee->employee_code}}</td>
                                </tr>
                                <tr>
                                    <td><strong>{{__('Headquarter')}}</strong></td>
                                    <td>&nbsp;:&nbsp;</td>
                                    <td><span class="trucate">{{$employee->head_quarter}}</span></td>
                                    <td><strong>{{__('Currency')}}</strong></td>
                                    <td>&nbsp;:&nbsp;</td>
                                    <td class="text-right">{{__('INR')}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-12">
                    <div id="payslip-table" class="table-responsive">
                        <table class="GeneratedTable">
                            <tr>
                                <th scope="col">{{__('Earnings')}} <span style="float:right">{{__('Amount')}}</span></th>
                                <th scope="col">{{__('Deductions')}} <span style="float:right">{{__('Amount')}}</span></th>
                            </tr>
                            <tr>
                                <td>
                                    <p>{{__('Basic Salary')}} <span style="float:right">{{  \Auth::user()->priceFormat($payslipDetail['basic_salary'])}}</span></p>
                                    @foreach($payslipDetail['earning']['allowance'] as $allowance)
                                    <p>{{$allowance->title}} <span style="float:right">{{ \Auth::user()->priceFormat( $allowance->amount)}}</span></p>
                                    @endforeach @foreach($payslipDetail['earning']['commission'] as $commission)
                                    <p>{{$commission->title}} <span style="float:right">{{ \Auth::user()->priceFormat( $commission->amount)}}</span></p>
                                    @endforeach @foreach($payslipDetail['earning']['otherPayment'] as $otherPayment)
                                    <p>{{$otherPayment->title}} <span style="float:right">{{  \Auth::user()->priceFormat( $otherPayment->amount)}}</span></p>
                                    @endforeach @foreach($payslipDetail['earning']['overTime'] as $overTime)
                                    <p>{{$overTime->title}} <span style="float:right">{{  \Auth::user()->priceFormat( $overTime->amount)}}</span></p>
                                    @endforeach
                                    <p><b>{{__('Total Earnings')}}</b> <span style="float:right">{{ \Auth::user()->priceFormat($payslipDetail['totalEarning'])}}</span></p>
                                </td>
                                <td>
                                    @foreach($payslipDetail['deduction']['loan'] as $loan)
                                    <p>{{$loan->title}} <span style="float:right">{{  \Auth::user()->priceFormat( $loan->amount)}}</span></p>
                                    @endforeach @foreach($payslipDetail['deduction']['deduction'] as $deduction)
                                    <p>{{$deduction->title}} <span style="float:right">{{  \Auth::user()->priceFormat( $deduction->amount)}}</span></p>
                                    @endforeach
                                    <p><span style="float:right"></span></p>
                                    <p><span style="float:right"></span></p>
                                    <p><b>Total Deductions</b> <span style="float:right"><b>{{ \Auth::user()->priceFormat($payslipDetail['totalDeduction'] + $unpaid_deductions)}}</b></span></p>
                                </td>
                            </tr>
                            <tr>
                                <td><b>{{__('Net Earnings')}}</b> <span style="float:right;"><b>{{ \Auth::user()->priceFormat($payslipDetail['netEarning'])}}</b></span></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <p>Variable Compensation is paid at the discretion of the management and does not constitute, as part of guaranteed compensation</p>
                                    <p>This is a computer generated document and does not require a signature. This document may not be used for the purpose of obtaining a credit card.</p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <hr>
    </div>
</div>
<script type="text/javascript" src="{{ asset( 'js/html2pdf.bundle.min.js') }}"></script>
<script>
    function saveAsPDF() {
        var element = document.getElementById('printableArea');
        var opt = {
            margin: 0.3,
            filename: '{{$employee->name}}',
            image: {
                type: 'jpeg',
                quality: 1
            },
            html2canvas: {
                scale: 4,
                dpi: 72,
                letterRendering: true
            },
            jsPDF: {
                unit: 'in',
                format: 'A4'
            }
        };
        html2pdf().set(opt).from(element).save();
    }
    $(document).on('click', '.mail-send', function(event) {
        event.preventDefault();
        var employee_id = $('input[type=hidden][name=employee_id]').val();
        var payslip_salary_month = $('input[type=hidden][name=payslip_salary_month]').val();
        $.ajax({
            url: "{{ url( '/') }}" + "/payslip/send/" + employee_id + "/" + payslip_salary_month,
            type: 'Get',
            success: function(data) {
                $("#commonModal").modal('hide');
                if (data.is_success) {
                    show_toastr('Success', data.message, 'success');
                } else {
                    show_toastr('Error', data.message, 'error');
                }
            },
            error: function(data) {
                if (data.is_success) {
                    show_toastr('Success', data.message, 'success');
                } else if (!data.is_success) {
                    show_toastr('Error', data.message, 'error');
                } else {
                    data = data.responseJSON;
                    show_toastr('Error', data.error, 'error');
                }
            }
        });
    });
</script>