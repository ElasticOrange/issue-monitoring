@extends('frontend.layout.master')

@section('content')

<div class="container white">
    @include('frontend.layout.header')
    <div class="row" style="margin-top: -20px;">
        <div class="col-md-10 col-md-offset-1">
            <h2>{{ trans('services.title') }}</h2>
            <br>
            <p>{{ trans('services.p1') }}</p>
            <p>{{ trans('services.p2') }}</p>
            <ul>
                <li>{{ trans('services.li1') }}</li>
                <li>{{ trans('services.li2') }}</li>
                <li>{{ trans('services.li3') }}</li>
                <li>{{ trans('services.li4') }}</li>
                <li>{{ trans('services.li5') }}</li>
                <li>{{ trans('services.li6') }}</li>
            </ul>
            <p>{{ trans('services.t2') }}</p>
            <ul>
                <li>{{ trans('services.li7') }}</li>
                <li>{{ trans('services.li8') }}</li>
                <li>{{ trans('services.li9') }}</li>
            </ul>
            <p>{{ trans('services.p3') }}</p>
            </br>
            <p>{{ trans('services.p4') }}</p>
        </div>
    </div>
    @include('frontend.layout.footer')
</div>

@endsection
