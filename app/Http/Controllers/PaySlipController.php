<?php

namespace App\Http\Controllers;

use App\Allowance;
use App\Branch;
use App\Commission;
use App\Employee;
use App\Jobs\SendQueueEmail;
use App\Leave;
use App\Loan;
use App\Mail\PayslipSend;
use App\OtherPayment;
use App\Overtime;
use App\PaySlip;
use App\SaturationDeduction;
use App\Utility;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;

class PaySlipController extends Controller
{
    public function index()
    {
        if (\Auth::user()->can('Manage Pay Slip')) {
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
            $branches = Branch::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            return view('payslip.index', compact('employees', 'month', 'year', 'branches'));
        } else {
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
            $request->all(),
            [
                'month' => 'required',
                'year' => 'required',
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }
        $month = $request->month;
        $year = $request->year;
        $formate_month_year = $year . '-' . $month;
        $validatePaysilp = PaySlip::where('salary_month', '=', $formate_month_year)->where('created_by', \Auth::user()->creatorId())->get()->toarray();
        $employees = Employee::where('created_by', \Auth::user()->creatorId())->where('is_active', '=', '1')->orWhere('company_doj', '<=', date($month . '-t-' . $year))->get();
        $employeesSalary = Employee::where('created_by', \Auth::user()->creatorId())->where('is_active', '=', '1')->where('salary', '<=', 0)->get();
        $i = $j = 0;
        foreach ($employees as $employee) {
            if ($employee->salary) {
                $leaves = Leave::where([
                    ['employee_id', '=', $employee->id], ['status', '=', 'Approve'], ['loss_of_pay', '=', '1'], ['applied_on', 'like', '%' . $formate_month_year . '%'],
                ])->sum('total_leave_days');
                $total_leaves = ((int) $leaves);
                $worked_days = 30 - $total_leaves;
                $total_basic = ($employee->salary / 30) * ((int) $worked_days);
                $payslipEmployee = PaySlip::where('salary_month', '=', $formate_month_year)->where('employee_id', $employee->id)->where('created_by', \Auth::user()->creatorId())->first();
                if (!$payslipEmployee) {
                    $payslipEmployee = new PaySlip();
                }
                $payslipEmployee->employee_id = $employee->id;
                $payslipEmployee->net_payble = $employee->get_net_salary();
                $payslipEmployee->salary_month = $formate_month_year;
                $payslipEmployee->status = 0;
                $payslipEmployee->basic_salary = !empty($employee->salary) ? $employee->salary : 0;
                //$payslipEmployee->basic_salary         = !empty($employee->salary) ? $total_basic : 0;
                $payslipEmployee->allowance = Employee::allowance($employee->id, $worked_days);
                $payslipEmployee->commission = Employee::commission($employee->id);
                $payslipEmployee->loan = Employee::loan($employee->id);
                $payslipEmployee->saturation_deduction = Employee::saturation_deduction($employee->id);
                $payslipEmployee->other_payment = Employee::other_payment($employee->id);
                $payslipEmployee->overtime = Employee::overtime($employee->id);
                $payslipEmployee->created_by = \Auth::user()->creatorId();
                $payslipEmployee->save();
                $i = $i + 1;
            } else {
                $j = $j + 1;
            }
        }
        $return = redirect()->route('payslip.index')->with('success', __('Payslip successfully created For ' . $i . ' Employees'));
        if (!empty($employeesSalary)) {
            $return =  $return->with('error', __('Please set employee salary for ' . count($employeesSalary) . ' Employees'));
        }
        if ($j) {
            $return =  $return->with('error', __('Basic Salary not set for ' . $j . ' Employees'));
        }
        return  $return;
    }
    public function showemployee($paySlip)
    {
        $payslip = PaySlip::find($paySlip);
        return view('payslip.show', compact('payslip'));
    }
    public function search_json(Request $request)
    {
        $formate_month_year = $request->datePicker;
        $employees = Employee::select('id')->where('created_by', \Auth::user()->creatorId());
        if ($request->branch_id) {
            $employees->where('branch_id', $request->branch_id);
        }
        $employees = $employees->get();
        $validatePaysilp = PaySlip::where('salary_month', '=', $formate_month_year)->where('created_by', \Auth::user()->creatorId())->get()->toarray();
        if (empty($validatePaysilp)) {
            return;
        } else {
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
                'employees',
                function ($join) use ($formate_month_year) {
                    $join->on('employees.id', '=', 'pay_slips.employee_id');
                    $join->on('pay_slips.salary_month', '=', \DB::raw("'" . $formate_month_year . "'"));
                    $join->leftjoin('payslip_types', 'payslip_types.id', '=', 'employees.salary_type');
                }
            )->where('employees.is_active', '=', '1')->where('employees.created_by', \Auth::user()->creatorId());
            if ($request->branch_id) {
                $paylip_employee->whereIn('pay_slips.employee_id', $employees);
            }
            $paylip_employee = $paylip_employee->get();
            $data = [];
            foreach ($paylip_employee as $employee) {
                if (Auth::user()->type == 'employee') {
                    if (Auth::user()->id == $employee->user_id) {
                        $tmp = [];
                        $tmp[] = $employee->id;
                        $tmp[] = $employee->name;
                        $tmp[] = $employee->payroll_type;
                        $tmp[] = $employee->pay_slip_id;
                        $tmp[] = !empty($employee->basic_salary) ? $employee->basic_salary : '-';
                        $tmp[] = !empty($employee->net_payble) ? $employee->net_payble : '-';
                        if ($employee->status == 1) {
                            $tmp[] = 'paid';
                        } else {
                            $tmp[] = 'unpaid';
                        }
                        $data[] = $tmp;
                    }
                } else {
                    $tmp = [];
                    $tmp[] = $employee->id;
                    $tmp[] = $employee->employee_code;
                    $tmp[] = $employee->name;
                    $tmp[] = $employee->payroll_type;
                    $tmp[] = !empty($employee->basic_salary) ? $employee->basic_salary : '-';
                    $tmp[] = !empty($employee->net_payble) ? $employee->net_payble : '-';
                    if ($employee->status == 1) {
                        $tmp[] = 'Paid';
                    } else {
                        $tmp[] = 'UnPaid';
                    }
                    $tmp[] = !empty($employee->pay_slip_id) ? $employee->pay_slip_id : 0;
                    $data[] = $tmp;
                }
            }
            return $data;
        }
    }
    public function paysalary($id, $date)
    {
        $employeePayslip = PaySlip::where('employee_id', '=', $id)->where('created_by', \Auth::user()->creatorId())->where('salary_month', '=', $date)->first();
        if (!empty($employeePayslip)) {
            $employeePayslip->status = 1;
            $employeePayslip->save();
            return redirect()->route('payslip.index')->with('success', __('Payslip Payment successfully.'));
        } else {
            return redirect()->route('payslip.index')->with('error', __('Payslip Payment failed.'));
        }
    }
    public function bulk_pay_create($date, $branch_id)
    {
        $employee = Employee::select('id')->where('created_by', \Auth::user()->creatorId());
        if ($branch_id) {
            $employee->where('branch_id', $branch_id);
        }
        $employees = $employee->get();
        $Employees = PaySlip::where('salary_month', $date)->where('created_by', \Auth::user()->creatorId())->whereIn('employee_id', $employee)->get();
        $unpaidEmployees = PaySlip::where('salary_month', $date)->where('created_by', \Auth::user()->creatorId())->where('status', '=', 0)->whereIn('employee_id', $employee)->get();
        return view('payslip.bulkcreate', compact('Employees', 'unpaidEmployees', 'date', 'branch_id'));
    }
    public function bulkpayment(Request $request, $date, $branch_id)
    {
        $employee = Employee::select('id')->where('created_by', \Auth::user()->creatorId());
        if ($branch_id) {
            $employee->where('branch_id', $branch_id);
        }
        $employees = $employee->get();
        $unpaidEmployees = PaySlip::where('salary_month', $date)
            ->where('created_by', \Auth::user()->creatorId())
            ->where('status', '=', 0)
            ->whereIn('employee_id', $employee)
            ->get();
        $count = 0;
        $total_count = 0;
        foreach ($unpaidEmployees as $employee) {
            $payslip = PaySlip::where('employee_id', $employee->employee_id)
                ->where('salary_month', $date)
                ->where('created_by', \Auth::user()->creatorId())
                ->where('status', '=', 0)
                ->first();
            $employee_info = Employee::find($employee->employee_id);
            $payslip->name = $employee_info->name;
            $payslip->email = $employee_info->email;
            $payslip->auth_password = $employee_info->auth_password;
            $payslipId = Crypt::encrypt($payslip->id);
            $payslip->url = route('payslip.payslipPdf', $payslipId);
            $now = Carbon::now();
            $client = new \GuzzleHttp\Client();
            $headers = [
                'api-key' => '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',
                'Content-Type' => 'application/json'
            ];
            $html = "<!doctype html><html xmlns='http://www.w3.org/1999/xhtml'><head><meta http-equiv='X-UA-Compatible' content='IE=edge'><meta http-equiv='Content-Type' content='text/html; charset=UTF-8'><meta name='viewport' content='width=device-width, initial-scale=1'><style type='text/css'>#outlook a {padding: 0;}.ReadMsgBody {width: 100%;}.ExternalClass {width: 100%;}.ExternalClass * {line-height: 100%;}body {margin: 0;padding: 0;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;}table,td {border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;}img {border: 0;height: auto;line-height: 100%;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;}p {display: block;margin: 13px 0;}</style><style type='text/css'>@media only screen and (max-width: 480px) {@-ms-viewport {width: 320px;}@viewport {width: 320px;}}</style><style type='text/css'>.outlook-group-fix {width: 100% !important;}</style><link href='https://fonts.googleapis.com/css?family=Open Sans' rel='stylesheet' type='text/css'><style type='text/css'>@media only screen and (min-width: 480px) {.mj-column-per-100 {width: 100% !important;max-width: 100%;}}</style><style type='text/css'>[owa] .mj-column-per-100 {width: 100% !important;max-width: 100%;}</style><style type='text/css'>@media only screen and (max-width: 480px) {table.full-width-mobile {width: 100% !important;}td.full-width-mobile {width: auto !important;}}</style></head><body style='background-color:#f8f8f8;'><div style='background-color:#f8f8f8;'><table align='center' border='0' cellpadding='0' cellspacing='0' class='' style='width:600px;' width='600'><tr><td style='line-height:0px;font-size:0px;mso-line-height-rule:exactly;'><div style='background:#ffffff;background-color:#ffffff;Margin:0px auto;max-width:600px;'><table align='center' border='0' cellpadding='0' cellspacing='0' role='presentation' style='background:#ffffff;background-color:#ffffff;width:100%;'><tbody><tr><td style='direction:ltr;font-size:0px;padding:20px 0;padding-bottom:0px;padding-left:0px;padding-right:0px;padding-top:0px;text-align:center;vertical-align:top;'><table role='presentation' border='0' cellpadding='0' cellspacing='0'><tr><td class='' style='vertical-align:top;width:600px;'><div class='mj-column-per-100 outlook-group-fix' style='font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;'><table border='0' cellpadding='0' cellspacing='0' role='presentation' style='vertical-align:top;' width='100%'><tr><td style='font-size:0px;padding:10px 25px;padding-top:0px;padding-right:0px;padding-bottom:40px;padding-left:0px;word-break:break-word;'><p style='border-top:solid 7px #006569;font-size:1;margin:0px auto;width:100%;'></p><table align='center' border='0' cellpadding='0' cellspacing='0' style='border-top:solid 7px #006569;font-size:1;margin:0px auto;width:600px;' role='presentation' width='600px'><tr><td style='height:0;line-height:0;'></td></tr></table></td></tr><tr><td align='center' style='font-size:0px;padding:10px 25px;padding-top:0px;padding-bottom:0px;word-break:break-word;'><table border='0' cellpadding='0' cellspacing='0' role='presentation' style='border-collapse:collapse;border-spacing:0px;'><tbody><tr><td style='width:110px;'><img alt='' height='auto' src='https://eysys.co.in/hrms_demo/EysysHRM/storage/uploads/logo/logo.png' style='border:none;display:block;outline:none;text-decoration:none;height:auto;width:100%;' title='' width='110'/></td></tr></tbody></table></td></tr></table></div></td></tr></table></td></tr></tbody></table></div></td></tr></table><table align='center' border='0' cellpadding='0' cellspacing='0' class='' style='width:600px;' width='600'><tr><td style='line-height:0px;font-size:0px;mso-line-height-rule:exactly;'><div style='background:#ffffff;background-color:#ffffff;Margin:0px auto;max-width:600px;'><table align='center' border='0' cellpadding='0' cellspacing='0' role='presentation' style='background:#ffffff;background-color:#ffffff;width:100%;'><tbody><tr><td style='direction:ltr;font-size:0px;padding:20px 0px 20px 0px;padding-bottom:70px;padding-top:30px;text-align:center;vertical-align:top;'><table role='presentation' border='0' cellpadding='0' cellspacing='0'><tr><td class='' style='vertical-align:top;width:600px;'><div class='mj-column-per-100 outlook-group-fix' style='font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;'><table border='0' cellpadding='0' cellspacing='0' role='presentation' style='vertical-align:top;' width='100%'><tr><td align='left' style='font-size:0px;padding:0px 25px 0px 25px;padding-top:0px;padding-right:50px;padding-bottom:0px;padding-left:50px;word-break:break-word;'><div style='font-family:Open Sans, Helvetica, Arial, sans-serif;font-size:13px;line-height:22px;text-align:left;color:#797e82;'><p style=' line-height:32px'><b style='font-weight:700'>Subject : Eysys HR department/Company to send payslips by email at time of confirmation of payslip.</b></p><p style='line-height:32px'><b style='font-weight:700'>Hi $payslip->name,</b></p></div></td></tr><tr><td align='left' style='font-size:0px;padding:0px 25px 0px 25px;padding-top:0px;padding-right:50px;padding-bottom:0px;padding-left:50px;word-break:break-word;'><div style='font-family:Open Sans, Helvetica, Arial, sans-serif;font-size:13px;line-height:22px;text-align:left;color:#797e82;'><p style='margin: 10px 0;'><span>This is a Test Mail. </span>Hope this email ﬁnds you well! Please see attached payslip for $payslip->salary_month</p></div></td></tr><tr><td align='left' style='font-size:0px;padding:0px 25px 0px 25px;padding-top:0px;padding-right:50px;padding-bottom:0px;padding-left:50px;word-break:break-word;'><div style='font-family:Open Sans, Helvetica, Arial, sans-serif;font-size:13px;line-height:22px;text-align:left;color:#797e82;'><p style='margin: 10px 0; text-align: center;'> simply click on the button below: </p></div></td></tr><tr><td align='center' vertical-align='middle' style='font-size:0px;padding:10px 25px;padding-top:20px;padding-bottom:20px;word-break:break-word;'><table border='0' cellpadding='0' cellspacing='0' role='presentation' style='border-collapse:separate;line-height:100%;'><tr><td align='center' bgcolor='#6676EF' role='presentation' style='border:none;border-radius:100px;cursor:auto;padding:15px 25px 15px 25px;background:#006569;' valign='middle'><a href='$payslip->url' style='background:#006569;color:#ffffff;font-family:Open Sans, Helvetica, Arial, sans-serif;font-size:13px;font-weight:normal;line-height:120%;Margin:0;text-decoration:none;text-transform:none;' target='_blank'><b style='font-weight:700'><b style='font-weight:700'>Payslip</b></b></a></td></div></td></tr><tr><td align='left' style='font-size:0px;padding:0px 25px 0px 25px;padding-top:0px;padding-right:50px;padding-bottom:0px;padding-left:50px;word-break:break-word;'><div style='font-family:Open Sans, Helvetica, Arial, sans-serif;font-size:13px;line-height:22px;text-align:left;color:#797e82;'><p style='margin: 10px 0;'>Login with the given details, Username - '$payslip->email ' & Password - '$payslip->auth_password'</p></div></td></tr></table></td></tr><tr><td align='left' style='font-size:0px;padding:0px 25px 0px 25px;padding-top:0px;padding-right:50px;padding-bottom:0px;padding-left:50px;word-break:break-word;'><div style='font-family:Open Sans, Helvetica, Arial, sans-serif;font-size:13px;line-height:22px;text-align:left;color:#797e82;'><p style='margin: 10px 0;'><i style='font-style:normal'>Feel free to reach out if you have any questions.</i></p><p style='margin: 10px 0;'><i style='font-style:normal'>Thank you</i></p></div></td></tr><tr><td align='left' style='font-size:0px;padding:0px 25px 0px 25px;padding-top:0px;padding-right:50px;padding-bottom:0px;padding-left:50px;word-break:break-word;'><div style='font-family:Open Sans, Helvetica, Arial, sans-serif;font-size:13px;line-height:22px;text-align:left;color:#797e82;'><p style='margin: 10px 0;'><i style='font-style:normal'><b style='font-weight:700'>Regards,</b></i></p><p style='margin: 10px 0;'><i style='font-style:normal'><b style='font-weight:700'>HR Department,</b></i></p><p style='margin: 10px 0;'><i style='font-style:normal'><b style='font-weight:700'>Eysys Pharmaceuticals</b></i></p></div></td></tr></table></div></td></tr></table></td></tr></tbody></table></div></td></tr></table></div></body></html>";
            $body = '{
                        "sender": {
                          "name": "Eysys",
                          "email": "message.eysys@gmail.com"
                        },
                        "to": [
                              {
                                "email": "' . $payslip->email . '",
                                "name": "' . $payslip->name . '"
                              }
                        ],
                        "htmlContent":  ' . json_encode($html) . ',
                        "subject": "Regarding to payslip generator"
                      }';
            $request = $client->post('https://api.sendinblue.com/v3/smtp/email', ['headers' => $headers, "body" => $body]);
            $total_count++;
            if ($request->getStatusCode() >= 200 && $request->getStatusCode() <= 204) {
                $employee->status = 1;
                $count++;
            }
            $employee->save();
        }
        if ($total_count && $count)
            return redirect()->route('payslip.index')->with('success', __('Payslip bulk payment done & successfully sent to ' . $count . ' employees Out of ' . $total_count . ' employees.'));
        elseif ($total_count && !$count) {
            return redirect()->route('payslip.index')->with('error', __('Mail Sending Failed'));
        } elseif (!$total_count) {
            return redirect()->route('payslip.index')->with('error', __('Mails has already send to all employees'));
        } else {
            return redirect()->route('payslip.index')->with('error', __('Something Went wrong'));
        }
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
        $leaves = Leave::where([
            ['employee_id', '=', $id], ['status', '=', 'Approve'], ['loss_of_pay', '=', '1'], ['applied_on', 'like', '%' . $month . '%'],
        ])->sum('total_leave_days');
        $total_leaves = ((int) $leaves);
        $worked_days = 30 - $total_leaves;
        $payslip = PaySlip::where('employee_id', $id)->where('salary_month', $month)->where('created_by', \Auth::user()->creatorId())->first();
        $employee = Employee::find($payslip->employee_id);
        $payslipDetail = Utility::employeePayslipDetail($id, $worked_days);
        if ($worked_days < 30) {
            $deductions = $payslip->net_payble - $payslipDetail['netEarning'];
            $unpaid_deductions = (int) $deductions;
        } else {
            $unpaid_deductions = "0.0";
        }
        return view('payslip.pdf', compact('payslip', 'employee', 'payslipDetail', 'worked_days', 'unpaid_deductions'));
    }
    public function send($id, $month)
    {
        $payslip = PaySlip::where('employee_id', $id)->where('salary_month', $month)->where('created_by', \Auth::user()->creatorId())->first();
        $employee = Employee::find($payslip->employee_id);
        $payslip->name = $employee->name;
        $payslip->email = $employee->email;
        $payslip->auth_password = $employee->auth_password;
        $payslipId = Crypt::encrypt($payslip->id);
        $payslip->url = route('payslip.payslipPdf', $payslipId);
        $setings = Utility::settings();
        if ($setings['payroll_create'] == 1) {
            $client = new \GuzzleHttp\Client();
            $headers = [
                'api-key' => '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',
                'Content-Type' => 'application/json'
            ];
            $html = "<!doctype html><html xmlns='http://www.w3.org/1999/xhtml'><head><meta http-equiv='X-UA-Compatible' content='IE=edge'><meta http-equiv='Content-Type' content='text/html; charset=UTF-8'><meta name='viewport' content='width=device-width, initial-scale=1'><style type='text/css'>#outlook a {padding: 0;}.ReadMsgBody {width: 100%;}.ExternalClass {width: 100%;}.ExternalClass * {line-height: 100%;}body {margin: 0;padding: 0;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;}table,td {border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;}img {border: 0;height: auto;line-height: 100%;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;}p {display: block;margin: 13px 0;}</style><style type='text/css'>@media only screen and (max-width: 480px) {@-ms-viewport {width: 320px;}@viewport {width: 320px;}}</style><style type='text/css'>.outlook-group-fix {width: 100% !important;}</style><link href='https://fonts.googleapis.com/css?family=Open Sans' rel='stylesheet' type='text/css'><style type='text/css'>@media only screen and (min-width: 480px) {.mj-column-per-100 {width: 100% !important;max-width: 100%;}}</style><style type='text/css'>[owa] .mj-column-per-100 {width: 100% !important;max-width: 100%;}</style><style type='text/css'>@media only screen and (max-width: 480px) {table.full-width-mobile {width: 100% !important;}td.full-width-mobile {width: auto !important;}}</style></head><body style='background-color:#f8f8f8;'><div style='background-color:#f8f8f8;'><table align='center' border='0' cellpadding='0' cellspacing='0' class='' style='width:600px;' width='600'><tr><td style='line-height:0px;font-size:0px;mso-line-height-rule:exactly;'><div style='background:#ffffff;background-color:#ffffff;Margin:0px auto;max-width:600px;'><table align='center' border='0' cellpadding='0' cellspacing='0' role='presentation' style='background:#ffffff;background-color:#ffffff;width:100%;'><tbody><tr><td style='direction:ltr;font-size:0px;padding:20px 0;padding-bottom:0px;padding-left:0px;padding-right:0px;padding-top:0px;text-align:center;vertical-align:top;'><table role='presentation' border='0' cellpadding='0' cellspacing='0'><tr><td class='' style='vertical-align:top;width:600px;'><div class='mj-column-per-100 outlook-group-fix' style='font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;'><table border='0' cellpadding='0' cellspacing='0' role='presentation' style='vertical-align:top;' width='100%'><tr><td style='font-size:0px;padding:10px 25px;padding-top:0px;padding-right:0px;padding-bottom:40px;padding-left:0px;word-break:break-word;'><p style='border-top:solid 7px #006569;font-size:1;margin:0px auto;width:100%;'></p><table align='center' border='0' cellpadding='0' cellspacing='0' style='border-top:solid 7px #006569;font-size:1;margin:0px auto;width:600px;' role='presentation' width='600px'><tr><td style='height:0;line-height:0;'></td></tr></table></td></tr><tr><td align='center' style='font-size:0px;padding:10px 25px;padding-top:0px;padding-bottom:0px;word-break:break-word;'><table border='0' cellpadding='0' cellspacing='0' role='presentation' style='border-collapse:collapse;border-spacing:0px;'><tbody><tr><td style='width:110px;'><img alt='' height='auto' src='https://eysys.co.in/hrms_demo/EysysHRM/storage/uploads/logo/logo.png' style='border:none;display:block;outline:none;text-decoration:none;height:auto;width:100%;' title='' width='110'/></td></tr></tbody></table></td></tr></table></div></td></tr></table></td></tr></tbody></table></div></td></tr></table><table align='center' border='0' cellpadding='0' cellspacing='0' class='' style='width:600px;' width='600'><tr><td style='line-height:0px;font-size:0px;mso-line-height-rule:exactly;'><div style='background:#ffffff;background-color:#ffffff;Margin:0px auto;max-width:600px;'><table align='center' border='0' cellpadding='0' cellspacing='0' role='presentation' style='background:#ffffff;background-color:#ffffff;width:100%;'><tbody><tr><td style='direction:ltr;font-size:0px;padding:20px 0px 20px 0px;padding-bottom:70px;padding-top:30px;text-align:center;vertical-align:top;'><table role='presentation' border='0' cellpadding='0' cellspacing='0'><tr><td class='' style='vertical-align:top;width:600px;'><div class='mj-column-per-100 outlook-group-fix' style='font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;'><table border='0' cellpadding='0' cellspacing='0' role='presentation' style='vertical-align:top;' width='100%'><tr><td align='left' style='font-size:0px;padding:0px 25px 0px 25px;padding-top:0px;padding-right:50px;padding-bottom:0px;padding-left:50px;word-break:break-word;'><div style='font-family:Open Sans, Helvetica, Arial, sans-serif;font-size:13px;line-height:22px;text-align:left;color:#797e82;'><p style=' line-height:32px'><b style='font-weight:700'>Subject : Eysys HR department/Company to send payslips by email at time of confirmation of payslip.</b></p><p style='line-height:32px'><b style='font-weight:700'>Hi $payslip->name,</b></p></div></td></tr><tr><td align='left' style='font-size:0px;padding:0px 25px 0px 25px;padding-top:0px;padding-right:50px;padding-bottom:0px;padding-left:50px;word-break:break-word;'><div style='font-family:Open Sans, Helvetica, Arial, sans-serif;font-size:13px;line-height:22px;text-align:left;color:#797e82;'><p style='margin: 10px 0;'>This is a Test Mail. Hope this email ﬁnds you well! Please see attached payslip for $payslip->salary_month</p></div></td></tr><tr><td align='left' style='font-size:0px;padding:0px 25px 0px 25px;padding-top:0px;padding-right:50px;padding-bottom:0px;padding-left:50px;word-break:break-word;'><div style='font-family:Open Sans, Helvetica, Arial, sans-serif;font-size:13px;line-height:22px;text-align:left;color:#797e82;'><p style='margin: 10px 0; text-align: center;'> simply click on the button below: </p></div></td></tr><tr><td align='center' vertical-align='middle' style='font-size:0px;padding:10px 25px;padding-top:20px;padding-bottom:20px;word-break:break-word;'><table border='0' cellpadding='0' cellspacing='0' role='presentation' style='border-collapse:separate;line-height:100%;'><tr><td align='center' bgcolor='#6676EF' role='presentation' style='border:none;border-radius:100px;cursor:auto;padding:15px 25px 15px 25px;background:#006569;' valign='middle'><a href='$payslip->url' style='background:#006569;color:#ffffff;font-family:Open Sans, Helvetica, Arial, sans-serif;font-size:13px;font-weight:normal;line-height:120%;Margin:0;text-decoration:none;text-transform:none;' target='_blank'><b style='font-weight:700'><b style='font-weight:700'>Payslip</b></b></a></td></div></td></tr><tr><td align='left' style='font-size:0px;padding:0px 25px 0px 25px;padding-top:0px;padding-right:50px;padding-bottom:0px;padding-left:50px;word-break:break-word;'><div style='font-family:Open Sans, Helvetica, Arial, sans-serif;font-size:13px;line-height:22px;text-align:left;color:#797e82;'><p style='margin: 10px 0;'>Login with the given details, Username - '$payslip->email ' & Password - '$payslip->auth_password'</p></div></td></tr></table></td></tr><tr><td align='left' style='font-size:0px;padding:0px 25px 0px 25px;padding-top:0px;padding-right:50px;padding-bottom:0px;padding-left:50px;word-break:break-word;'><div style='font-family:Open Sans, Helvetica, Arial, sans-serif;font-size:13px;line-height:22px;text-align:left;color:#797e82;'><p style='margin: 10px 0;'><i style='font-style:normal'>Feel free to reach out if you have any questions.</i></p><p style='margin: 10px 0;'><i style='font-style:normal'>Thank you</i></p></div></td></tr><tr><td align='left' style='font-size:0px;padding:0px 25px 0px 25px;padding-top:0px;padding-right:50px;padding-bottom:0px;padding-left:50px;word-break:break-word;'><div style='font-family:Open Sans, Helvetica, Arial, sans-serif;font-size:13px;line-height:22px;text-align:left;color:#797e82;'><p style='margin: 10px 0;'><i style='font-style:normal'><b style='font-weight:700'>Regards,</b></i></p><p style='margin: 10px 0;'><i style='font-style:normal'><b style='font-weight:700'>HR Department,</b></i></p><p style='margin: 10px 0;'><i style='font-style:normal'><b style='font-weight:700'>Eysys Pharmaceuticals</b></i></p></div></td></tr></table></div></td></tr></table></td></tr></tbody></table></div></td></tr></table></div></body></html>";
            $body = '{
                    "sender": {
                      "name": "Eysys",
                      "email": "message.eysys@gmail.com"
                    },
                    "to": [
                          {
                            "email": "' . $payslip->email . '",
                            "name": "' . $payslip->name . '"
                          }
                    ],
                    "htmlContent":  ' . json_encode($html) . ',
                    "subject": "Regarding to payslip generator"
                  }';
            $request = $client->post('https://api.sendinblue.com/v3/smtp/email', ['headers' => $headers, "body" => $body]);
            if ($request->getStatusCode() >= 200 && $request->getStatusCode() <= 204) {
                return response()->json(['is_success' => true, 'message' => __('Payslip successfully sent.')], $request->getStatusCode());
            } else {
                return response()->json(['is_success' => false, 'message' => __('Payslip successfully sent.')], $request->getStatusCode());
            }
        }
    }
    public function payslipPdf($id)
    {
        $payslipId = Crypt::decrypt($id);
        $payslip = PaySlip::where('id', $payslipId)->where('created_by', \Auth::user()->creatorId())->first();
        $employee = Employee::find($payslip->employee_id);
        $leaves = Leave::where([
            ['employee_id', '=', $payslip->employee_id], ['status', '=', 'Approve'], ['loss_of_pay', '=', '1'], ['applied_on', 'like', '%' . $payslip->salary_month . '%'],
        ])->sum('total_leave_days');
        $total_leaves = ((int) $leaves);
        $worked_days = 30 - $total_leaves;
        $payslipDetail = Utility::employeePayslipDetail($payslip->employee_id, $worked_days);
        if ($worked_days < 30) {
            $deductions = $payslip->net_payble - $payslipDetail['netEarning'];
            $unpaid_deductions = (int) $deductions;
        } else {
            $unpaid_deductions = "0.0";
        }
        return view('payslip.payslipPdf', compact('payslip', 'employee', 'payslipDetail', 'worked_days', 'unpaid_deductions'));
    }
    public function editEmployee($paySlip)
    {
        $payslip = PaySlip::find($paySlip);
        return view('payslip.salaryEdit', compact('payslip'));
    }
    public function updateEmployee(Request $request, $id)
    {
        if (isset($request->allowance) && !empty($request->allowance)) {
            $allowances = $request->allowance;
            $allowanceIds = $request->allowance_id;
            foreach ($allowances as $k => $allownace) {
                $allowanceData = Allowance::find($allowanceIds[$k]);
                $allowanceData->amount = $allownace;
                $allowanceData->save();
            }
        }
        if (isset($request->commission) && !empty($request->commission)) {
            $commissions = $request->commission;
            $commissionIds = $request->commission_id;
            foreach ($commissions as $k => $commission) {
                $commissionData = Commission::find($commissionIds[$k]);
                $commissionData->amount = $commission;
                $commissionData->save();
            }
        }
        if (isset($request->loan) && !empty($request->loan)) {
            $loans = $request->loan;
            $loanIds = $request->loan_id;
            foreach ($loans as $k => $loan) {
                $loanData = Loan::find($loanIds[$k]);
                $loanData->amount = $loan;
                $loanData->save();
            }
        }
        if (isset($request->saturation_deductions) && !empty($request->saturation_deductions)) {
            $saturation_deductionss = $request->saturation_deductions;
            $saturation_deductionsIds = $request->saturation_deductions_id;
            foreach ($saturation_deductionss as $k => $saturation_deductions) {
                $saturation_deductionsData = SaturationDeduction::find($saturation_deductionsIds[$k]);
                $saturation_deductionsData->amount = $saturation_deductions;
                $saturation_deductionsData->save();
            }
        }
        if (isset($request->other_payment) && !empty($request->other_payment)) {
            $other_payments = $request->other_payment;
            $other_paymentIds = $request->other_payment_id;
            foreach ($other_payments as $k => $other_payment) {
                $other_paymentData = OtherPayment::find($other_paymentIds[$k]);
                $other_paymentData->amount = $other_payment;
                $other_paymentData->save();
            }
        }
        if (isset($request->rate) && !empty($request->rate)) {
            $rates = $request->rate;
            $rateIds = $request->rate_id;
            $hourses = $request->hours;
            foreach ($rates as $k => $rate) {
                $overtime = Overtime::find($rateIds[$k]);
                $overtime->rate = $rate;
                $overtime->hours = $hourses[$k];
                $overtime->save();
            }
        }
        $payslipEmployee = PaySlip::find($request->payslip_id);
        $payslipEmployee->allowance = Employee::allowance($payslipEmployee->employee_id, 30);
        $payslipEmployee->commission = Employee::commission($payslipEmployee->employee_id);
        $payslipEmployee->loan = Employee::loan($payslipEmployee->employee_id);
        $payslipEmployee->saturation_deduction = Employee::saturation_deduction($payslipEmployee->employee_id);
        $payslipEmployee->other_payment = Employee::other_payment($payslipEmployee->employee_id);
        $payslipEmployee->overtime = Employee::overtime($payslipEmployee->employee_id);
        $payslipEmployee->net_payble = Employee::find($payslipEmployee->employee_id)->get_net_salary();
        $payslipEmployee->save();
        return redirect()->route('payslip.index')->with('success', __('Employee payroll successfully updated.'));
    }
}
