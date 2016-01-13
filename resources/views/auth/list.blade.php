@extends('admin.layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-12 text-left">
            <h1 class="page-header">Users</h1>
        </div>
    </div>

    <div class="form-group">
        <a href="{{ action('UserController@create') }}" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Adauga user</a>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" data-table="true">
                            <thead>
                            <tr role="row">
                                <th class="text-center" style="width: 5%;">Id</th>
                                <th class="text-center" style="width: 35%;">Nume</th>
                                <th class="text-center" style="width: 40%;">E-mail</th>
                                <th class="text-center" style="width: 5%;">Acces</th>
                                <th class="text-center" style="width: 5%;">Activ</th>
                                <th class="text-center" style="width: 10%;">Actiuni</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($users as $user)
                                <tr class="gradeA odd" role="row">
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->type }}</td>
                                    <td class="text-center">
                                        <input  type="checkbox"
                                                name="active"
                                                data-id="{{ $user->id }}"
                                                data-action="active-user"
                                                update-url="{{ action("UserController@setActive",[$user]) }}"
                                                @if($user->active) checked="checked" @endif
                                                />
                                    </td>
                                    <td class="text-center">
                                        <div class="row">
                                            <a href="{{ action('UserController@edit', [$user])}}" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span></a>
                                            <a href="{{ action('UserController@destroy', [$user]) }}" class="btn btn-danger delete-button"><span class="glyphicon glyphicon-trash"></span></a>
                                        </div>
                                    </td>
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

@section('js')
    <script type="text/javascript" src="/js/users.js"></script>
@endsection