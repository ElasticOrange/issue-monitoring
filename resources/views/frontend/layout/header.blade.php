<div class="row">
    <div class="col-md-8">
        <img alt="stripe header" src="/img/stripe_header.png" />
    </div>
    <div class="col-md-2">
        <br />
        <a href="#en">
            <img alt="english flag" src="/img/flag_en.png" />
        </a>
        <a href="#ro">
            <img alt="romanian flag" src="/img/flag_ro.png" />
        </a>
    </div>
    <div class="col-md-2">
    </div>
</div>

<br />

<div class="row">
    <div class="col-md-2 text-center">
        <img alt="logo Issue Monitoring" src="/img/logo_im.png" />
    </div>
    <div class="col-md-8">
        <nav class="navbar navbar-default white" role="navigation">
            <div class="navbar-header">

                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                     <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
                </button>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="active">
                        <a href="{{ action('HomeController@getIndex') }}">Acasa</a>
                    </li>
                    <li>
                        <a href="{{ action('HomeController@getIssues') }}">Initiative</a>
                    </li>
                    <li>
                        <a href="{{ action('HomeController@getReports') }}">Rapoarte</a>
                    </li>
                    <li>
                        <a href="{{ action('HomeController@getContact') }}">Contact</a>
                    </li>
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">Despre noi<strong class="caret"></strong>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{ action('HomeController@getAboutUs') }}">Despre noi</a>
                            </li>
                            <li>
                                <a href="{{ action('HomeController@getServices') }}">Servicii</a>
                            </li>
                            <li>
                                <a href="{{ action('HomeController@getTeam') }}">Echipa</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ action('Auth\AuthController@getLogin') }}">Autentificare</a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                        <div class="searching-input">
                            <input type="text" placeholder="CAUTA" />
                        </div>
                </ul>
            </div>
            <div class="custom-search-stripe"></div>

        </nav>
    </div>
    <div class="col-md-2 text-center">
        <img alt="logo CMPP" src="/img/logo_cmpp.png" />
    </div>
</div>

<br />
<br />
