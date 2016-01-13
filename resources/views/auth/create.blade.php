@extends('admin.layouts.master')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="col-sm-6">
                <h1>Adauga User</h1>
            </div>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-md-12">
            @include('errors._errors')
            <form 	class="form-horizontal"
                     method="POST"
                     action="{{ action("UserController@store") }}"
                     enctype="multipart/form-data"
                     data-ajax="true"
                     success-message="User adaugat"
                     error-message="Eroare"
                     success-url="{{action('UserController@index')}}"
                    >
                @include('auth.form')
                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2" style="margin-top:25px;">
                        <button class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span> Salveaza</button>
                        <a href="{{ action('UserController@index') }}"> <button class="btn btn-info"><span class="glyphicon glyphicon-th-list"></span> Inapoi la lista</button></a>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection


@section('js')
    <script type="text/javascript" src="/js/edit-user.js"></script>
@endsection
