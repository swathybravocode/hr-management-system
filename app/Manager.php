<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    protected $fillable = [
        'manager_name',
        'manager_email',
        'manager_contact',
        'manager_type',
        'created_by',
        'created_at',
        'updated_at',
    ];
}
