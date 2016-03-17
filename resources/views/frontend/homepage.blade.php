@extends('frontend.layout.master')
<!-- @include('frontend.layout.partials.user') -->

@section('content')

<div class="container white">
    @include('frontend.layout.partials.header')
    <div class="row">
        <div class="col-md-12">
            <div class="carousel slide" id="carousel-122866">
                <ol class="carousel-indicators">
                    <li class="active" data-slide-to="0" data-target="#carousel-122866">
                    </li>
                    <li data-slide-to="1" data-target="#carousel-122866">
                    </li>
                    <li data-slide-to="2" data-target="#carousel-122866">
                    </li>
                </ol>
                <div class="carousel-inner">
                    <div class="item active">
                        <img alt="Slide IM" src="/img/slider1.png" />
                    </div>
                    <div class="item">
                        <img alt="Carousel Bootstrap Second" src="/img/slider1.png" />
                    </div>
                    <div class="item">
                        <img alt="Carousel Bootstrap Third" src="/img/slider1.png" />
                    </div>
                </div> <a class="left carousel-control" href="#carousel-122866" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a> <a class="right carousel-control" href="#carousel-122866" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
            </div>
        </div>
    </div>

    <br />

    <div class="row">
        <div class="col-lg-12">
            <p class="sticky-domains">
                Domenii monitorizate
            </p>
            <ul class="nav nav-tabs sticky-domains">
                <li class="col-md-2 col-xs-12 text-center">
                    <a href="#">Fiscalitate</a>
                </li>
                <li class="col-md-2 col-xs-12 text-center">
                    <a href="#">Legislatia muncii</a>
                </li>
                <li class="col-md-2 col-xs-12 text-center">
                    <a href="#">Concurenta</a>
                </li>
                <li class="col-md-2 col-xs-12 text-center">
                    <a href="#">Sanatate</a>
                </li>
                <li class="col-md-2 col-xs-12 text-center">
                    <a href="#">Protectie sociala</a>
                </li>
                <li class="col-md-2 col-xs-12 text-center">
                    <a href="#">Societate civila</a>
                </li>
            </ul>
        </div>
    </div>

    <br />
    <br />

    <div class="row news-title">
        <div class="col-md-8 title-news">
            <h3 class="text-left">Noutati legislative</h3>

            <br /><br />

            <dl class="news-group">
                <dt class="news-date-text">16 martie 2016</dt>
                <dd class="news-text-desc">Proiectul de lege Pl-x 655/2015 privind aprobarea Ordonanţei de urgenţã a Guvernului nr.27/2015 pentru completarea Ordonanţei de urgenţã a Guvernului nr.83/2014 privind salarizarea personalului plătit din fonduri publice în anul 2015 a fost adoptat la data de 24.02.2016 în plenul Camerei Deputaților, în calitate de cameră decizională. <a href="">Afla mai multe</a></dd>
                <img src="/img/news_stripe.png" class="news-stripe">
            </dl>

            <!-- Foreach news -->
            <dl class="news-group">
                <dt class="news-date-text">16 martie 2016</dt>
                <dd class="news-text-desc">Proiectul de lege Pl-x 655/2015 privind aprobarea Ordonanţei de urgenţã a Guvernului nr.27/2015 pentru completarea Ordonanţei de urgenţã a Guvernului nr.83/2014 privind salarizarea personalului plătit din fonduri publice în anul 2015 a fost adoptat la data de 24.02.2016 în plenul Camerei Deputaților, în calitate de cameră decizională. <a href="">Afla mai multe</a></dd>
                <img src="/img/news_stripe.png" class="news-stripe">
            </dl>

            <dl class="news-group">
                <dt class="news-date-text">16 martie 2016</dt>
                <dd class="news-text-desc">Proiectul de lege Pl-x 655/2015 privind aprobarea Ordonanţei de urgenţã a Guvernului nr.27/2015 pentru completarea Ordonanţei de urgenţã a Guvernului nr.83/2014 privind salarizarea personalului plătit din fonduri publice în anul 2015 a fost adoptat la data de 24.02.2016 în plenul Camerei Deputaților, în calitate de cameră decizională. <a href="">Afla mai multe</a></dd>
                <img src="/img/news_stripe.png" class="news-stripe">
            </dl>

            <dl class="news-group">
                <dt class="news-date-text">16 martie 2016</dt>
                <dd class="news-text-desc">Proiectul de lege Pl-x 655/2015 privind aprobarea Ordonanţei de urgenţã a Guvernului nr.27/2015 pentru completarea Ordonanţei de urgenţã a Guvernului nr.83/2014 privind salarizarea personalului plătit din fonduri publice în anul 2015 a fost adoptat la data de 24.02.2016 în plenul Camerei Deputaților, în calitate de cameră decizională. <a href="">Afla mai multe</a></dd>
                <img src="/img/news_stripe.png" class="news-stripe">
            </dl>

            <dl class="news-group">
                <dt class="news-date-text">16 martie 2016</dt>
                <dd class="news-text-desc">Proiectul de lege Pl-x 655/2015 privind aprobarea Ordonanţei de urgenţã a Guvernului nr.27/2015 pentru completarea Ordonanţei de urgenţã a Guvernului nr.83/2014 privind salarizarea personalului plătit din fonduri publice în anul 2015 a fost adoptat la data de 24.02.2016 în plenul Camerei Deputaților, în calitate de cameră decizională. <a href="">Afla mai multe</a></dd>
                <!-- <img src="/img/news_stripe.png" class="news-stripe"> -->
            </dl>
            <!-- /Foreach news -->
        </div>
        <div class="col-md-4 col-sm-8 subscribe-now">
            <h3 class="text-left">Aboneaza-te</h3>

            <br />

            <img src="/img/subscribe_img.png" class="subscribe_img">
            <dl>
                <dt class="subscribe-text">Bucură-te de avantaje! <br /> Vei primi notificări privind evoluția inițiativelor legislative din domeniul selectat direct prin e-mail.</dt>
            </dl>
            <button class="subscribe-btn"><span class="subscribe-btn-text">Abonează-te acum</span></button>
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
                        <a href="#descarca-raport">Descarca</a>
                </dd>
            </dl>
            <img src="/img/reports_stripe.png" class="reports-stripe">
            <dl>
                <dt class="reports-dt-title">Weekly Policy and Political Report, January 25-29, 2016</dt>
                <dd>Maritime Safety and Prevention of Pollution from Ships (Amendment): 
                        EP and Council Scrutiny Period to End on 28 December
                        <a href="#descarca-raport">Descarca</a>
                </dd>
            </dl>
        </div>
    </div>
    
    @include('frontend.layout.partials.footer')
</div>

@endsection