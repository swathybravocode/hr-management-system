<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\Manager;
use App\Utility;
use App\Branch;
use App\Department;
use App\User;
use App\Mail\UserCreate;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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
                $managers = Manager::all();
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
                                   'manager_last_name' => 'required|string',
                                   'manager_contact' => 'required|numeric',
                                   'date_of_birth' => 'required|string',
                                   'gender' => 'required|string',
                                   'email' => 'required|unique:users|string',
                                   'password' => 'required|string',
                                   'address' => 'required|string',
                                   'department_id' => 'required',
                                   'manager_type' => 'required',

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
                    'manager_name' => $request['manager_name'],
                    'manager_last_name' => $request['manager_last_name'],
                    'manager_contact' => $request['manager_contact'],
                    'date_of_birth' => $request['date_of_birth'],
                    'manager_email' => $request['email'],
                    'manager_type' => $request['manager_type'],
                    'manager_branch_id' => $request['branch_id'],
                    'gender' => $request['gender'],
                    'address' => $request['address'],
                    'manager_department_id' => $request['department_id'],
                ]);

            $setings = Utility::settings();

            if($setings['manager_create'] == 1)
            {
                $user->type     = 'Manager';
                $user->password = $request['password'];
                try
                {
                    Mail::to($user->email)->send(new UserCreate($user));
                }
                catch(\Exception $e)
                {
                    $smtp_error = __('E-Mail has been not sent due to SMTP configuration');
                }

                return redirect()->route('manager.index')->with('success', __('Manager successfully created.') . (isset($smtp_error) ? $smtp_error : ''));

            }

            return redirect()->route('manager.index')->with('success', __('Manager  successfully created.'));

        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);

        if(\Auth::user()->can('Edit Employee'))
        {
            $manager      = Manager::where('manager_id', '=', $id)->first();
            $branches     = Branch::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $departments  = Department::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $designations = Designation::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');

            return view('manager.edit', compact('manager', 'branches','departments','designations'));

        }

    }

    public function update(Request $request, $id)
    {
        if(\Auth::user()->can('Edit Employee'))
        {
            $validator = \Validator::make(
                $request->all(), [
                    'manager_name' => 'required|string',
                    'manager_last_name' => 'required|string',
                    'date_of_birth' => 'required|string',
                    'gender' => 'required|string',
                    'email' => 'required|string',
                    'address' => 'required|string',
                    'department_id' => 'required',
                    'manager_type' => 'required']);

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $manager = Manager::findOrFail($id);
            $input    = $request->all();
            $manager->fill($input)->save();

            if(\Auth::user()->type != 'manager')
            {
                return redirect()->route('manager.index')->with('success', 'Manager successfully updated.');
            }
            else
            {
                return redirect()->route('manager.show', \Illuminate\Support\Facades\Crypt::encrypt($manager->manager_id))->with('success', 'Manager successfully updated.');
            }

        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
