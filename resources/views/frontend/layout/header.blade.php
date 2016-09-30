<?php
    if (\Auth::check() && \Auth::user()->subscriptionExpired()) {
        \Auth::logout();
    }
?>

<div class="row">
    <div class="col-md-6">
        <img alt="stripe header" class="stripe-header" src="/img/stripe_header.png" />
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
                <a href="{{ action('HomeController@setLanguage', ['en']) }}">
                    <img alt="english flag" src="/img/flag_en.png" />
                </a>
            </li>
            <li>
                <a href="{{ action('HomeController@setLanguage', ['ro']) }}">
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
                    <!-- <li>
                        <a href="#">Profil</a>
                    </li> -->
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
                <ul class="nav navbar-nav main-menu-buttons">
                    <li class="active">
                        <a href="{{ action('HomeController@getIndex') }}">{{ trans('home.home') }}</a>
                    </li>
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">Issue Monitoring<strong class="caret"></strong>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{ action('HomeController@getAboutUs') }}">{{ trans('about_us.about_us') }}</a>
                            </li>
                            <li>
                                <a href="{{ action('HomeController@getServices') }}">{{ trans('services.services') }}</a>
                            </li>
                            <li>
                                <a href="{{ action('HomeController@getTeam') }}">{{ trans('team.team') }}</a>
                            </li>
                            <li>
                                <a href="{{ action('HomeController@howWorks') }}">{{ trans('how_works.header') }}</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ action('HomeController@getIssues', ['issue_search' => '', 'type' => '', 'phase' => 'curent']) }}">{{ trans('home.initiatives') }}</a>
                    </li>
                    <li>
                        <a href="{{ action('HomeController@getReports') }}">{{ trans('home.reports') }}</a>
                    </li>
                    <li>
                        <a href="{{ action('HomeController@getStakeholders') }}">{{ trans('home.stakeholders') }}</a>
                    </li>
                    <li>
                        <a href="{{ action('HomeController@getContact') }}">Contact</a>
                    </li>
                </ul>
                <!-- <ul class="nav navbar-nav navbar-right">
                        <div class="searching-input">
                            <input type="text" placeholder="CAUTA" />
                        </div>
                </ul> -->
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
