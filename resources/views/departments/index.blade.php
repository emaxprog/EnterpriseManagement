@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <a href="{{route('departments.create')}}" class="btn btn-primary">Создать отдел</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Название</th>
                        <th>Кол-во сотрудников</th>
                        <th>Максимальная заработная плата</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($departments as $department)
                        <tr>
                            <td>{{ $department->name }}</td>
                            <td>{{ $department->count_employees }}</td>
                            <td>{{ $department->max_salary }}</td>
                            <td>{{ route('departments.edit',['department'=>$department->department_id]) }}</td>
                            <td>{{ route('departments.destroy',['department'=>$department->department_id]) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection