<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Department;
use App\Designation;
use App\Document;
use App\Employee;
use App\EmployeeDocument;
use App\Mail\UserCreate;
use App\User;
use Spatie\Permission\Models\Role;
use App\Utility;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

//use Faker\Provider\File;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(\Auth::user()->can('Manage Employee'))
        {
            if(Auth::user()->type == 'employee')
            {
                $employees = Employee::where('user_id', '=', Auth::user()->id)->get();
            }
            else
            {
                $employees = Employee::where('created_by', \Auth::user()->creatorId())->get();
            }

            return view('employee.index', compact('employees'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if(\Auth::user()->can('Create Employee'))
        {
            $company_settings = Utility::settings();
            $documents        = Document::where('created_by', \Auth::user()->creatorId())->get();
            $branches         = Branch::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $departments      = Department::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $designations     = Designation::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $employees        = User::where('created_by', \Auth::user()->creatorId())->get();
            $employeesId      = \Auth::user()->employeeIdFormat($this->employeeNumber());

            $roles            = Role::where('created_by', '=', \Auth::user()->creatorId())->get();

            $all_branches     = Branch::all();


            if($all_branches==null)
            {
                $employee_number  = $this->branchEmployeeNumber($all_branches[0]->id);
            }
            else
            {
                $employee_number = '0';
            }

            return view('employee.create', compact('employees', 'employeesId',
            'departments', 'designations', 'documents', 'branches', 'company_settings','employee_number', 'roles'));
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
                                   'name' => 'required|string',
                                   'dob' => 'required|string',
                                   'gender' => 'required|string',
                                   'phone' => 'required|numeric',
                                   'employee_code' => 'required|string',
                                   'old_employee_code' => 'required|string',
                                   'aadhaar_card_number' => 'required|string',
                                   'employee_alternate_contact'=>'required|numeric',
                                   'pan_card_number' => 'required|string',
                                   'last_name' => 'required|string',
                                   'address' => 'required|string',
                                   'email' => 'required|unique:users|string',
                                   'password' => 'required|string',
                                   'department_id' => 'required',
                                   'designation_id' => 'required',
                                   'employee_photo.*' =>'mimes:jpeg,png,jpg,JPEG,PNG,JPG|max:20480',
                                   'document.*' => 'mimes:jpeg,png,jpg,gif,svg,pdf,doc,zip|max:20480',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->withInput()->with('error', $messages->first());
            }

            if($request->hasFile('employee_photo'))
            {
                $file_name_slug = preg_replace('/\W+/', '-', strtolower($request->name));
                $filenameWithExt = $request->file('employee_photo')->getClientOriginalName();
                $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension       = $request->file('employee_photo')->getClientOriginalExtension();
                $photoNameToStore = $file_name_slug . '_' . time() . '.' . $extension;
                $dir             = storage_path('uploads/avatar/');
                $image_path      = $dir . $photoNameToStore;

                if(File::exists($image_path))
                {
                    File::delete($image_path);
                }
                if(!file_exists($dir))
                {
                    mkdir($dir, 0777, true);
                }
                $path = $request->file('employee_photo')->storeAs('uploads/avatar/', $photoNameToStore);

            }

                // if(!empty($request->profile))
                // {
                //     $user['avatar'] = $fileNameToStore;
                // }

                $user = User::create(
                    [
                        'name' => $request['name'],
                        'email' => $request['email'],
                        'password' => Hash::make($request['password']),
                        'avatar' => $photoNameToStore,
                        'type' => 'employee',
                        'lang' => 'en',
                        'created_by' => \Auth::user()->creatorId(),
                    ]
                );
                $user->save();
                $user->assignRole('Employee');


                if(!empty($request->document) && !is_null($request->document))
                {
                    $document_implode = implode(',', array_keys($request->document));
                }
                else
                {
                    $document_implode = null;
                }


            $employee = Employee::create(
                [
                    'user_id' => $user->id,
                    'name' => $request['name'],
                    'dob' => $request['dob'],
                    'gender' => $request['gender'],
                    'phone' => $request['phone'],
                    'address' => $request['address'],
                    'email' => $request['email'],
                    'password' => Hash::make($request['password']),
                    'employee_id' => $this->employeeNumber(),
                    'branch_id' => $request['branch_id'],
                    'department_id' => $request['department_id'],
                    'designation_id' => $request['designation_id'],
                    'company_doj' => $request['company_doj'],
                    'documents' => $document_implode,
                    'account_holder_name' => $request['account_holder_name'],
                    'account_number' => $request['account_number'],
                    'bank_name' => $request['bank_name'],
                    'bank_identifier_code' => $request['bank_identifier_code'],
                    'branch_location' => $request['branch_location'],
                    'tax_payer_id' => $request['tax_payer_id'],
                    'created_by' => \Auth::user()->creatorId(),
                    'blood_group' => $request['blood_group'],
                    'head_quarter' => $request['head_quarter'],
                    'middle_name' => $request['middle_name'],
                    'last_name' => $request['last_name'],
                    'employee_code' => $request['employee_code'],
                    'old_employee_code' => $request['old_employee_code'],
                    'pan_card_number' => $request['pan_card_number'],
                    'aadhaar_card_number' => $request['aadhaar_card_number'],
                    'employee_alternate_contact' => $request['employee_alternate_contact'],
                    'employee_photo' => $photoNameToStore,

                ]
            );

            if($request->hasFile('document'))
            {
                foreach($request->document as $key => $document)
                {

                    $filenameWithExt = $request->file('document')[$key]->getClientOriginalName();
                    $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension       = $request->file('document')[$key]->getClientOriginalExtension();
                    $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                    $dir             = storage_path('uploads/document/');
                    $image_path      = $dir . $filenameWithExt;

                    if(File::exists($image_path))
                    {
                        File::delete($image_path);
                    }

                    if(!file_exists($dir))
                    {
                        mkdir($dir, 0777, true);
                    }
                    $path              = $request->file('document')[$key]->storeAs('uploads/document/', $fileNameToStore);
                    $employee_document = EmployeeDocument::create(
                        [
                            'employee_id' => $employee['employee_id'],
                            'document_id' => $key,
                            'document_value' => $fileNameToStore,
                            'created_by' => \Auth::user()->creatorId(),
                        ]
                    );
                    $employee_document->save();

                }

            }

            $setings = Utility::settings();
            if($setings['employee_create'] == 1)
            {
                $user->type     = 'Employee';
                $user->password = $request['password'];
                try
                {
                    Mail::to($user->email)->send(new UserCreate($user));
                }
                catch(\Exception $e)
                {
                    $smtp_error = __('E-Mail has been not sent due to SMTP configuration');
                }

                return redirect()->route('employee.index')->with('success', __('Employee successfully created.') . (isset($smtp_error) ? $smtp_error : ''));

            }


            return redirect()->route('employee.index')->with('success', __('Employee  successfully created.'));

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
            $documents    = Document::where('created_by', \Auth::user()->creatorId())->get();
            $branches     = Branch::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $departments  = Department::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $designations = Designation::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $employee     = Employee::find($id);
            $employeesId  = \Auth::user()->employeeIdFormat($employee->employee_id);

            $employee_number  = $this->employeeNumber();

            return view('employee.edit', compact('employee', 'employeesId', 'branches', 'departments', 'designations', 'documents', 'employee_number'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function update(Request $request, $id)
    {

        if(\Auth::user()->can('Edit Employee'))
        {
            $user       = User::findOrFail($request->user_id);

            $validator = \Validator::make(
                $request->all(), [
                    'name' => 'required|string',
                                   'employee_code' => 'required|string',
                                   'old_employee_code' => 'required|string',
                                   'employee_alternate_contact'=>'required|numeric',
                                   'pan_card_number' => 'required|string',
                                   'department_id' => 'required',
                                   'designation_id' => 'required',
                                   'name' => 'required',
                                   'dob' => 'required',
                                   'gender' => 'required',
                                   'aadhaar_card_number' => 'required|string',
                                   'last_name' => 'required|string',
                                   'phone' => 'required|numeric',
                                   'address' => 'required',
                                   'document.*' => 'mimes:jpeg,png,jpg,gif,svg,pdf,doc,zip|max:20480',
                                   'employee_photo.*' =>'mimes:jpeg,png,jpg,JPEG,PNG,JPG|max:20480',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $employee = Employee::findOrFail($id);
            $old_employee_photo = $employee->employee_photo;

            if($request->hasFile('employee_photo'))
            {
                $file_name_slug = preg_replace('/\W+/', '-', strtolower($request->name));
                $filenameWithExt = $request->file('employee_photo')->getClientOriginalName();
                $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension       = $request->file('employee_photo')->getClientOriginalExtension();
                $photoNameToStore = $file_name_slug . '_' . time() . '.' . $extension;
                $dir             = storage_path('uploads/avatar/');
                $image_path      = $dir . $photoNameToStore;

                if(File::exists($dir . $old_employee_photo))
                {
                    File::delete($dir . $old_employee_photo);
                }
                if(!file_exists($dir))
                {
                    mkdir($dir, 0777, true);
                }

                $path = $request->file('employee_photo')->storeAs('uploads/avatar/', $photoNameToStore);

            }

            if($request->document)
            {

                foreach($request->document as $key => $document)
                {
                    if(!empty($document))
                    {
                        $filenameWithExt = $request->file('document')[$key]->getClientOriginalName();
                        $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                        $extension       = $request->file('document')[$key]->getClientOriginalExtension();
                        $fileNameToStore = $filename . '_' . time() . '.' . $extension;

                        $dir        = storage_path('uploads/document/');
                        $image_path = $dir . $filenameWithExt;

                        if(File::exists($image_path))
                        {
                            File::delete($image_path);
                        }
                        if(!file_exists($dir))
                        {
                            mkdir($dir, 0777, true);
                        }
                        $path = $request->file('document')[$key]->storeAs('uploads/document/', $fileNameToStore);


                        $employee_document = EmployeeDocument::where('employee_id', $employee->employee_id)->where('document_id', $key)->first();

                        if(!empty($employee_document))
                        {
                            $employee_document->document_value = $fileNameToStore;
                            $employee_document->save();
                        }
                        else
                        {
                            $employee_document                 = new EmployeeDocument();
                            $employee_document->employee_id    = $employee->employee_id;
                            $employee_document->document_id    = $key;
                            $employee_document->document_value = $fileNameToStore;
                            $employee_document->save();
                        }

                    }
                }
            }

            $employee = Employee::findOrFail($id);
            $input    = $request->all();
            $input['employee_photo'] = $photoNameToStore;
            $employee->fill($input)->save();

            $user['avatar'] = $photoNameToStore;
            $user->save();

            if($request->salary)
            {
                return redirect()->route('setsalary.index')->with('success', 'Employee successfully updated.');
            }

            if(\Auth::user()->type != 'employee')
            {
                return redirect()->route('employee.index')->with('success', 'Employee successfully updated.');
            }
            else
            {
                return redirect()->route('employee.show', \Illuminate\Support\Facades\Crypt::encrypt($employee->id))->with('success', 'Employee successfully updated.');
            }

        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy($id)
    {

        if(Auth::user()->can('Delete Employee'))
        {
            $employee      = Employee::findOrFail($id);
            $user          = User::where('id', '=', $employee->user_id)->first();
            $emp_documents = EmployeeDocument::where('employee_id', $employee->employee_id)->get();
            $employee->delete();
            $user->delete();
            $dir = storage_path('uploads/document/');
            foreach($emp_documents as $emp_document)
            {
                $emp_document->delete();
                if(!empty($emp_document->document_value))
                {
                    unlink($dir . $emp_document->document_value);
                }

            }

            return redirect()->route('employee.index')->with('success', 'Employee successfully deleted.');
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }

    public function show($id)
    {

        if(\Auth::user()->can('Show Employee'))
        {
            $empId        = Crypt::decrypt($id);
            $documents    = Document::where('created_by', \Auth::user()->creatorId())->get();
            $branches     = Branch::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $departments  = Department::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $designations = Designation::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $employee     = Employee::find($empId);
            $employeesId  = \Auth::user()->employeeIdFormat($employee->employee_id);

            return view('employee.show', compact('employee', 'employeesId', 'branches', 'departments', 'designations', 'documents'));
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

    function employeeNumber()
    {
        $latest = Employee::where('created_by', '=', \Auth::user()->creatorId())->latest()->first();
        if(!$latest)
        {
            return 1;
        }

        return $latest->employee_id + 1;
    }

    public function branchEmployeeNumber($branch_id)
    {
        $latest = Employee::where([['created_by', '=', \Auth::user()->creatorId()], ['branch_id','=', $branch_id]])->latest()->first();
        if(!$latest)
        {
            return 1;
        }

        return $latest->employee_id + 1;

    }

    public function profile(Request $request)
    {
        if(\Auth::user()->can('Manage Employee Profile'))
        {
            $employees = Employee::where('created_by', \Auth::user()->creatorId());
            if(!empty($request->branch))
            {
                $employees->where('branch_id', $request->branch);
            }
            if(!empty($request->department))
            {
                $employees->where('department_id', $request->department);
            }
            if(!empty($request->designation))
            {
                $employees->where('designation_id', $request->designation);
            }
            $employees = $employees->get();

            $brances = Branch::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $brances->prepend('All', '');

            $departments = Department::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $departments->prepend('All', '');

            $designations = Designation::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $designations->prepend('All', '');

            return view('employee.profile', compact('employees', 'departments', 'designations', 'brances'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function profileShow($id)
    {
        if(\Auth::user()->can('Show Employee Profile'))
        {
            $empId        = Crypt::decrypt($id);
            $documents    = Document::where('created_by', \Auth::user()->creatorId())->get();
            $branches     = Branch::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $departments  = Department::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $designations = Designation::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $employee     = Employee::find($empId);
            $employeesId  = \Auth::user()->employeeIdFormat($employee->employee_id);

            return view('employee.show', compact('employee', 'employeesId', 'branches', 'departments', 'designations', 'documents'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function deactivate_employee($id)
    {
        if(\Auth::user()->can('Show Employee Profile'))
        {
            $empId  = Crypt::decrypt($id);

            $data['is_active'] = '0';

            // User::find(request('user_id'))->update($data);
            DB::table('users')->where('id', $empId)->update($data);
            DB::table('employees')->where('user_id', $empId)->update($data);


            return redirect()->route('employee.profile')->with('success', 'Employee successfully deactivated.');

        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }

    public function activate_employee($id)
    {
        if(\Auth::user()->can('Show Employee Profile'))
        {
            $empId  = Crypt::decrypt($id);

            $data['is_active'] = '1';

            DB::table('users')->where('id', $empId)->update($data);
            DB::table('employees')->where('user_id', $empId)->update($data);


            return redirect()->route('employee.profile')->with('success', 'Employee successfully activated.');

        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }

    public function lastLogin()
    {
        $users = User::where('created_by', \Auth::user()->creatorId())->get();

        return view('employee.lastLogin', compact('users'));
    }

    public function employeeJson(Request $request)
    {
        $employees = Employee::where('branch_id', $request->branch)->get()->pluck('name', 'id')->toArray();

        return response()->json($employees);
    }

    public function get_employee_info(Request $request)
    {
        $emp_id = $request->employee_id;

        $employee     = Employee::where('id', '=', $emp_id)->first();

        return  response()->json(collect([
            'old_employee_code' => $employee->employee_code,
            'old_branch_id' => $employee->branch_id,
            'old_department_id' => $employee->department_id,
        ])->toJson());
    }
}
