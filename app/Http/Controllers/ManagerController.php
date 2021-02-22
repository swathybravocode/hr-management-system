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

    public function store(Request $request)
    {
        if(\Auth::user()->can('Create Employee'))
        {
            $validator = \Validator::make(
                $request->all(), [
                                   'manager_name' => 'required|string',
                                   'last_name' => 'required|string',
                                   'phone' => 'required|numeric',
                                   'date_of_birth' => 'required|string',
                                   'gender' => 'required|string',
                                   'email' => 'required|unique:users|string',
                                   'password' => 'required|string',
                                   'address' => 'required|string',
                                   'department_id' => 'required',
                                   'designation_id' => 'required',

                                   ]);

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->withInput()->with('error', $messages->first());
            }

            $user = User::create(
                [
                    'name' => $request['manager_name'],
                    'email' => $request['email'],
                    'password' => Hash::make($request['password']),
                    'type' => 'manager',
                    'lang' => 'en',
                    'created_by' => \Auth::user()->creatorId(),
                ]
            );
            $user->save();
            $user->assignRole('Manager');

            $manager = Manager::create(
                [
                    'user_id' => $user->id,
                    'manager_name' => $request['manager_name']." ".$request['last_name'],
                    'manager_contact' => $request['manager_contact'],
                    'date_of_birth' => $request['date_of_birth'],
                    'manager_email'
                ]);

        }
    }
}
