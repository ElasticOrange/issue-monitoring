@extends('frontend.layout.master')

@section('content')

    <div class="container white">
        @include('frontend.layout.header')
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                @include('frontend.partials.stakeholder-details')
            </div>

        </div>
        @include('frontend.layout.footer')
    </div>

@endsection
