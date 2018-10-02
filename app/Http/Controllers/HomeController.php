<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Repositories\DepartmentRepository;

class HomeController extends Controller
{
    /**
     * @var DepartmentRepository
     */
    protected $departmentRepository;

    /**
     * Create a new controller instance.
     *
     * @param DepartmentRepository $departmentRepository
     * @return void
     */
    public function __construct(DepartmentRepository $departmentRepository)
    {
        $this->middleware('auth');
        $this->departmentRepository = $departmentRepository;
    }

    /**
     * Показ главной страницы
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $memcached = new \Memcached();
        $memcached->addServer('localhost', 11211);

// get(prefix:key)
        dd($memcached->get('laravel:departments'));

        $employees = Employee::paginate(10);
        $departments = $this->departmentRepository->all();

        return view('home', [
            'employees' => $employees,
            'departments' => $departments,
        ]);
    }
}
