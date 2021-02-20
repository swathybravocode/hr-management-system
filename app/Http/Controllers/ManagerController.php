<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\Manager;
use App\Utility;
use App\Branch;
use App\Department;

use Illuminate\Support\Facades\Auth;
use App\Designation;

class ManagerController extends Controller
{
    public function index()
    {
        if(\Auth::user()->can('Manage Employee'))
        {
            if(Auth::user()->type == 'manager')
            {
                $managers = Manager::where('user_id', '=', Auth::user()->id)->get();
            }
            else
            {
                $managers = Manager::where('created_by', \Auth::user()->creatorId())->get();
            }

            return view('manager.index', compact('managers'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function json(Request $request)
    {
        $designations = Designation::where('department_id', $request->department_id)->get()->pluck('name', 'id')->toArray();

        return response()->json($designations);
    }

    public function create()
    {
        if(\Auth::user()->can('Create Employee'))
        {
            $company_settings = Utility::settings();
            $branches         = Branch::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $departments      = Department::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $designations     = Designation::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');


            return view('manager.create', compact('departments', 'designations', 'branches', 'company_settings'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function store()
    {
        if(\Auth::user()->can('Create Employee'))
        {
            $validator = \Validator::make(
                $request->all(), [
                                   'name' => 'required|string',
                                   'last_name' => 'required|string',
                                   'phone' => 'required|numeric',
                                   'date_of_birth' => 'required|string',
                                   'gender' => 'required|string',
                                   'email' => 'required|unique:users|string',
                                   'password' => 'required|string',
                                   ]);
        }
    }
}
