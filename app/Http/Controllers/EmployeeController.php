<?php

namespace App\Http\Controllers;

use App\Department;
use App\Employee;
use App\Http\Requests\StoreEmployeeRequest;
use Illuminate\Http\Request;
use League\Flysystem\Exception;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::paginate(10);

        $data = [
            'employees' => $employees,
        ];

        return view('employees.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::all();

        $data = [
            'departments' => $departments,
        ];

        return view('employees.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, StoreEmployeeRequest $employeeRequest)
    {
        if (!$departments = $request->departments) {
            return response()->json(['content' => 'Нельзя создать сотрудника не указав ему хотя бы один отдел'], 500);
        }

        $employee = new Employee();
        $employee->name = $request->name;
        $employee->surname = $request->surname;
        $employee->patronymic = $request->patronymic;
        $employee->gender = $request->gender;
        $employee->salary = $request->salary;
        if (!$employee->save()) {
            return response()->json(['content' => 'Произошла ошибка при сохранении!'], 500);
        }
        $insertedId = $employee->employee_id;

        $insertedEmployee = Employee::find($insertedId);

        foreach ($departments as $department) {
            $insertedEmployee->departments()->attach((int)$department);
        }

        foreach ($insertedEmployee->departments as $dep) {
            $dep->max_salary = $dep->employees->max('salary');
            $dep->count_employees = $dep->employees->count();
            if (!$dep->save()) {
                return response()->json(['content' => 'Произошла ошибка при изменении данных об отделах, в которых работал сотрудник!'], 500);
            }
        }

        return 'Сотрудник успешно добавлен!';
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = Employee::find($id);
        $departments = Department::all();

        $data = [
            'employee' => $employee,
            'departments' => $departments,
        ];

        return view('employees.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, StoreEmployeeRequest $employeeRequest)
    {
        if (!$departments = $request->departments) {
            return response()->json(['content' => 'Нельзя сохранить изменения сотрудника не указав ему хотя бы один отдел'], 500);
        }

        $employee = Employee::find($id);
        $oldDepartments = $employee->departments;

        $employee->name = $request->name;
        $employee->surname = $request->surname;
        $employee->patronymic = $request->patronymic;
        $employee->gender = $request->gender;
        $employee->salary = $request->salary;

        if (!$employee->save()) {
            return response()->json(['content' => 'Произошла ошибка при сохранении измененных данных!'], 500);
        }

        $updatedId = $employee->employee_id;

        $updatedEmployee = Employee::find($updatedId);

        $updatedEmployee->departments()->detach();

        foreach ($departments as $department) {
            $updatedEmployee->departments()->attach((int)$department);
        }

        $commonDepartments = $oldDepartments->merge($updatedEmployee->departments);


        foreach ($commonDepartments as $dep) {
            $dep->max_salary = $dep->employees->max('salary');
            $dep->count_employees = $dep->employees->count();
            if (!$dep->save()) {
                return response()->json(['content' => 'Произошла ошибка при изменении данных об отделах, в которых работал сотрудник!'], 500);
            }
        }

        return 'Данные сотрудника успешно изменены!';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);
        $oldDepartments = $employee->departments;

        if (!Employee::destroy($id)) {
            return request()->json(['content' => 'Произошла ошибка при удалении сотрудника!'], 500);
        }

        foreach ($oldDepartments as $dep) {
            $dep->max_salary = $dep->employees->max('salary');
            $dep->count_employees = $dep->employees->count();
            if (!$dep->save()) {
                return response()->json(['content' => 'Произошла ошибка при изменении данных об отделах, в которых работал сотрудник!'], 500);
            }
        }

        return 'Сотрудник успешно удален!';
    }
}
