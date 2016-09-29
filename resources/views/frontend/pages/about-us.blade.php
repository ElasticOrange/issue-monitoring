@extends('frontend.layout.master')

@section('content')

<div class="container white">
    @include('frontend.layout.header')
    <div class="row" style="margin-top: -20px;">
        <div class="col-md-10 col-md-offset-1">
            <h2><a href="{{ action('HomeController@getAboutUs') }}">{{ trans('about_us.about_us') }}</a></h2>
            <br>
            <h3>{{ trans('about_us.cmpp') }}</h3>
            <p>{{ trans('about_us.p1') }}</p>
            </br>
            <p>{{ trans('about_us.p2') }}</p>
            </br>
            <p>{{ trans('about_us.p3') }}</p>
            </br>
            <h3>{{ trans('about_us.t2') }}</h3>
            <p><b><i>Issue Monitoring</i></b> {{ trans('about_us.p4') }}</p>
            </br>
            <p><b><i>Issue Monitoring</i></b> {{ trans('about_us.p5') }}</p>
            </br>
            <p>{{ trans('about_us.p61') }} <b><i>Issue Monitoring</i></b> {{ trans('about_us.p62') }}</p>
            <h3>{{ trans('about_us.t3') }}</h3>
            <p><b><i>Issue Monitoring</i></b> {{ trans('about_us.p7') }}</p>
            </br>
            <p><b><i>Issue Monitoring</i></b> {{ trans('about_us.p8') }}</p>
            <h4>{{ trans('about_us.t4') }}</h4>
            <ul>
              <li>{{ trans('about_us.li1') }}</li>
              <li>{{ trans('about_us.li2') }}</li>
              <li>{{ trans('about_us.li3') }}</li>
              <li>{{ trans('about_us.li4') }}</li>
              <li>{{ trans('about_us.li5') }}</li>
              <li>{{ trans('about_us.li6') }}</li>
            </ul>
            <p><b><i>Issue Monitoring</i></b> {{ trans('about_us.p9') }}</p>
        </div>
    </div>
    @include('frontend.layout.footer')
</div>

@endsection
