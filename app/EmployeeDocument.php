<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeDocument extends Model
{
    protected $fillable = [
        'employee_id','document_id','description','document_value','created_by'
    ];
}
