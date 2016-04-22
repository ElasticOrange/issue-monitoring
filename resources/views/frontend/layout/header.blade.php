<div class="row">
    <div class="col-md-6">
        <img alt="stripe header" src="/img/stripe_header.png" />
    </div>
        <div class="col-md-2 social-links-container" style="margin-top: 6px;">
            <a href="https://www.facebook.com/cmpp.issuemonitoring" style="margin-left: 40px;" target="_blank">
                <img alt="facebook" src="/img/facebook.png" width="40px" />
            </a>
            <a href="https://www.linkedin.com/company/issue-monitoring" target="_blank">
                <img alt="facebook" src="/img/linkedin.png" width="40px" />
            </a>
            <a href="https://twitter.com/issuemonitoring" target="_blank">
                <img alt="facebook" src="/img/twitter.png" width="40px" />
            </a>
        </div>
    <div class="col-md-4">
        <ul class="nav navbar-nav">
            <li>
                <a href="#en">
                    <img alt="english flag" src="/img/flag_en.png" />
                </a>
            </li>
            <li>
                <a href="#ro">
                    <img alt="romanian flag" src="/img/flag_ro.png" />
                </a>
            </li>
        @if($user)
            <li class="dropdown">
                <a href="#" data-toggle="dropdown" class="dropdown-toggle">{{ $user->name }}<strong class="caret"></strong>
                </a>
                <ul class="dropdown-menu">
                    @if($user->isAdmin() or $user->isEditor())
                        <li>
                            <a href="{{ action('AdminDashboardController@getIndex') }}">Admin</a>
                        </li>
                    @endif
                    <li>
                    <a href="#">Profil</a>
                        </li>
                    <li>
                    <a href="{{ action('Auth\AuthController@getLogout') }}">Logout</a>
                        </li>
                </ul>
            </li>
        @else
            <li>
                <a href="{{ action('Auth\AuthController@getLogin') }}">
                        Autentificare
                </a>
            </li>
        @endif
        </ul>
    </div>
</div>

<br />

<div class="row">
    <a href="{{ action('HomeController@getIndex') }}">
        <div class="col-md-2 text-center">
            <img alt="logo Issue Monitoring" src="/img/logo_im.png" />
        </div>
    </a>
    <div class="col-md-8">
        <nav class="navbar navbar-default white" role="navigation">
            <div class="navbar-header">

                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                     <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
                </button>
            </div>

            <div class="collapse navbar-collapse"
                 id="bs-example-navbar-collapse-1"
                 >
                <ul class="nav navbar-nav">
                    <li class="active">
                        <a href="{{ action('HomeController@getIndex') }}">Acasă</a>
                    </li>
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">Issue Monitoring<strong class="caret"></strong>
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
                        <a href="{{ action('HomeController@getIssues') }}">Iniţiative</a>
                    </li>
                    <li>
                        <a href="{{ action('HomeController@getReports') }}">Rapoarte</a>
                    </li>
                    <li>
                        <a href="{{ action('HomeController@getStakeholders') }}">Stakeholderi</a>
                    </li>
                    <li>
                        <a href="{{ action('HomeController@getContact') }}">Contact</a>
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
    <a href="http://www.cmpp.ro">
        <div class="col-md-2 text-center">
            <img alt="logo CMPP" src="/img/logo_cmpp.png" />
        </div>
    </a>
</div>

<br />
<br />
