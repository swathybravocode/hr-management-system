@php
    $logo=asset(Storage::url('uploads/logo/'));
    $company_logo=Utility::getValByName('company_logo');
@endphp
@extends('layouts.admin')
<style>
    address{text-align: justify;}
   address span{float: right;}

    #payslip-table{ border-radius: 3px; }
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

table.GeneratedTable td, table.GeneratedTable th {
 border-width: 2px;
 border-color: #ccc;
 border-style: solid;
 padding: 10px;
}

table.GeneratedTable thead {
 background-color: #ccc;
}
</style>
@section('page-title')
    {{__('Payslip')}}
@endsection
@section('content')
    <div class="main-content">
        <div class="text-md-right mb-2">
            <a href="#" class="btn btn-warning" onclick="saveAsPDF()"><span class="fa fa-download"></span></a>
        </div>
        <div class="col-8">
            <div class="invoice" id="printableArea">
                <div class="invoice-print">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="invoice-title">
                                <h6 class="mb-3">{{__('Payslip')}}</h6>
                                <div class="invoice-number">
                                    <img src="{{$logo.'/'.(isset($company_logo) && !empty($company_logo)?$company_logo:'logo.png')}}" width="170px;">
                                </div>
                            </div>
                            <hr>
                            <div class="row text-sm">
                                <div class="col-md-7">
                                    <address>
                                        <strong>{{__('Name')}} &emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;&nbsp;:</strong>&emsp;&emsp; {{$employee->name}}<br>
                                        <strong>{{__('Division')}}&emsp;&emsp;&nbsp;&nbsp;&nbsp;&nbsp; :</strong>&emsp;&emsp; {{$employee->department->name}}<br>
                                        {{-- <strong>{{__('Salary Date')}} :</strong> {{\Auth::user()->dateFormat( $employee->created_at)}}<br> --}}
                                        <strong>{{__('Bank Details')}}&nbsp;&nbsp; :</strong>&emsp;&emsp; {{('A/C # -')}} {{$employee->account_number}}<br>
                                        <strong>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</strong>&emsp;&emsp; {{$employee->bank_name}}

                                    </address>
                                </div>
                                <div class="col-md-5 text-md-right">
                                    <address>
                                        <strong>{{__('Pay Slip')}} &emsp;&emsp;&emsp;&emsp;&nbsp;:</strong><span> {{ \Auth::user()->dateFormat( $payslip->salary_month)}}</span><br>
                                        <strong>{{__('Employee Code')}}&nbsp; :</strong> <span>{{ $employee->employee_code}}</span><br>
                                        <strong>{{__('Region')}}&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;:</strong> <span>{{ $employee->branch->name}}</span><br>
                                        <strong>{{__('Currency')}}&emsp;&emsp;&emsp;&nbsp;&nbsp; :</strong> <span>{{__('INR')}}</span><br>

                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div id="payslip-table" class="table-responsive">
                                {{-- <table class="table table-striped table-hover table-md">
                                    <tbody>
                                    <tr class="font-weight-bold">
                                        <th>{{__('Earning')}}</th>
                                        <th>{{__('Amount')}}</th>
                                    </tr>
                                    <tr>
                                        <td>{{__('Basic Salary')}}</td>
                                        <td>{{  \Auth::user()->priceFormat( $payslip->basic_salary)}}</td>
                                    </tr>
                                    @foreach($payslipDetail['earning']['allowance'] as $allowance)
                                        <tr>
                                            <td>{{$allowance->title}}</td>
                                            <td>{{ \Auth::user()->priceFormat( $allowance->amount)}}</td>
                                        </tr>
                                    @endforeach
                                    @foreach($payslipDetail['earning']['commission'] as $commission)
                                        <tr>
                                            <td>{{$commission->title}}</td>
                                            <td>{{ \Auth::user()->priceFormat( $commission->amount)}}</td>

                                        </tr>
                                    @endforeach
                                    @foreach($payslipDetail['earning']['otherPayment'] as $otherPayment)
                                        <tr>
                                            <td>{{$otherPayment->title}}</td>
                                            <td>{{  \Auth::user()->priceFormat( $otherPayment->amount)}}</td>

                                        </tr>
                                    @endforeach
                                    @foreach($payslipDetail['earning']['overTime'] as $overTime)
                                        <tr>
                                            <td>{{$overTime->title}}</td>
                                            <td>{{  \Auth::user()->priceFormat( $overTime->amount)}}</td>

                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td>{{__('Total Earning')}}</td>
                                        <td>{{ \Auth::user()->priceFormat($payslipDetail['totalEarning'])}}</td>

                                    </tr>
                                    <tr>
                                        <td>{{__('Net Salary')}}</td>
                                        <td>{{ \Auth::user()->priceFormat($payslip->net_payble)}}</td>
                                    </tr>

                                    </tbody>
                                </table> --}}

                                <table class="GeneratedTable">
                                    <tr>
                                      <th scope="col" >{{__('Earnings')}} <span style="float:right">{{__('Amount')}}</span></th>
                                      <th scope="col" >{{__('Deductions')}} <span style="float:right">{{__('Amount')}}</span></th>
                                    </tr>
                                    <tr>
                                      <td>
                                      <p>{{__('Basic Salary')}} <span style="float:right">{{  \Auth::user()->priceFormat( $payslip->basic_salary)}}</span></p>
                                      @foreach($payslipDetail['earning']['allowance'] as $allowance)
                                      <p>{{$allowance->title}} <span style="float:right">{{ \Auth::user()->priceFormat( $allowance->amount)}}</span></p>
                                      @endforeach
                                       @foreach($payslipDetail['earning']['commission'] as $commission)
                                      <p>{{$commission->title}} <span style="float:right">{{ \Auth::user()->priceFormat( $commission->amount)}}</span></p>
                                       @endforeach
                                       @foreach($payslipDetail['earning']['otherPayment'] as $otherPayment)
                                      <p>{{$otherPayment->title}} <span style="float:right">{{  \Auth::user()->priceFormat( $otherPayment->amount)}}</span></p>
                                       @endforeach
                                        @foreach($payslipDetail['earning']['overTime'] as $overTime)
                                      <p>{{$overTime->title}} <span style="float:right">{{  \Auth::user()->priceFormat( $overTime->amount)}}</span></p>
                                       @endforeach
                                      <p><b>{{__('Total Earnings')}}</b> <span style="float:right">{{ \Auth::user()->priceFormat($payslipDetail['totalEarning'])}}</span></p>
                                      </td>
                                      <td>
                                      @foreach($payslipDetail['deduction']['loan'] as $loan)
                                      <p>{{$loan->title}} <span style="float:right">{{  \Auth::user()->priceFormat( $loan->amount)}}</span></p>
                                      @endforeach
                                      @foreach($payslipDetail['deduction']['deduction'] as $deduction)
                                      <p>{{$deduction->title}} <span style="float:right">{{  \Auth::user()->priceFormat( $deduction->amount)}}</span></p>
                                      @endforeach
                                      <p><span style="float:right"></span></p>
                                      <p><b>Total Deductions</b> <span style="float:right"><b>{{ \Auth::user()->priceFormat($payslipDetail['totalDeduction'])}}</b></span></p>
                                      </td>
                                    </tr>

                                    <tr>
                                      <td><b>{{__('Net Earnings')}}</b> <span style="float:right;"><b>{{ \Auth::user()->priceFormat($payslipDetail['netEarning'])}}</b></span></td>
                                      <td></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2"><p>Variable Compensation is paid at the discretion of the management and does not constitute, as part of guaranteed compensation</p>
                                      <p>This is a computer generated document and does not require a signature. This document may not be used for the purpose of obtaining a credit card.</p></td>
                                    </tr>
                                  </table>
                            </div>
                        </div>

                        {{-- <div class="col-md-6">
                            <div id="payslip-table" class="table-responsive">
                                <table class="table table-striped table-hover table-md" >
                                    <tbody>
                                    <tr class="font-weight-bold">
                                        <th>{{__('Deduction')}}</th>

                                        <th class="text-right">{{__('Amount')}}</th>
                                    </tr>

                                    @foreach($payslipDetail['deduction']['loan'] as $loan)
                                        <tr>
                                            <td>{{$loan->title}}</td>

                                            <td class="text-right">{{  \Auth::user()->priceFormat( $loan->amount)}}</td>
                                        </tr>
                                    @endforeach
                                    @foreach($payslipDetail['deduction']['deduction'] as $deduction)
                                        <tr>
                                            <td>{{$deduction->title}}</td>

                                            <td class="text-right">{{  \Auth::user()->priceFormat( $deduction->amount)}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div> --}}


                    </div>


                </div>
                <hr>
                {{-- <div class="text-md-right">
                    <div class="float-lg-left mb-lg-0 mb-3 ">
                        <p class="mt-2">{{__('Employee Signature')}}</p>
                    </div>
                    <p class="mt-2 "> {{__('Paid By')}}</p>
                </div> --}}
            </div>
        </div>
        <script type="text/javascript" src="{{ asset('js/html2pdf.bundle.min.js') }}"></script>
        <script>

            function saveAsPDF() {
                var element = document.getElementById('printableArea');
                var opt = {
                    margin: 0.3,
                    filename: '{{$employee->name}}',
                    image: {type: 'jpeg', quality: 1},
                    html2canvas: {scale: 4, dpi: 72, letterRendering: true},
                    jsPDF: {unit: 'in', format: 'A4'}
                };
                html2pdf().set(opt).from(element).save();
            }

        </script>

    </div>
    <script type="text/javascript" src="{{ asset('js/html2pdf.bundle.min.js') }}"></script>
    <script>

        function saveAsPDF() {
            var element = document.getElementById('printableArea');
            var opt = {
                margin: 0.3,
                filename: '{{$employee->name}}',
                image: {type: 'jpeg', quality: 1},
                html2canvas: {scale: 4, dpi: 72, letterRendering: true},
                jsPDF: {unit: 'in', format: 'A4'}
            };
            html2pdf().set(opt).from(element).save();
        }

    </script>
@endsection


