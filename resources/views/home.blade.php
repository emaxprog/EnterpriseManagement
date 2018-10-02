@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">Сетка связей между работниками и их отделами</div>

                    <div class="panel-body">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th></th>
                                @foreach($departments as $department)
                                    <th class="text-center">{{ $department->name }}</th>
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($employees as $employee)
                                <tr>
                                    <td>{{ $employee->surname }} {{ $employee->name }}</td>
                                    @foreach($departments as $department)
                                        <td class="text-center">{!! $employee->departments->contains('id',$department->id)?'<i class="fa fa-check fa-lg"></i>':'' !!}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
