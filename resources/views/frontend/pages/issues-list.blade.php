@extends('frontend.layout.master')

@section('content')

    <div class="container white">
        @include('frontend.layout.header')
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="panel-group" id="issues">
                    @foreach($issues as $issue)
                        @include('frontend.partials.issuesList', ['issue' => $issue])
                    @endforeach
                </div>
                {!! $issues->render() !!}
            </div>
        </div>
        @include('frontend.layout.footer')
    </div>

@endsection