<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Leave;
use App\LeaveType;
use App\Role;
use App\Mail\LeaveActionSend;
use App\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class LeaveController extends Controller
{
    public function index()
    {
        $user     = \Auth::user();

        if(\Auth::user()->can('Manage Leave'))
        {
            $leaves = Leave::where('created_by', '=', \Auth::user()->creatorId())->get();

            $loggedin_info = Employee::select('user_id','branches.name as branch_code',
            'branches.id as branch_id')->join('branches', 'branches.id', '=', 'employees.branch_id')
            ->where([['user_id', '=', $user->id], ['is_active','=','1']])->first();

            $role_details = DB::table('roles')->where('name','like','%'.$user->type.'%')->first();


            if(\Auth::user()->type == 'employee')
            {
                $employee = Employee::where('user_id', '=', $user->id)->first();
                $leaves   = Leave::where('employee_id', '=', $employee->id)->get();
            }

            else if(\Auth::user()->type == 'hr')
            {
                $employee = Employee::where('user_id', '=', $user->id)->first();
                // $leaves   = Leave::where('employee_id', '=', $employee->id)->get();
            }

            else if(\Auth::user()->type == 'business manager')
            {
                $employee = Employee::where([['branch_id', '=', $loggedin_info->branch_id]])->first();
                // $leaves   = Leave::where('employee_id', '=', $employee->id)->get();
                $leaves   = Leave::select('leaves.*','employees.id as emp_id','employees.name','employees.branch_id','employees.report_to')
                ->join('employees','employees.user_id','=','leaves.user_id')->where('leaves.employee_id', '=', $employee->id)->orWhere('employees.report_to','=',$role_details->id)->get();

            }

            else if(\Auth::user()->type == 'regional manager')
            {
                $employee = Employee::where([['branch_id', '=', $loggedin_info->branch_id]])->first();

                $leaves   = Leave::select('leaves.*','employees.id as emp_id','employees.name','employees.branch_id','employees.report_to')
                ->join('employees','employees.user_id','=','leaves.user_id')->where('leaves.employee_id', '=', $employee->id)->orWhere('employees.report_to','=',$role_details->id)->get();
            }

            else if(\Auth::user()->type == 'zonal manager')
            {
                // $employee = Employee::where('user_id', '=', $user->id)->first();
                // $leaves   = Leave::where('employee_id', '=', $employee->id)->get();

                $employee = Employee::where([['branch_id', '=', $loggedin_info->branch_id]])->first();

                $leaves   = Leave::select('leaves.*','employees.id as emp_id','employees.name','employees.branch_id','employees.report_to')
                ->join('employees','employees.user_id','=','leaves.user_id')->where('leaves.employee_id', '=', $employee->id)->orWhere('employees.report_to','=',$role_details->id)->get();
            }

            else if(\Auth::user()->type == 'depot manager')
            {

                // $employee = Employee::where('user_id', '=', $user->id)->first();
                // $leaves   = Leave::where('employee_id', '=', $employee->id)->get();

                $employee = Employee::where([['branch_id', '=', $loggedin_info->branch_id]])->first();

                $leaves   = Leave::select('leaves.*','employees.id as emp_id','employees.name','employees.branch_id','employees.report_to')
                ->join('employees','employees.user_id','=','leaves.user_id')->where('leaves.employee_id', '=', $employee->id)->orWhere('employees.report_to','=',$role_details->id)->get();
            }

            else
            {
                $leaves = Leave::where('created_by', '=', \Auth::user()->creatorId())->get();
            }

            return view('leave.index', compact('leaves'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if(\Auth::user()->can('Create Leave'))
        {
            if(Auth::user()->type == 'employee')
            {
                $employees = Employee::where('user_id', '=', \Auth::user()->id)->get()->pluck('name', 'id');
                $employee_info  = Employee::where([['user_id','=', Auth::user()->id]])
                ->select('roles.id','roles.name as role')
                ->join('roles', 'roles.id', '=', 'employees.report_to')->get();
            }

            else if(Auth::user()->type == 'business officer')
            {
                $employees = Employee::where('user_id', '=', \Auth::user()->id)->get()->pluck('name', 'id');
                $employee_info  = Employee::where([['user_id','=', Auth::user()->id]])
                ->select('roles.id','roles.name as role')
                ->join('roles', 'roles.id', '=', 'employees.report_to')->get();
            }

            else if(Auth::user()->type == 'business manager')
            {
                $employees = Employee::where('user_id', '=', \Auth::user()->id)->get()->pluck('name', 'id');
                $employee_info  = Employee::where([['user_id','=', Auth::user()->id]])
                ->select('roles.id','roles.name as role')
                ->join('roles', 'roles.id', '=', 'employees.report_to')->get();
            }

            else if(Auth::user()->type == 'regional manager')
            {
                $employees = Employee::where('user_id', '=', \Auth::user()->id)->get()->pluck('name', 'id');
                $employee_info  = Employee::where([['user_id','=', Auth::user()->id]])
                ->select('roles.id','roles.name as role')
                ->join('roles', 'roles.id', '=', 'employees.report_to')->get();
            }


           else if(Auth::user()->type == 'zonal manager')
            {
                $employees = Employee::where('user_id', '=', \Auth::user()->id)->get()->pluck('name', 'id');
                $employee_info  = Employee::where([['user_id','=', Auth::user()->id]])
                ->select('roles.id','roles.name as role')
                ->join('roles', 'roles.id', '=', 'employees.report_to')->get();
            }


            else if(Auth::user()->type == 'depot manager')
            {
                $employees = Employee::where('user_id', '=', \Auth::user()->id)->get()->pluck('name', 'id');
                $employee_info  = Employee::where([['user_id','=', Auth::user()->id]])
                ->select('roles.id','roles.name as role')
                ->join('roles', 'roles.id', '=', 'employees.report_to')->get();
            }

            else if(Auth::user()->type == 'hr')
            {
                $employees = Employee::where('user_id', '=', \Auth::user()->id)->get()->pluck('name', 'id');
                $employee_info  = Employee::where([['user_id','=', Auth::user()->id]])
                ->select('roles.id','roles.name as role')
                ->join('roles', 'roles.id', '=', 'employees.report_to')->get();
            }

            else if(Auth::user()->type == 'company')
            {
                $employees = Employee::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');

            }

            else
            {

                $employees = Employee::where('user_id', '=', \Auth::user()->id)->get()->pluck('name', 'id');
                $employee_info  = Employee::where([['user_id','=', Auth::user()->id]])
                ->select('roles.id','roles.name as role')
                ->join('roles', 'roles.id', '=', 'employees.report_to')->get();

            }

            $leavetypes      = LeaveType::where('created_by', '=', \Auth::user()->creatorId())->get();
            $leavetypes_days = LeaveType::where('created_by', '=', \Auth::user()->creatorId())->get();


            return view('leave.create', compact('employees', 'leavetypes', 'leavetypes_days','employee_info'));
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    {

        if(\Auth::user()->can('Create Leave'))
        {
            $validator = \Validator::make(
                $request->all(), [
                                   'leave_type_id' => 'required',
                                   'start_date' => 'required',
                                   'end_date' => 'required',
                                   'leave_reason' => 'required',
                                   'remark' => 'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }


            $employee = Employee::where('user_id', '=', Auth::user()->id)->first();
            $leave    = new Leave();
            if(\Auth::user()->type == "employee")
            {
                $leave->employee_id = $employee->id;
            }
            else
            {
                $leave->employee_id = $request->employee_id;
            }
            $leave->leave_type_id    = $request->leave_type_id;
            $leave->applied_on       = date('Y-m-d');
            $leave->start_date       = $request->start_date;
            $leave->end_date         = $request->end_date;
            $leave->total_leave_days = 0;
            $leave->leave_reason     = $request->leave_reason;
            $leave->remark           = $request->remark;
            $leave->status           = 'Pending';
            $leave->user_id          = Auth::user()->id;
            $leave->report_to        = $request->report_to;
            $leave->created_by       = \Auth::user()->creatorId();

            $leave->save();

            return redirect()->route('leave.index')->with('success', __('Leave  successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show(Leave $leave)
    {
        return redirect()->route('leave.index');
    }

    public function edit(Leave $leave)
    {
        if(\Auth::user()->can('Edit Leave'))
        {

            $user = Auth::user();

            if($leave->created_by == \Auth::user()->creatorId())
            {
                $employees  = Employee::where('user_id', '=', $leave->user_id)->get()->pluck('name', 'id');
                $leavetypes = LeaveType::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('title', 'id');

                $employee_info  = Employee::where('user_id', '=', $user->id)->get()->pluck('name','id');

                $report_info  = Employee::where([['user_id','=', $user->id]])
                ->select('roles.id','roles.name as role')
                ->join('roles', 'roles.id', '=', 'employees.report_to')->get();

                return view('leave.edit', compact('leave', 'employees', 'leavetypes','employee_info','report_info'));
            }

            else
            {
                return response()->json(['error' => __('Permission denied.')], 401);
            }
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function update(Request $request, $leave)
    {

        $leave = Leave::find($leave);
        if(\Auth::user()->can('Edit Leave'))
        {
            if($leave->created_by == Auth::user()->creatorId())
            {
                $validator = \Validator::make(
                    $request->all(), [
                                       'leave_type_id' => 'required',
                                       'start_date' => 'required',
                                       'end_date' => 'required',
                                       'leave_reason' => 'required',
                                       'remark' => 'required',
                                   ]
                );
                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $date        = \Auth::user()->created_at;
                $dateconvert = strtotime($date);
                $applied_on  = date('Y-m-d', $dateconvert);

                $leave->employee_id      = $request->employee_id;
                $leave->leave_type_id    = $request->leave_type_id;
                $leave->applied_on       = $applied_on;
                $leave->start_date       = $request->start_date;
                $leave->end_date         = $request->end_date;
                $leave->total_leave_days = 0;
                $leave->leave_reason     = $request->leave_reason;
                $leave->remark           = $request->remark;
                $leave->report_to        = $request->report_to;
                $leave->save();

                return redirect()->route('leave.index')->with('success', __('Leave successfully updated.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy(Leave $leave)
    {
        if(\Auth::user()->can('Delete Leave'))
        {
            if($leave->created_by == \Auth::user()->creatorId())
            {
                $leave->delete();

                return redirect()->route('leave.index')->with('success', __('Leave successfully deleted.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function action($id)
    {
        $leave     = Leave::find($id);
        $employee  = Employee::find($leave->employee_id);
        $leavetype = LeaveType::find($leave->leave_type_id);

        return view('leave.action', compact('employee', 'leavetype', 'leave'));
    }

    public function changeaction(Request $request)
    {

        $leave = Leave::find($request->leave_id);

        $leave->status = $request->status;
        if($leave->status == 'Approval')
        {
            $startDate               = new \DateTime($leave->start_date);
            $endDate                 = new \DateTime($leave->end_date);
            $total_leave_days        = $startDate->diff($endDate)->days+1;
            $leave->total_leave_days = $total_leave_days;
            $leave->status           = 'Approve';
            $leave->loss_of_pay      = $request->loss_of_pay;
        }

        $leave->save();

        $setings = Utility::settings();
        if($setings['leave_status'] == 1)
        {
            $employee     = Employee::where('id', $leave->employee_id)->where('created_by', '=', \Auth::user()->creatorId())->first();
            $leave->name  = !empty($employee->name) ? $employee->name : '';
            $leave->email = !empty($employee->email) ? $employee->email : '';
            try
            {
                Mail::to($leave->email)->send(new LeaveActionSend($leave));
            }
            catch(\Exception $e)
            {
                $smtp_error = __('E-Mail has been not sent due to SMTP configuration');
            }

            return redirect()->route('leave.index')->with('success', __('Leave status successfully updated.') . (isset($smtp_error) ? $smtp_error : ''));

        }

        return redirect()->route('leave.index')->with('success', __('Leave status successfully updated.'));
    }

    public function jsoncount(Request $request)
    {
//        $leave_counts = LeaveType::select(\DB::raw('COALESCE(SUM(leaves.total_leave_days),0) AS total_leave, leave_types.title, leave_types.days,leave_types.id'))->leftjoin(
//            'leaves', function ($join) use ($request){
//            $join->on('leaves.leave_type_id', '=', 'leave_types.id');
//            $join->where('leaves.employee_id', '=', $request->employee_id);
//        }
//        )->groupBy('leaves.leave_type_id')->get();

        $leave_counts = LeaveType::select(\DB::raw('COALESCE(SUM(leaves.total_leave_days),0) AS total_leave, leave_types.title, leave_types.days,leave_types.id'))
                                 ->leftjoin('leaves', function ($join) use ($request){
            $join->on('leaves.leave_type_id', '=', 'leave_types.id');
            $join->where('leaves.employee_id', '=', $request->employee_id);
        }
        )->groupBy('leaves.leave_type_id')->get();

        return $leave_counts;

    }
}
