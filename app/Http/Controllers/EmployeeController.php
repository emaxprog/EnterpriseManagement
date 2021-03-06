<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Traits\ResponseInfo;
use App\Http\Requests\StoreEmployeeRequest;
use App\Models\Repositories\EmployeeRepository;
use App\Models\Repositories\DepartmentRepository;

/**
 * Class EmployeeController
 * @package App\Http\Controllers
 */
class EmployeeController extends Controller
{
    use ResponseInfo;

    /**
     * @var EmployeeRepository
     */
    protected $repository;

    /**
     * @var
     */
    protected $departmentRepository;

    /**
     * EmployeeController constructor.
     * @param EmployeeRepository $repository
     * @param DepartmentRepository $departmentRepository
     */
    public function __construct(EmployeeRepository $repository, DepartmentRepository $departmentRepository)
    {
        $this->middleware('auth');
        $this->repository = $repository;
        $this->departmentRepository = $departmentRepository;
    }

    /**
     * Отображение списка сотрудников
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::paginate(10);
        return view('employees.index', ['employees' => $employees,]);
    }

    /**
     * Показ формы создания нового сотрудника
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = $this->departmentRepository->all();
        return view('employees.create', ['departments' => $departments]);
    }

    /**
     * Сохранение данных сотрудника
     *
     * @param StoreEmployeeRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function store(StoreEmployeeRequest $request)
    {
        try {
            if ($model = $this->repository->create($request->all())) {
                return $this->info('Сотрудник успешно добавлен.');
            }
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * Показ формы редактирования сотрудника
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        $departments = $this->departmentRepository->all();

        return view('employees.edit', [
            'employee' => $employee,
            'departments' => $departments,
        ]);
    }

    /**
     * Обновление данных сотрудника
     *
     * @param StoreEmployeeRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(StoreEmployeeRequest $request, $id)
    {
        $model = Employee::findOrFail($id);
        try {
            if ($model = $this->repository->update($model, $request->all())) {
                return $this->info('Данные сотрудника успешно изменены.');
            }
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * Удаление сотрудника
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $model = Employee::findOrFail($id);
        try {
            if ($this->repository->delete($model)) {
                return $this->info('Сотрудник успешно удален.');
            }
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
