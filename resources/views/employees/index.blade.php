@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <a href="{{route('employees.create')}}" class="btn btn-primary">Добавить сотрудника</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Имя</th>
                        <th>Фамилия</th>
                        <th>Отчество</th>
                        <th>Пол</th>
                        <th>Заработная плата</th>
                        <th>Отделы</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($employees as $employee)
                        <tr>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->surname }}</td>
                            <td>
                                {{ $employee->patronymic?$employee->patronymic :'Неизвестно'}}
                            </td>
                            <td>{{ $employee->gender }}</td>
                            <td>{{ $employee->salary }}</td>
                            <td>
                                @foreach($employee->departments as $department)
                                    {{ $department->name }} ,
                                @endforeach
                            </td>
                            <td><a href="{{ route('employees.edit',['employee'=>$employee->employee_id]) }}"
                                   class="btn btn-default"><i
                                            class="fa fa-edit"></i></a>
                            </td>
                            <td>
                                <a href="{{ route('employees.destroy',['employee'=>$employee->employee_id]) }}"
                                   class="btn btn-danger btn-destroy"><i
                                            class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $employees->render() }}
            </div>
        </div>
    </div>
@endsection