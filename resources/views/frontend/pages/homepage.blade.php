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

            <dl class="news-group">
                <dt class="news-date-text">16 martie 2016</dt>
                <dd class="news-text-desc">Proiectul de lege Pl-x 655/2015 privind aprobarea Ordonanţei de urgenţã a Guvernului nr.27/2015 pentru completarea Ordonanţei de urgenţã a Guvernului nr.83/2014 privind salarizarea personalului plătit din fonduri publice în anul 2015 a fost adoptat la data de 24.02.2016 în plenul Camerei Deputaților, în calitate de cameră decizională. <a href="">Află mai multe</a></dd>
                <img src="/img/news_stripe.png" class="news-stripe">
            </dl>

            <!-- Foreach news -->
            <dl class="news-group">
                <dt class="news-date-text">16 martie 2016</dt>
                <dd class="news-text-desc">Proiectul de lege Pl-x 655/2015 privind aprobarea Ordonanţei de urgenţã a Guvernului nr.27/2015 pentru completarea Ordonanţei de urgenţã a Guvernului nr.83/2014 privind salarizarea personalului plătit din fonduri publice în anul 2015 a fost adoptat la data de 24.02.2016 în plenul Camerei Deputaților, în calitate de cameră decizională. <a href="">Află mai multe</a></dd>
                <img src="/img/news_stripe.png" class="news-stripe">
            </dl>

            <dl class="news-group">
                <dt class="news-date-text">16 martie 2016</dt>
                <dd class="news-text-desc">Proiectul de lege Pl-x 655/2015 privind aprobarea Ordonanţei de urgenţã a Guvernului nr.27/2015 pentru completarea Ordonanţei de urgenţã a Guvernului nr.83/2014 privind salarizarea personalului plătit din fonduri publice în anul 2015 a fost adoptat la data de 24.02.2016 în plenul Camerei Deputaților, în calitate de cameră decizională. <a href="">Află mai multe</a></dd>
                <img src="/img/news_stripe.png" class="news-stripe">
            </dl>

            <dl class="news-group">
                <dt class="news-date-text">16 martie 2016</dt>
                <dd class="news-text-desc">Proiectul de lege Pl-x 655/2015 privind aprobarea Ordonanţei de urgenţã a Guvernului nr.27/2015 pentru completarea Ordonanţei de urgenţã a Guvernului nr.83/2014 privind salarizarea personalului plătit din fonduri publice în anul 2015 a fost adoptat la data de 24.02.2016 în plenul Camerei Deputaților, în calitate de cameră decizională. <a href="">Află mai multe</a></dd>
                <img src="/img/news_stripe.png" class="news-stripe">
            </dl>

            <dl class="news-group">
                <dt class="news-date-text">16 martie 2016</dt>
                <dd class="news-text-desc">Proiectul de lege Pl-x 655/2015 privind aprobarea Ordonanţei de urgenţã a Guvernului nr.27/2015 pentru completarea Ordonanţei de urgenţã a Guvernului nr.83/2014 privind salarizarea personalului plătit din fonduri publice în anul 2015 a fost adoptat la data de 24.02.2016 în plenul Camerei Deputaților, în calitate de cameră decizională. <a href="">Află mai multe</a></dd>
                <!-- <img src="/img/news_stripe.png" class="news-stripe"> -->
            </dl>
            <!-- /Foreach news -->
        </div>
        <div class="col-md-4 col-sm-8 subscribe-now">
            <button class="subscribe-btn">
                <span class="subscribe-btn-text">Înregistrează-te</span>
            </button>

            <br />
            <br />

            <img src="/img/subscribe_img.png" class="subscribe_img">
            <dl>
                <dt class="subscribe-text">Bucură-te de avantaje! <br /> Vei primi notificări privind evoluția inițiativelor legislative din domeniul selectat direct prin e-mail.</dt>
            </dl>
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
