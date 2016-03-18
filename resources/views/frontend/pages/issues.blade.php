@extends('frontend.layout.master')
@include('frontend.partials.user')

@section('content')

<div class="container white">
    @include('frontend.layout.header')
    <div class="row">
        <div class="col-md-4">
            @include('frontend.partials.domainsTree', ['domains' => $publicDomainsTree[1]['subdomains']])
        </div>
    </div>
    @include('frontend.layout.footer')
</div>

@endsection

