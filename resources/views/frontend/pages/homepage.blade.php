@extends('frontend.layout.master')

@section('content')

<div class="container white">
    @include('frontend.layout.header')
    <div class="row">
        <div class="col-md-12">
            <img alt="Slide IM" src="/img/slider1.png" class="home-slider" />
        </div>
    </div>

    <br />



    <div class="row">
        <div class="col-lg-12">
            <p class="sticky-domains">
                Domenii monitorizate
            </p>
            <div class="carousel slide" id="carousel-122866">
                 <div class="carousel-inner">
                     <div class="item active">
                         <ul class="nav nav-tabs sticky-domains">
                            <li class="col-md-2 col-md-offset-2 text-center">
                                <a href="#">Fiscalitate</a>
                            </li>
                            <li class="col-md-3 text-center">
                                <a href="#">Legislaţia muncii</a>
                            </li>
                            <li class="col-md-2 text-center">
                                <a href="#">Concurenţă</a>
                            </li>
                            <li class="col-md-2 text-center">
                                <a href="#">Sănătate</a>
                            </li>
                        </ul>
                     </div>
                     <div class="item">
                         <ul class="nav nav-tabs sticky-domains">
                            <li class="col-md-3 col-md-offset-1 text-center">
                                <a href="#">Protecţie socială</a>
                            </li>
                            <li class="col-md-3 text-center">
                                <a href="#">Societate civilă</a>
                            </li>
                            <li class="col-md-2 text-center">
                                <a href="#">Energie</a>
                            </li>
                            <li class="col-md-2 text-center">
                                <a href="#">Bancar</a>
                            </li>
                         </ul>
                     </div>
                 </div>
                <a class="left carousel-control" href="#carousel-122866" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                </a>
                <a class="right carousel-control" href="#carousel-122866" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                </a>
            </div>
        </div>
    </div>

    <br />
    <br />

    <div class="row news-title">
        <div class="col-md-8 title-news">
            <h3 class="text-left">{{ trans('home.legislative_updates') }}</h3>
            <br /><br />
            <div class="carousel slide vertical" id="carousel-133466">
                <div class="carousel-inner">
                    @foreach ($legalNews as $legalN)
                        <div class="item">
                            <ul class="nav nav-tabs">
                                @foreach ($legalN as $ln)
                                    <li class="col-md-12">
                                        <p class="news-date-text">
                                            {{ $ln->created_at->format('d-m-Y')}}
                                        </p>
                                        <p class="news-text-desc">
                                            <b>
                                                {{ $ln->title }}
                                            </b>
                                                @if($ln->content)
                                                    : {{ strip_tags($ln->content) }}
                                                @endif
                                            @if(\Auth::user())
                                                <a href="{{ action('HomeController@getIssueInfo', ['id' => $ln->issue_id, 'name' => Illuminate\Support\Str::slug($ln->title)]) }}"> Află mai multe</a>
                                            @else
                                                <a href="{{ action('HomeController@getContact') }}"> Află mai multe</a>
                                            @endif
                                        </p>
                                        <img src="/img/news_stripe.png" style="width: 100%;">
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
                <a class="left carousel-control" href="#carousel-133466" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                </a>
                <a class="right carousel-control" href="#carousel-133466" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                </a>
            </div>
        </div>
        <div class="col-md-4 col-sm-8 subscribe-now">
            <a role="button"
                class="btn subscribe-btn"
                style="text-decoration: none;"
                href="{{ action('Auth\AuthController@getRegister') }}">
                <span class="subscribe-btn-text">{{ trans('home.sign_up') }}</span>
            </a>

            <br />
            <br />

            <img src="/img/subscribe_img.png" class="subscribe_img">
            <dl style="margin-top: -250px;">
                <dt class="subscribe-text">{{ trans('home.enjoy_benefits') }} <br /> {{ trans('home.enjoy_alerts') }}</dt>
            </dl>
            <br>
            <li class="text-scope">
                {{ trans('home.monitoring') }}:<br><span class="text-scope">{{ trans('home.monitoring_explain') }}</span>
            </li><br>
            <li class="text-scope">
                {{ trans('home.alert') }}: <br><span class="text-scope">{{ trans('home.alert_explain') }}</span>
            </li><br>
            <li class="text-scope">
            {{ trans('home.analysis') }}: <br><span class="text-scope">{{ trans('home.analysis_explain') }}</span>
            </li>
        </div>
    </div>

    <br />

    <div class="row">
        <div class="col-md-12 reports-title">
            <h3 class="report-news">{{ trans('home.reports') }}</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <img src="/img/reports_img.png" class="reports-img">
        </div>
        <div class="col-md-6">
            <h3>{{ trans('home.latest_reports') }}</h3>
            <div class="carousel slide vertical" id="carousel-1234">
                <div class="carousel-inner">
                    @foreach ($reports as $report)
                        <div class="item">
                            <ul class="nav nav-tabs">
                                @foreach ($report as $rep)
                                    <dt class="reports-dt-title">{{ $rep->title }}</dt>
                                    <dd class="report-ellipsis">
                                        {{ strip_tags($rep->description) }}
                                    </dd>
                                    <img src="/img/reports_stripe.png" class="reports-stripe">
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
                <a class="left carousel-control" href="#carousel-1234" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                </a>
                <a class="right carousel-control" href="#carousel-1234" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                </a>
            </div>
        </div>
    </div>

    @include('frontend.layout.footer')
</div>

@endsection

@section('js')
    <script>
        (function() {
            $(document).ready(function() {
                $('#carousel-133466').children().find('div.item:first').addClass('active');
                $('#carousel-1234').children().find('div.item:first').addClass('active');
            });
        })();
    </script>
@endsection
