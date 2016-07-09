@extends('frontend.layout.master')

@section('content')

    <div class="container white">
        @include('frontend.layout.header')
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @include('frontend.partials.report-details')
            </div>

        </div>
        @include('frontend.layout.footer')
    </div>

@endsection