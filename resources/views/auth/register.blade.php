<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Issue Monitoring Admin</title>

    <link type="text/css" rel="stylesheet" href="{{ elixir('css/all.css') }}" media="all">

    <!-- Bootstrap Core CSS -->
    <script src="{{ elixir('js/all.js') }}"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>
<div class="container">
    <p>&nbsp;</p>
    <div class="col-sm-6 col-sm-offset-3">
        <div class="panel panel-primary">
            <div class="panel-heading text-center">Înregistrează-te acum și vei avea acces pe platformă timp de 14 zile la notificările și rapoartele Issue Monitoring</div>
            <div class="panel-body main-panel">

                @include('errors._errors')
                <form class="form form-horizontal" action="{{ action('Auth\AuthController@postRegister') }}" method="post">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Nume</label>
                        <div class="col-sm-8">
                            <input 	type="text"
                                    value="{{ old('name')  }}"
                                    name="name"
                                    class="form-control"
                                    />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">E-mail</label>
                        <div class="col-sm-8">
                            <input 	type="email"
                                    name="email"
                                    value="{{ old('email')  }}"
                                    class="form-control"
                                    />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Organizaţie</label>
                        <div class="col-sm-8">
                            <input 	type="text"
                                      value="{{ old('organization')  }}"
                                      name="organization"
                                      class="form-control"
                            />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Funcţie</label>
                        <div class="col-sm-8">
                            <input 	type="text"
                                      value="{{ old('function')  }}"
                                      name="function"
                                      class="form-control"
                            />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Telefon</label>
                        <div class="col-sm-8">
                            <input 	type="text"
                                      value="{{ old('telephone')  }}"
                                      name="telephone"
                                      class="form-control"
                            />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Parola</label>
                        <div class="col-sm-8">
                            <input 	type="password"
                                    name="password"
                                    class="form-control"
                                    />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Confirmă Parola</label>
                        <div class="col-sm-8">
                            <input 	type="password"
                                    name="password_confirmation"
                                    class="form-control"
                                    />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-8 col-sm-offset-4">
                            <button type="submit" class="btn btn-primary">Înregistrează-mă</button>
                            <br>
                            <br>
                            Ai deja cont? Te poți autentifica <a href="{{ action('Auth\AuthController@getLogin') }}">aici.</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
<
