<?php

namespace App\Models\Repositories;

use App\Models\Department;
use Illuminate\Support\Facades\Cache;

/**
 * Class DepartmentRepository
 * @package App\Models\Repositories
 */
class DepartmentRepository
{
    const CACHE_TIME = 10;

    /**
     * Создание и заполнение модели обязательными полями
     *
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    public function create($data)
    {
        $model = new Department();

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
        $model->fill($data);

        if ($model->save()) {
            $this->updateCache();
            return true;
        }

        throw new \Exception('Произошла ошибка при сохранении измененных данных');
    }

    /**
     * Удаление модели
     *
     * @param $department
     * @return bool
     * @throws \Exception
     */
    public function delete($department)
    {
        if (!$this->isEmpty($department)) {
            throw new \Exception('Нельзя удалить отдел в котором есть сотрудники');
        }

        if (!Department::destroy($department->id)) {
            throw new \Exception('Произошла ошибка при удалении отдела');
        }

        return true;
    }

    /**
     * Получить все отделы
     *
     * @return mixed
     */
    public function all()
    {
        if (Cache::has('departments')) {
            $data = Cache::get('departments');
        } else {
            $data = Cache::remember('departments', static::CACHE_TIME, function () {
                return Department::all();
            });
        }
        return $data;
    }

    /**
     * Обновление кэша
     */
    public function updateCache()
    {
        Cache::forget('departments');
        Cache::put('departments', Department::all(), static::CACHE_TIME);
    }

    /**
     * Проверка на пустоту отдела
     *
     * @param $department
     * @return bool
     */
    public function isEmpty($department)
    {
        return !$department->employees->count();
    }
}
