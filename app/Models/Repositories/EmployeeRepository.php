<?php

namespace App\Models\Repositories;

use App\Models\Employee;
use Illuminate\Support\Facades\DB;

/**
 * Class EmployeeRepository
 * @package App\Models\Repositories
 */
class EmployeeRepository
{
    protected $departmentRepository;

    /**
     * EmployeeRepository constructor.
     * @param DepartmentRepository $departmentRepository
     */
    public function __construct(DepartmentRepository $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }

    /**
     * Создание и заполнение модели обязательными полями
     *
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    public function create($data)
    {
        $model = new Employee();
        if ($this->update($model, $data)) {
            return $model;
        }
    }

    /**
     * Поиск и обновление модели обязательными полями
     *
     * @param $model
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    public function update($model, $data)
    {
        $departments = isset($data['departments']) ? $data['departments'] : [];

        if (empty($departments)) {
            throw new \Exception('Сотрудник должен числиться хотя бы в одном отделе.');
        }

        DB::beginTransaction();

        $model->fill($data);

        if (!$model->save()) {
            throw new \Exception('Произошла ошибка при сохранении.');
        }

        if (!$model->departments()->sync($departments)) {
            throw new \Exception('Произошла ошибка при сохранении отделов.');
        }

        DB::commit();

        return true;
    }

    /**
     * Удаление модели
     *
     * @param $model
     * @return bool
     * @throws \Exception
     */
    public function delete($model)
    {
        if (!Employee::destroy($model->id)) {
            throw new \Exception('Произошла ошибка при удалении сотрудника.');
        }

        return true;
    }
}
