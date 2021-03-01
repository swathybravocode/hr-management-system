<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Employee;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
        if(\Auth::user()->can('Manage Branch'))
        {
            $branches = Branch::where('created_by', '=', \Auth::user()->creatorId())->get();

            return view('branch.index', compact('branches'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if(\Auth::user()->can('Create Branch'))
        {
            return view('branch.create');
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    {
        if(\Auth::user()->can('Create Branch'))
        {

            $validator = \Validator::make(
                $request->all(), [
                                   'name' => 'required',
                                   'branch_name'=>'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $branch             = new Branch();
            $branch->name       = $request->name;
            $branch->branch_name = $request->branch_name;
            $branch->created_by = \Auth::user()->creatorId();
            $branch->save();

            return redirect()->route('branch.index')->with('success', __('Branch  successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show(Branch $branch)
    {
        return redirect()->route('branch.index');
    }

    public function edit(Branch $branch)
    {
        if(\Auth::user()->can('Edit Branch'))
        {
            if($branch->created_by == \Auth::user()->creatorId())
            {

                return view('branch.edit', compact('branch'));
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

    public function update(Request $request, Branch $branch)
    {
        if(\Auth::user()->can('Edit Branch'))
        {
            if($branch->created_by == \Auth::user()->creatorId())
            {
                $validator = \Validator::make(
                    $request->all(), [
                                       'name' => 'required',
                                       'branch_name'=>'required',
                                   ]
                );
                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $branch->name = $request->name;
                $branch->branch_name = $request->branch_name;
                $branch->save();

                return redirect()->route('branch.index')->with('success', __('Branch successfully updated.'));
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

    public function destroy(Branch $branch)
    {
        if(\Auth::user()->can('Delete Branch'))
        {
            if($branch->created_by == \Auth::user()->creatorId())
            {
                $branch->delete();

                return redirect()->route('branch.index')->with('success', __('Branch successfully deleted.'));
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

    public function getdepartment(Request $request)
    {

        if($request->branch_id == 0)
        {
            $departments = Department::get()->pluck('name', 'id')->toArray();
        }
        else
        {
            $departments = Department::where('branch_id', $request->branch_id)->get()->pluck('name', 'id')->toArray();
        }

        return response()->json($departments);
    }

    public function getemployee(Request $request)
    {
        if(in_array('0', $request->department_id))
        {
            $employees = Employee::get()->pluck('name', 'id')->toArray();
        }
        else
        {
            $employees = Employee::whereIn('department_id', $request->department_id)->get()->pluck('name', 'id')->toArray();
        }

        return response()->json($employees);
    }

    public function get_branch_code(Request $request)
    {
        $branch_id = $request->branch_id;

        $branch = Branch::where('id',$branch_id)->first();

        $emp_number  = $this->branchEmployeeNumber($branch_id);

        $num_start_final = 0;

        if($branch->name=='KL')
        {
            $branch_code = "IHC/".$branch->name."/0".$emp_number;
        }

        elseif($branch->name=='KR')
        {
            $num_start = 102;
            $num_start_final = $num_start+$emp_number;
            $branch_code = "IHC/".$branch->name."/".$num_start_final;

        }

        elseif($branch->name=='KA')
        {            
            $num_start = 1;
            $num_start = str_pad($num_start,3,"0",STR_PAD_LEFT); 
            $num_start_final = $num_start + $emp_number;

            $branch_code = "EY/".$branch->name."/".$num_start_final;
        }

        elseif($branch->name=='TN')
        {
            $num_start = 100;
            $num_start_final = $num_start+$emp_number;

            $branch_code = "IHC/".$branch->name."/".$num_start_final;
        }

        return response()->json($branch_code);

    }

    public function branchEmployeeNumber($branch_id)
    {
        $latest = Employee::where([['created_by', '=', \Auth::user()->creatorId()], ['branch_id','=', $branch_id]])->latest()->first();

        $arr_emp = Employee::where('branch_id','=', $branch_id)->get();
        $count = count($arr_emp);

        if(!$latest)
        {
            return 1;
        }

        return $count;

    }
}
