<?php

namespace App\Http\Controllers;

use App\Department;
use App\Employee;
use App\Http\Requests\StoreEmployeeRequest;
use Illuminate\Http\Request;
use League\Flysystem\Exception;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('employees.index');
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
        $departments = $request->departments;
        try {
            $employee = new Employee();
            $employee->name = $request->name;
            $employee->surname = $request->surname;
            $employee->patronymic = $request->patronymic;
            $employee->gender = $request->gender;
            $employee->salary = $request->salary;
            if (!$employee->save()) {
                throw new Exception('Произошла ошибка при сохранении!');
            }
            $insertedId = $employee->employee_id;

            $insertedEmployee = Employee::find($insertedId);

            foreach ($departments as $department) {
                $insertedEmployee->departments()->attach((int)$department);
            }

            foreach ($insertedEmployee->departments as $dep) {
                $dep->max_salary = $dep->employees->max('salary');
                $dep->count_employees = $dep->employees->count();
                $dep->save();
            }
            return 'Сотрудник успешно добавлен!';
        } catch (Exception $e) {
            return $e->getMessage();
        }
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
