<?php

namespace App\Imports;

use App\Employee;
use App\Allowance;
use App\SaturationDeduction;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class EmployeeImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(Collection $rows)
    {
        foreach ($rows as $row)
        {
            Employee::create([
                'user_id' => '',
                'name'     => $row['name'],
                'middle_name' =>'',
                'last_name' => '',
                'employee_code' => '',
                'old_employee_code' => '',
                'dob'    => $row['email'],
                'gender' => Hash::make($row['password']),
                'phone' => '',
                'address' => '',
                'email' => '',
                'blood_group' => '',
                'pan_card_number' => '',
                'aadhaar_card_number' => '',
                'employee_alternate_contact' => '',
                'head_quarter' => '',
                'employee_id' => '',
                'branch_id' => '',
                'department_id' => '',
                'designation_id' => '',
                'company_doj' => '',
                'account_holder_name' => '',
                'account_number' => '',
                'bank_name' => '',
                'bank_identifier_code' => '',
                'branch_location' => '',
                'tax_payer_id' => '',
                'salary_type' => '',
                'salary' => '',
                'created_by' => '',
                'report_to' => ''
            ]);

            Allowance::create([
                'employee_id' =>'',
                'allowance_option' => '',
                'title' => '',
                'amount' => '',
                'created_by' =>'1',
            ]);

            SaturationDeduction::create([
                'employee_id' => '',
                'deduction_option' => '',
                'title' =>'',
                'amount' => '',
                'created_by' =>'1',
            ]);
         }
    }
}
