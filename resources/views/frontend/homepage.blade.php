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
        <div class="col-md-4 subscribe-now">
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

    <br />



    <div class="row">
        <div class="col-md-12">
             
            <button type="button" class="btn btn-default">
                Default
            </button><img alt="Bootstrap Image Preview" src="http://lorempixel.com/140/140/" />
            <div class="row">
                <div class="col-md-8">
                    <h3 class="text-center">
                        h3. Lorem ipsum dolor sit amet.
                    </h3>
                    <p>
                        Lorem ipsum dolor sit amet, <strong>consectetur adipiscing elit</strong>. Aliquam eget sapien sapien. Curabitur in metus urna. In hac habitasse platea dictumst. Phasellus eu sem sapien, sed vestibulum velit. Nam purus nibh, lacinia non faucibus et, pharetra in dolor. Sed iaculis posuere diam ut cursus. <em>Morbi commodo sodales nisi id sodales. Proin consectetur, nisi id commodo imperdiet, metus nunc consequat lectus, id bibendum diam velit et dui.</em> Proin massa magna, vulputate nec bibendum nec, posuere nec lacus. <small>Aliquam mi erat, aliquam vel luctus eu, pharetra quis elit. Nulla euismod ultrices massa, et feugiat ipsum consequat eu.</small>
                    </p>
                    <dl>
                        <dt>
                            Description lists
                        </dt>
                        <dd>
                            A description list is perfect for defining terms.
                        </dd>
                        <dt>
                            Euismod
                        </dt>
                        <dd>
                            Vestibulum id ligula porta felis euismod semper eget lacinia odio sem nec elit.
                        </dd>
                        <dd>
                            Donec id elit non mi porta gravida at eget metus.
                        </dd>
                        <dt>
                            Malesuada porta
                        </dt>
                        <dd>
                            Etiam porta sem malesuada magna mollis euismod.
                        </dd>
                        <dt>
                            Felis euismod semper eget lacinia
                        </dt>
                        <dd>
                            Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.
                        </dd>
                    </dl>
                </div>
                <div class="col-md-4">
                    <h3>
                        h3. Lorem ipsum dolor sit amet.
                    </h3><img alt="Bootstrap Image Preview" src="http://lorempixel.com/140/140/" />
                    <h3>
                        h3. Lorem ipsum dolor sit amet.
                    </h3> 
                    <button type="button" class="btn btn-lg btn-block">
                        Default
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <img alt="Bootstrap Image Preview" src="http://lorempixel.com/140/140/" />
        </div>
        <div class="col-md-6">
            <dl>
                <dt>
                    Description lists
                </dt>
                <dd>
                    A description list is perfect for defining terms.
                </dd>
                <dt>
                    Euismod
                </dt>
                <dd>
                    Vestibulum id ligula porta felis euismod semper eget lacinia odio sem nec elit.
                </dd>
                <dd>
                    Donec id elit non mi porta gravida at eget metus.
                </dd>
                <dt>
                    Malesuada porta
                </dt>
                <dd>
                    Etiam porta sem malesuada magna mollis euismod.
                </dd>
                <dt>
                    Felis euismod semper eget lacinia
                </dt>
                <dd>
                    Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.
                </dd>
            </dl>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <img alt="Bootstrap Image Preview" src="http://lorempixel.com/140/140/" />
        </div>
        <div class="col-md-8">
            <p>
                Lorem ipsum dolor sit amet, <strong>consectetur adipiscing elit</strong>. Aliquam eget sapien sapien. Curabitur in metus urna. In hac habitasse platea dictumst. Phasellus eu sem sapien, sed vestibulum velit. Nam purus nibh, lacinia non faucibus et, pharetra in dolor. Sed iaculis posuere diam ut cursus. <em>Morbi commodo sodales nisi id sodales. Proin consectetur, nisi id commodo imperdiet, metus nunc consequat lectus, id bibendum diam velit et dui.</em> Proin massa magna, vulputate nec bibendum nec, posuere nec lacus. <small>Aliquam mi erat, aliquam vel luctus eu, pharetra quis elit. Nulla euismod ultrices massa, et feugiat ipsum consequat eu.</small>
            </p>
        </div>
        <div class="col-md-2">
            <img alt="Bootstrap Image Preview" src="http://lorempixel.com/140/140/" />
        </div>
    </div>
</div>

@endsection