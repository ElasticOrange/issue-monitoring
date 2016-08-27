@extends('admin.layouts.master')

@section('content')
    @include('admin.backend.issues.action_buttons', ['controller' => 'UserController'])
    <div class="row">
        <div class="col-lg-12 text-left">
            <h1 class="page-header">Users</h1>
        </div>
    </div>

    @if($expired)
    <div class="form-group">
        <div class="alert alert-warning">
            Utilizatorilor: <b>{{ $expired }}</b> le-a expirat abonamentul.
        </div>
    </div>
    @endif

    <div class="form-group">
        <a href="{{ action('UserController@create') }}" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Adauga user</a>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" data-table="true" id="users-table">
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
