<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Employee
 * @package App\Models
 */
class Employee extends Model
{
    public $timestamps = false;

    protected $fillable = ['name', 'surname', 'patronymic', 'gender', 'salary'];

    /**
     * Отделы
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function departments()
    {
        return $this->belongsToMany(Department::class);
    }
}
