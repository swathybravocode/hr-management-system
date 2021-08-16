<?php

namespace App\Http\Controllers;

use App\Allowance;
use App\Commission;
use App\Employee;
use App\Loan;
use App\Mail\InvoiceSend;
use App\Mail\PayslipSend;
use App\OtherPayment;
use App\Overtime;
use App\PaySlip;
use App\Leave;
use App\SaturationDeduction;
use App\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Jobs\SendQueueEmail;

class PaySlipController extends Controller
{

    public function index()
    {
        if(\Auth::user()->can('Manage Pay Slip'))
        {
            $employees = Employee::where(
                [
                    'created_by' => \Auth::user()->creatorId(),
                ]
            )->first();

            $month = [
                '01' => 'JAN',
                '02' => 'FEB',
                '03' => 'MAR',
                '04' => 'APR',
                '05' => 'MAY',
                '06' => 'JUN',
                '07' => 'JUL',
                '08' => 'AUG',
                '09' => 'SEP',
                '10' => 'OCT',
                '11' => 'NOV',
                '12' => 'DEC',
            ];

            $year = [
                '2020' => '2020',
                '2021' => '2021',
                '2022' => '2022',
                '2023' => '2023',
                '2024' => '2024',
                '2025' => '2025',
                '2026' => '2026',
                '2027' => '2027',
                '2028' => '2028',
                '2029' => '2029',
                '2030' => '2030',
            ];

            return view('payslip.index', compact('employees', 'month', 'year'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = \Validator::make(
            $request->all(), [
                               'month' => 'required',
                               'year' => 'required',

                           ]
        );

        if($validator->fails())
        {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        $month = $request->month;
        $year  = $request->year;


        $formate_month_year = $year . '-' . $month;


        $validatePaysilp    = PaySlip::where('salary_month', '=', $formate_month_year)->where('created_by', \Auth::user()->creatorId())->get()->toarray();

        if(empty($validatePaysilp))
        {
            $employees       = Employee::where('created_by', \Auth::user()->creatorId())->where('is_active','=','1')->orWhere('company_doj', '<=', date($month . '-t-' . $year))->get();
            $employeesSalary = Employee::where('created_by', \Auth::user()->creatorId())->where('is_active','=','1')->where('salary', '<=', 0)->first();

            if(!empty($employeesSalary))
            {
                return redirect()->route('payslip.index')->with('error', __('Please set employee salary.'));
            }

            foreach($employees as $employee)
            {
                $leaves = Leave::where([['employee_id','=', $employee->id], ['status', '=', 'Approve']
                , ['loss_of_pay','=', '1'], ['applied_on','like', '%'.$formate_month_year.'%']])->sum('total_leave_days');

                $total_leaves = ((int)$leaves);
                $worked_days  = 30 - $total_leaves;
                $total_basic  = ($employee->salary/30) * ((int)$worked_days);

                $payslipEmployee                       = new PaySlip();
                $payslipEmployee->employee_id          = $employee->id;
                $payslipEmployee->net_payble           = $employee->get_net_salary();
                $payslipEmployee->salary_month         = $formate_month_year;
                $payslipEmployee->status               = 0;
                $payslipEmployee->basic_salary         = !empty($employee->salary) ? $employee->salary : 0;
                //$payslipEmployee->basic_salary         = !empty($employee->salary) ? $total_basic : 0;
                $payslipEmployee->allowance            = Employee::allowance($employee->id, $worked_days);
                $payslipEmployee->commission           = Employee::commission($employee->id);
                $payslipEmployee->loan                 = Employee::loan($employee->id);
                $payslipEmployee->saturation_deduction = Employee::saturation_deduction($employee->id);
                $payslipEmployee->other_payment        = Employee::other_payment($employee->id);
                $payslipEmployee->overtime             = Employee::overtime($employee->id);
                $payslipEmployee->created_by           = \Auth::user()->creatorId();

                $payslipEmployee->save();
            }

            return redirect()->route('payslip.index')->with('success', __('Payslip successfully created.'));
        }
        else
        {
            return redirect()->route('payslip.index')->with('error', __('Payslip Already created.'));
        }

    }

    public function showemployee($paySlip)
    {

        $payslip = PaySlip::find($paySlip);

        return view('payslip.show', compact('payslip'));
    }


    public function search_json(Request $request)
    {

        $formate_month_year = $request->datePicker;
        $validatePaysilp    = PaySlip::where('salary_month', '=', $formate_month_year)->where('created_by', \Auth::user()->creatorId())->get()->toarray();


        if(empty($validatePaysilp))
        {
            return;
        }
        else
        {
            $paylip_employee = PaySlip::select(
                [
                    'employees.id',
                    'employees.employee_id',
                    'employees.name',
                    'employees.employee_code',
                    'payslip_types.name as payroll_type',
                    'pay_slips.basic_salary',
                    'pay_slips.net_payble',
                    'pay_slips.id as pay_slip_id',
                    'pay_slips.status',
                    'employees.user_id',
                ]
            )->leftjoin(
                'employees', function ($join) use ($formate_month_year){
                $join->on('employees.id', '=', 'pay_slips.employee_id');
                $join->on('pay_slips.salary_month', '=', \DB::raw("'" . $formate_month_year . "'"));
                $join->leftjoin('payslip_types', 'payslip_types.id', '=', 'employees.salary_type');
            }
            )->where('employees.is_active','=','1')->where('employees.created_by', \Auth::user()->creatorId())->get();


            foreach($paylip_employee as $employee)
            {

                if(Auth::user()->type == 'employee')
                {
                    if(Auth::user()->id == $employee->user_id)
                    {
                        $tmp   = [];
                        $tmp[] = $employee->id;
                        $tmp[] = $employee->name;
                        $tmp[] = $employee->payroll_type;
                        $tmp[] = $employee->pay_slip_id;
                        $tmp[] = !empty($employee->basic_salary) ? $employee->basic_salary : '-';
                        $tmp[] = !empty($employee->net_payble) ? $employee->net_payble : '-';
                        if($employee->status == 1)
                        {
                            $tmp[] = 'paid';
                        }
                        else
                        {
                            $tmp[] = 'unpaid';
                        }
                        $data[] = $tmp;
                    }
                }
                else
                {

                    $tmp   = [];
                    $tmp[] = $employee->id;
                    $tmp[] = $employee->employee_code;
                    $tmp[] = $employee->name;
                    $tmp[] = $employee->payroll_type;
                    $tmp[] = !empty($employee->basic_salary) ? $employee->basic_salary : '-';
                    $tmp[] = !empty($employee->net_payble) ? $employee->net_payble : '-';
                    if($employee->status == 1)
                    {
                        $tmp[] = 'Paid';
                    }
                    else
                    {
                        $tmp[] = 'UnPaid';
                    }
                    $tmp[]  = !empty($employee->pay_slip_id) ? $employee->pay_slip_id : 0;
                    $data[] = $tmp;
                }

            }

            return $data;
        }
    }

    public function paysalary($id, $date)
    {
        $employeePayslip = PaySlip::where('employee_id', '=', $id)->where('created_by', \Auth::user()->creatorId())->where('salary_month', '=', $date)->first();
        if(!empty($employeePayslip))
        {
            $employeePayslip->status = 1;
            $employeePayslip->save();

            return redirect()->route('payslip.index')->with('success', __('Payslip Payment successfully.'));
        }
        else
        {
            return redirect()->route('payslip.index')->with('error', __('Payslip Payment failed.'));
        }

    }

    public function bulk_pay_create($date)
    {
        $Employees       = PaySlip::where('salary_month', $date)->where('created_by', \Auth::user()->creatorId())->get();
        $unpaidEmployees = PaySlip::where('salary_month', $date)->where('created_by', \Auth::user()->creatorId())->where('status', '=', 0)->get();

        return view('payslip.bulkcreate', compact('Employees', 'unpaidEmployees', 'date'));
    }

    public function bulkpayment(Request $request, $date)
    {
        $unpaidEmployees = PaySlip::where('salary_month', $date)->where('created_by', \Auth::user()->creatorId())->where('status', '=', 0)->get();

        foreach($unpaidEmployees as $employee)
        {
            $payslip  = PaySlip::where('employee_id', $employee->employee_id)->where('salary_month', $date)->where('created_by', \Auth::user()->creatorId())->where('status', '=', 0)->first();

            $employee_info = Employee::find($employee->employee_id);

            $payslip->name  = $employee_info->name;
            $payslip->email = $employee_info->email;
            $payslip->auth_password = $employee_info->auth_password;

            $payslipId    = Crypt::encrypt($payslip->id);
            $payslip->url = route('payslip.payslipPdf', $payslipId);

            $now = Carbon::now();

            try
            {
                 //Mail::to($payslip->email)->send(new PayslipSend($payslip));

                $details = (new SendQueueEmail($payslip))
            	->delay($now->addSeconds(2));

                //dd($details);

                 dispatch($details);
            }
            catch(\Exception $e)
            {
                $smtp_error = __('E-Mail has been not sent due to SMTP configuration');
            }

            $employee->status = 1;
            $employee->save();

        }

        return redirect()->route('payslip.index')->with('success', __('Payslip bulk payment done & successfully sent to employees') . (isset($smtp_error) ? $smtp_error : ''));
    }

    public function employeepayslip()
    {
        $employees = Employee::where(
            [
                'user_id' => \Auth::user()->id,
            ]
        )->first();

        $payslip = PaySlip::where('employee_id', '=', $employees->id)->get();

        return view('payslip.employeepayslip', compact('payslip'));

    }

    public function pdf($id, $month)
    {
        $leaves = Leave::where([['employee_id','=', $id], ['status', '=', 'Approve']
                , ['loss_of_pay','=', '1'], ['applied_on','like', '%'.$month.'%']])->sum('total_leave_days');

        $total_leaves = ((int)$leaves);
        $worked_days  = 30 - $total_leaves;

        $payslip  = PaySlip::where('employee_id', $id)->where('salary_month', $month)->where('created_by', \Auth::user()->creatorId())->first();
        $employee = Employee::find($payslip->employee_id);

        $payslipDetail = Utility::employeePayslipDetail($id, $worked_days);


        if($worked_days < 30)
        {
            $deductions = $payslip->net_payble - $payslipDetail['netEarning'];

            $unpaid_deductions = (int)$deductions;
        }
        else
        {
            $unpaid_deductions = "0.0";
        }

        return view('payslip.pdf', compact('payslip', 'employee', 'payslipDetail','worked_days', 'unpaid_deductions'));
    }

    public function send($id, $month)
    {
        $payslip  = PaySlip::where('employee_id', $id)->where('salary_month', $month)->where('created_by', \Auth::user()->creatorId())->first();
        $employee = Employee::find($payslip->employee_id);

        $payslip->name  = $employee->name;
        $payslip->email = $employee->email;
        $payslip->auth_password = $employee->auth_password;


        $payslipId    = Crypt::encrypt($payslip->id);
        $payslip->url = route('payslip.payslipPdf', $payslipId);

        $setings = Utility::settings();
        if($setings['payroll_create'] == 1)
        {
            try
            {
                Mail::to($payslip->email)->send(new PayslipSend($payslip));
            }
            catch(\Exception $e)
            {
                $smtp_error = __('E-Mail has been not sent due to SMTP configuration');
            }

            return redirect()->back()->with('success', __('Payslip successfully sent.') . (isset($smtp_error) ? $smtp_error : ''));
        }

        return redirect()->back()->with('success', __('Payslip successfully sent.'));

    }

    public function payslipPdf($id)
    {
        $payslipId = Crypt::decrypt($id);

        $payslip  = PaySlip::where('id', $payslipId)->where('created_by', \Auth::user()->creatorId())->first();
        $employee = Employee::find($payslip->employee_id);

        $leaves = Leave::where([['employee_id','=', $payslip->employee_id], ['status', '=', 'Approve']
                , ['loss_of_pay','=', '1'], ['applied_on','like', '%'.$payslip->salary_month.'%']])->sum('total_leave_days');

        $total_leaves = ((int)$leaves);
        $worked_days  = 30 - $total_leaves;

        $payslipDetail = Utility::employeePayslipDetail($payslip->employee_id, $worked_days);

        if($worked_days < 30)
        {
            $deductions = $payslip->net_payble - $payslipDetail['netEarning'];

            $unpaid_deductions = (int)$deductions;
        }
        else
        {
            $unpaid_deductions = "0.0";
        }

        return view('payslip.payslipPdf', compact('payslip', 'employee', 'payslipDetail','worked_days', 'unpaid_deductions'));
    }

    public function editEmployee($paySlip)
    {
        $payslip = PaySlip::find($paySlip);

        return view('payslip.salaryEdit', compact('payslip'));
    }

    public function updateEmployee(Request $request, $id)
    {


        if(isset($request->allowance) && !empty($request->allowance))
        {
            $allowances   = $request->allowance;
            $allowanceIds = $request->allowance_id;
            foreach($allowances as $k => $allownace)
            {
                $allowanceData         = Allowance::find($allowanceIds[$k]);
                $allowanceData->amount = $allownace;
                $allowanceData->save();
            }
        }


        if(isset($request->commission) && !empty($request->commission))
        {
            $commissions   = $request->commission;
            $commissionIds = $request->commission_id;
            foreach($commissions as $k => $commission)
            {
                $commissionData         = Commission::find($commissionIds[$k]);
                $commissionData->amount = $commission;
                $commissionData->save();
            }
        }

        if(isset($request->loan) && !empty($request->loan))
        {
            $loans   = $request->loan;
            $loanIds = $request->loan_id;
            foreach($loans as $k => $loan)
            {
                $loanData         = Loan::find($loanIds[$k]);
                $loanData->amount = $loan;
                $loanData->save();
            }
        }


        if(isset($request->saturation_deductions) && !empty($request->saturation_deductions))
        {
            $saturation_deductionss   = $request->saturation_deductions;
            $saturation_deductionsIds = $request->saturation_deductions_id;
            foreach($saturation_deductionss as $k => $saturation_deductions)
            {

                $saturation_deductionsData         = SaturationDeduction::find($saturation_deductionsIds[$k]);
                $saturation_deductionsData->amount = $saturation_deductions;
                $saturation_deductionsData->save();
            }
        }


        if(isset($request->other_payment) && !empty($request->other_payment))
        {
            $other_payments   = $request->other_payment;
            $other_paymentIds = $request->other_payment_id;
            foreach($other_payments as $k => $other_payment)
            {
                $other_paymentData         = OtherPayment::find($other_paymentIds[$k]);
                $other_paymentData->amount = $other_payment;
                $other_paymentData->save();
            }
        }


        if(isset($request->rate) && !empty($request->rate))
        {
            $rates   = $request->rate;
            $rateIds = $request->rate_id;
            $hourses = $request->hours;

            foreach($rates as $k => $rate)
            {
                $overtime        = Overtime::find($rateIds[$k]);
                $overtime->rate  = $rate;
                $overtime->hours = $hourses[$k];
                $overtime->save();
            }
        }


        $payslipEmployee                       = PaySlip::find($request->payslip_id);
        $payslipEmployee->allowance            = Employee::allowance($payslipEmployee->employee_id);
        $payslipEmployee->commission           = Employee::commission($payslipEmployee->employee_id);
        $payslipEmployee->loan                 = Employee::loan($payslipEmployee->employee_id);
        $payslipEmployee->saturation_deduction = Employee::saturation_deduction($payslipEmployee->employee_id);
        $payslipEmployee->other_payment        = Employee::other_payment($payslipEmployee->employee_id);
        $payslipEmployee->overtime             = Employee::overtime($payslipEmployee->employee_id);
        $payslipEmployee->net_payble           = Employee::find($payslipEmployee->employee_id)->get_net_salary();
        $payslipEmployee->save();

        return redirect()->route('payslip.index')->with('success', __('Employee payroll successfully updated.'));
    }
}
