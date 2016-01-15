@extends('admin.layouts.master')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="col-sm-6">
                <h1>Profil</h1>
            </div>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-md-12">
            @include('errors._errors')
            <form 	class="form-horizontal"
                     method="POST"
                     action="{{ action('UserController@updateProfile') }}"
                     enctype="multipart/form-data"
                     data-ajax="true"
                     success-message="User salvat"
                     error-message="Eroare"
                     success-url="{{ action('UserController@profile') }}"
                    >

                {!! csrf_field() !!}

                <div class="form-group">
                    <label class="col-md-2 control-label">Name</label>
                    <div class="col-sm-8">
                        <input  type="text"
                                name="name"
                                class="form-control"
                                value="{{ $user->name }}"
                                />
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">E-mail</label>
                    <div class="col-sm-8">
                        <input  type="email"
                                name="email"
                                class="form-control"
                                value="{{ $user->email }}"
                                />
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Password</label>
                    <div class="col-sm-8">
                        <input  type="password"
                                name="password"
                                class="form-control"
                                />
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Password confirmation</label>
                    <div class="col-sm-8">
                        <input  type="password"
                                name="password_confirmation"
                                class="form-control"
                                />
                    </div>
                </div>

                <br/><hr><br/>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-6">
                            <h3>Alerte</h3>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="checkbox col-md-8 col-md-offset-2">
                        <label>
                            <input  type="checkbox"
                                    value="1"
                                    name="alert_new_issue"
                                    @if($user->alert_new_issue)
                                    checked="checked"
                                    @endif
                                    />Alerta issue nou
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <div class="checkbox col-md-8 col-md-offset-2">
                        <label>
                            <input  type="checkbox"
                                    value="1"
                                    name="alert_issue_status"
                                    @if($user->alert_issue_status)
                                    checked="checked"
                                    @endif
                                    />Alerta issue status
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <div class="checkbox col-md-8 col-md-offset-2">
                        <label>
                            <input  type="checkbox"
                                    value="1"
                                    name="alert_news"
                                    @if($user->alert_news)
                                    checked="checked"
                                    @endif
                                    />Alerta news
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <div class="checkbox col-md-8 col-md-offset-2">
                        <label>
                            <input  type="checkbox"
                                    value="1"
                                    name="alert_report"
                                    @if($user->alert_report)
                                    checked="checked"
                                    @endif
                                    />Alerta raport
                        </label>
                    </div>
                </div>
                <br/><br/>

                <div class="form-group">
                    <div class="col-sm-4" style="margin-top:25px;">
                        <button class="btn btn-primary">
                            <span class="glyphicon glyphicon-floppy-disk"></span> Salveaza schimbari
                        </button>
                    </div>
                    <div class="col-sm-2 col-sm-offset-6" style="margin-top:25px;">
                        <a class="btn btn-warning" href="{{ action('Auth\AuthController@getLogout') }}" data-confirm="Esti sigur ca vrei sa te deloghezi ?"><span class="glyphicon glyphicon-off"></span> Logout</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('js')
    <script type="text/javascript" src="/js/users.js"></script>
@endsection
