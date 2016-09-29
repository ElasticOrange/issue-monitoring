@extends('frontend.layout.master')

@section('content')

    <div class="container white">
        @include('frontend.layout.header')
        <div class="row" style="margin-top: -20px;">
            <div class="col-md-10 col-md-offset-1">
                <h2>{{ trans('how_works.h1') }}</h2>
                <p>{{ trans('how_works.p1') }}</p>
                <ul>
                    <li>{{ trans('how_works.li1') }}</li>
                    <li>{{ trans('how_works.li2') }}</li>
                    <li>{{ trans('how_works.li3') }}</li>
                    <li>{{ trans('how_works.li4') }}</li>
                    <li>{{ trans('how_works.li5') }}</li>
                    <li>{{ trans('how_works.li6') }}</li>
                </ul>
                <p>{{ trans('how_works.p2') }}</p>
                <h3>{{ trans('how_works.t1') }}</h3>
                <p>{{ trans('how_works.p3') }}</p>
                </br>
                <p>{{ trans('how_works.p4') }}</p>
            </div>
        </div>
        @include('frontend.layout.footer')
    </div>

@endsection
