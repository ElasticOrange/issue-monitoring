@extends('admin.layouts.master')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="col-sm-6">
                <h1>Modifica User</h1>
            </div>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-md-12">
            @include('errors._errors')
            <form 	class="form-horizontal"
                     method="POST"
                     action="{{ action('UserController@update', [$user]) }}"
                     enctype="multipart/form-data"
                     data-ajax="true"
                     success-message="User salvat"
                     error-message="Eroare"
                     success-url="{{action('UserController@index')}}"
                    >
                <input type="hidden" name="_method" value="PUT"/>
                @include('auth.form')

                <div class="form-group">
                    <label class="col-md-2 control-label">Tip</label>
                    <div class="col-md-8">
                        <select class="form-control" name="type">
                            <option value="client">client</option>
                            <option value="editor" @if($user->type === 'editor') selected="selected" @endif>editor</option>
                            <option value="admin" @if($user->type === 'admin') selected="selected" @endif>admin</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-4" style="margin-top:25px;">
                        <button class="btn btn-primary">
                            <span class="glyphicon glyphicon-floppy-disk"></span> Salveaza schimbari
                        </button>
                        <a href="{{ action('UserController@index') }}" class="btn btn-info">
                            <span class="glyphicon glyphicon-th-list"></span> Inapoi la lista
                        </a>
                    </div>
                    <div class="col-sm-2 col-sm-offset-6" style="margin-top:25px;">
                        <a href="{{ action("UserController@destroy", [$user]) }}" class="btn btn-danger delete-button"><span class="glyphicon glyphicon-trash"></span> Sterge</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('js')
    {{--<script type="text/javascript" src="/js/auth.js"></script>--}}
@endsection
