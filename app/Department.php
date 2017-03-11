<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public $timestamps = false;

    public $primaryKey = 'department_id';

    public function employees()
    {
        return $this->belongsToMany('App\Employee', 'department_employee', 'department_id', 'employee_id');
    }
}
