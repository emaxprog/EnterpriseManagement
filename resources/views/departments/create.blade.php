@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center">Создать отдел</h1>
        <div class="row">
            <div class="col-md-12">
                <form id="department_form" action="{{route('departments.store')}}" method="post"
                      class="form-horizontal form">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="name" class="control-label col-md-2">Название</label>
                        <div class="col-md-10">
                            <input type="text" name="name" id="name" class="form-control">
                        </div>
                    </div>
                    @if($errors->has('name'))
                        <div class="alert alert-danger">
                            <strong>{{ $errors->first('name') }}</strong>
                        </div>
                    @endif
                    <button type="submit" class="btn btn-primary center-block">Сохранить</button>
                </form>
            </div>
        </div>
    </div>
@endsection