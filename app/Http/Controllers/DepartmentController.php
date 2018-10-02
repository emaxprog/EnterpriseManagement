<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Http\Requests\StoreDepartmentRequest;
use App\Models\Repositories\DepartmentRepository;

/**
 * Class DepartmentController
 * @package App\Http\Controllers
 */
class DepartmentController extends Controller
{
    /**
     * @var DepartmentRepository
     */
    protected $repository;

    /**
     * DepartmentController constructor.
     * @param DepartmentRepository $repository
     */
    public function __construct(DepartmentRepository $repository)
    {
        $this->middleware('auth');
        $this->repository = $repository;
    }

    /**
     * Отображение списка отделов
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::paginate(10);
        return view('departments.index', ['departments' => $departments]);
    }

    /**
     * Показ формы создания нового отдела
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('departments.create');
    }

    /**
     * Сохранение данных нового отдела
     *
     * @param StoreDepartmentRequest $request
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function store(StoreDepartmentRequest $request)
    {
        try {
            if ($this->repository->create($request->all())) {
                return response()->json(['content' => 'Отдел успешно сохранен!']);
            }
        } catch (\Exception $e) {
            return response()->json(['content' => $e->getMessage()], 500);
        }
    }

    /**
     * Показ формы редактирования отдела
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('departments.edit', ['department' => Department::findOrFail($id)]);
    }

    /**
     * Обновление данных отдела
     *
     * @param StoreDepartmentRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreDepartmentRequest $request, $id)
    {
        try {
            if ($this->repository->update(Department::findOrFail($id), $request->all())) {
                return response()->json(['content' => 'Данные отдела успешно изменены!']);
            }
        } catch (\Exception $e) {
            return response()->json(['content' => $e->getMessage()], 500);
        }
    }


    /**
     * Удаление отдела
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $department = Department::findOrFail($id);

        try {
            if ($this->repository->delete($department)) {
                return response()->json(['content' => 'Отдел успешно удален.']);
            }
        } catch (\Exception $e) {
            return response()->json(['content' => $e->getMessage()], 500);
        }
    }
}
