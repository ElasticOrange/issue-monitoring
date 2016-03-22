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

@section('js')
    <script>
        (function(){
            $(document).ready(function() {
                $('div.panel-heading h4.panel-title a[data-toggle=collapse]').on('click', function(event) {
                      $(this).find('span.glyphicon').toggleClass("glyphicon-triangle-right glyphicon-triangle-bottom");
                });
            });
        })();
    </script>
@endsection
