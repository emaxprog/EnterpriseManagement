<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Department
 * @package App\Models
 */
class Department extends Model
{
    public $timestamps = false;

    protected $fillable = ['name'];

    /**
     * Сотрудники
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function employees()
    {
        return $this->belongsToMany(Employee::class);
    }

    /**
     * Максимальная заработная плата в отделе
     *
     * @return mixed
     */
    public function maxSalary()
    {
        return $this->employees()->max('salary');
    }

    /**
     * Кол-во сотрудников в отделе
     *
     * @return mixed
     */
    public function countEmployees()
    {
        return $this->employees()->count();
    }
}
