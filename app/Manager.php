<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    protected $fillable = [
        'user_id',
        'manager_branch_id',
        'manager_name',
        'manager_email',
        'date_of_birth',
        'gender',
        'address',
        'manager_contact',
        'manager_type',
        'created_by',
        'created_at',
        'updated_at',
    ];
}
