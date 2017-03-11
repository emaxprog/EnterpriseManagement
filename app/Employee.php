<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public $timestamps = false;

    public $primaryKey = 'employee_id';

    public function departments()
    {
        return $this->belongsToMany('App\Department', 'department_employee', 'employee_id', 'department_id');
    }
}
