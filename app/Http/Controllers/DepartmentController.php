<?php

namespace App\Http\Controllers;

use App\Department;
use App\Http\Requests\StoreDepartmentRequest;
use Illuminate\Http\Request;
use League\Flysystem\Exception;

class DepartmentController extends Controller
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
        $departments = Department::paginate(10);

        $data = [
            'departments' => $departments
        ];

        return view('departments.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('departments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, StoreDepartmentRequest $departmentRequest)
    {
        $department = new Department();
        $department->name = $request->name;

        if (!$department->save()) {
            return response()->json(['content' => 'Произошла ошибка при сохранении'], 500);
        }

        return 'Отдел успешно сохранен!';
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
        $department = Department::find($id);

        $data = [
            'department' => $department,
        ];

        return view('departments.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, StoreDepartmentRequest $departmentRequest)
    {
        $department = Department::find($id);
        $department->name = $request->name;

        if (!$department->save()) {
            return response()->json(['content' => 'Произошла ошибка при сохранении измененных данных'], 500);
        }

        return 'Данные отдела успешно изменены!';
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Department::destroy($id)) {
            return response()->json(['content' => 'Произошла ошибка при удалении отдела'], 500);
        }

        return 'Отдел успешно удален';
    }
}
