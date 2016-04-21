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
                            <li class="col-md-2 text-center">
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
                            <li class="col-md-2 col-md-offset-2 text-center">
                                <a href="#">Protecţie socială</a>
                            </li>
                            <li class="col-md-2 text-center">
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
            <h3 class="text-left">Noutăţi legislative</h3>
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
            <button class="subscribe-btn">
                <span class="subscribe-btn-text">Înregistrează-te</span>
            </button>

            <br />
            <br />

            <img src="/img/subscribe_img.png" class="subscribe_img">
            <dl style="margin-top: -250px;">
                <dt class="subscribe-text">Bucură-te de avantaje! <br /> Vei primi notificări privind evoluția inițiativelor legislative din domeniul selectat direct prin e-mail.</dt>
            </dl>
            <br>
            <li class="text-scope">
                Monitorizare:<br><span class="text-scope">Monitorizare a inițiativelor legislative relevante pentru domeniul tău de interes.</span>
            </li><br>
            <li class="text-scope">
                Alertă: <br><span class="text-scope">Alertă pe e-mail cu modificările de status ale inițiativelor relevante.</span>
            </li><br>
            <li class="text-scope">
            Analiză: <br><span class="text-scope">Analiză săptămnală sau lunară asupra evoluției inițiativelor monitorizate.</span>
            </li>
        </div>
    </div>

    <br />

    <div class="row">
        <div class="col-md-12 reports-title">
            <h3 class="report-news">Rapoarte</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <img src="/img/reports_img.png" class="reports-img">
        </div>
        <div class="col-md-6">
            <h3>Cele mai recente rapoarte</h3>
            <dl>
                <dt class="reports-dt-title">Weekly Policy and Political Report, January 25-29, 2016</dt>
                <dd>Maritime Safety and Prevention of Pollution from Ships (Amendment):
                        EP and Council Scrutiny Period to End on 28 December
                        <a href="#descarca-raport">Descarcă</a>
                </dd>
            </dl>
            <img src="/img/reports_stripe.png" class="reports-stripe">
            <dl>
                <dt class="reports-dt-title">Weekly Policy and Political Report, January 25-29, 2016</dt>
                <dd>Maritime Safety and Prevention of Pollution from Ships (Amendment):
                        EP and Council Scrutiny Period to End on 28 December
                        <a href="#descarca-raport">Descarcă</a>
                </dd>
            </dl>
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
            });
        })();
    </script>
@endsection
