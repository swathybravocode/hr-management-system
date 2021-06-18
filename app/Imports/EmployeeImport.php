<?php

namespace App\Imports;

use App\Employee;
use App\Allowance;
use App\SaturationDeduction;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class EmployeeImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            $login_id = DB::table('users')->insertGetId([
                'name' => $row[3],
                'email' => $row[9],
                'password' => Hash::make($row[10]),
                'type' => preg_replace('/\W+/','_', strtolower($row[15])),
                'lang' => 'en',
                'created_by' => '1'
            ]);

            Employee::create([
                'user_id' => $login_id,
                'name'     => $row[3],
                'middle_name' =>$row[4],
                'last_name' => $row[5],
                'employee_code' => $row[2],
                'old_employee_code' => $row[1],
                'dob'    => $row[8],
                'gender' => $row[6],
                'phone' => $row[3],
                'address' => $row[3],
                'email' => $row[3],
                'blood_group' => $row[11],
                'pan_card_number' => 'N/A',
                'aadhaar_card_number' => 'N/A',
                'employee_alternate_contact' => 'N/A',
                'head_quarter' => $row[12],
                'employee_id' => $row[13],
                'branch_id' => request('branch_id'),
                'department_id' => request('department_id'),
                'designation_id' => $row[14],
                'company_doj' => $row[16],
                'account_holder_name' => $row[3],
                'account_number' => 'N/A',
                'bank_name' => 'N/A',
                'bank_identifier_code' => 'N/A',
                'branch_location' => 'N/A',
                'tax_payer_id' => 'N/A',
                'salary_type' => '1',
                'salary' => $row[22],
                'created_by' => '1',
                'report_to' => '1'
            ]);

            $allowance['amount1'] = $row[23];
            $allowance['amount2'] = $row[24];
            $allowance['amount3'] = $row[25];

            $title['title1'] = 'DA';
            $title['title2'] = 'HRA';
            $title['title3'] = 'Others';

            $employee['emp1'] = $row[13];
            $employee['emp2'] = $row[13];
            $employee['emp3'] = $row[13];


            $imp_allowance = implode(',', $allowance);
            $imp_title = implode(',', $title);
            $imp_employee = implode(',', $employee);

            $imp_allowance = explode(',', $imp_allowance);
            $imp_title = explode(',', $imp_title);
            $imp_employee = explode(',', $imp_employee);

            foreach($imp_allowance as $key =>$data)
            {
                $option = 1;
                Allowance::create([
                        'employee_id' => $imp_employee[$key],
                        'allowance_option' => $key + $option,
                        'title' => $imp_title[$key],
                        'amount' => $data,
                        'created_by' =>'1',
                    ]);
            }         
            
            $deduction['deduction1'] = $row[26];
            $deduction['deduction2'] = $row[27];
            $deduction['deduction3'] = $row[28];
            $deduction['deduction4'] = $row[29];

            $deduction_title['title1'] = 'ESI';
            $deduction_title['title2'] = 'PF';
            $deduction_title['title3'] = 'TDS';
            $deduction_title['title4'] = 'Others';

            $deduction_employee['emp1'] = $row[13];
            $deduction_employee['emp2'] = $row[13];
            $deduction_employee['emp3'] = $row[13];
            $deduction_employee['emp4'] = $row[13];

            $imp_deduction = implode(',', $deduction);
            $imp_deduction_title = implode(',', $deduction_title);
            $imp_deduction_employee = implode(',', $deduction_employee);

            $imp_deduction = explode(',', $imp_deduction);
            $imp_deduction_title = explode(',', $imp_deduction_title);
            $imp_deduction_employee = explode(',', $imp_deduction_employee);

            foreach($imp_deduction as $ded_key =>$deductions)
            {
                $ded_option = 1;
                SaturationDeduction::create([
                        'employee_id' => $imp_deduction_employee[$ded_key],
                        'deduction_option' => $ded_key + $ded_option,
                        'title' => $imp_deduction_title[$ded_key],
                        'amount' => $deductions,
                        'created_by' =>'1',
                    ]);            
            }


           

            // SaturationDeduction::create([
            //     'employee_id' => '',
            //     'deduction_option' => '',
            //     'title' =>'',
            //     'amount' => '',
            //     'created_by' =>'1',
            // ]);
         }
    }
}
