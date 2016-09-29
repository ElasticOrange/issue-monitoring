@extends('frontend.layout.master')

@section('content')

<div class="container white">
    @include('frontend.layout.header')
    <div class="row" style="margin-top: -20px;">
        <div class="col-md-10 col-md-offset-1">
            <h2>{{ trans('team.t1') }}</h2>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <p><b>Octavian Rusu</b> {{ trans('team.p1') }}</p>
                    </br>
                    <p>{{ trans('team.p2') }}</p>
                    </br>
                    <p>{{ trans('team.p3') }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <p><b>Alexandra Preda</b>, {{ trans('team.p4') }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <p><b>{{ trans('team.monitoring_team') }}</b> {{ trans('team.monitoring_team_phrase') }}</p>
                </div>
            </div>
            </div>
        </div>
    @include('frontend.layout.footer')
</div>

@endsection
