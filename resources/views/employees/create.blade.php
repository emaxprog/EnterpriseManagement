@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center">Добавить сотрудника</h1>
        <div class="row">
            <div class="col-md-12">
                <form id="employee_form" action="{{route('employees.store')}}" method="post"
                      class="form-horizontal form">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="name" class="control-label col-md-2">Имя</label>
                        <div class="col-md-10">
                            <input type="text" name="name" id="name" class="form-control">
                        </div>
                    </div>
                    @if($errors->has('name'))
                        <div class="alert alert-danger">
                            <strong>{{ $errors->first('name') }}</strong>
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="surname" class="control-label col-md-2">Фамилия</label>
                        <div class="col-md-10">
                            <input type="text" name="surname" id="surname" class="form-control">
                        </div>
                    </div>
                    @if($errors->has('surname'))
                        <div class="alert alert-danger">
                            <strong>{{ $errors->first('surname') }}</strong>
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="patronymic" class="control-label col-md-2">Отчество</label>
                        <div class="col-md-10">
                            <input type="text" name="patronymic" id="patronymic" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2">Пол</label>
                        <div class="col-md-10">
                            <label class="control-label">
                                <input type="radio" name="gender" value="мужской" checked>
                                Мужской
                            </label>
                            <label class="control-label">
                                <input type="radio" name="gender" value="женский">
                                Женский
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="salary" class="control-label col-md-2">Заработная плата</label>
                        <div class="col-md-10">
                            <input type="text" name="salary" id="salary" class="form-control">
                        </div>
                    </div>
                    @if($errors->has('salary'))
                        <div class="alert alert-danger">
                            <strong>{{ $errors->first('salary') }}</strong>
                        </div>
                    @endif
                    <div class="form-group">
                        <label class="control-label col-md-2">Отделы</label>
                        <div class="col-md-10">
                            @foreach($departments as $department)
                                <div class="row">
                                    <label for="department-{{$department->department_id}}"
                                           class="control-label">{{ $department->name }}</label>
                                    <input type="checkbox" name="departments[]"
                                           id="department-{{$department->department_id}}"
                                           value="{{ $department->department_id }}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @if($errors->has('departments'))
                        <div class="alert alert-danger">
                            <strong>{{ $errors->first('departments') }}</strong>
                        </div>
                    @endif
                    <button type="submit" class="btn btn-primary center-block">Сохранить</button>
                </form>
            </div>
        </div>
    </div>
@endsection