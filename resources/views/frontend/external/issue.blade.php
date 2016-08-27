@extends('frontend.layout.master')

@section('content')

    <div class="container white">
        @include('frontend.layout.header')
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h4 style="margin-top: -2px;">
                    {{ $issue->name }}
                </h4><br>
                @include('frontend.partials.issue-details')
            </div>

        </div>
        @include('frontend.layout.footer')
    </div>

@endsection

@section('js')
    <script>
        (function() {
            $(document).ready(function() {
                if(window.location.hash) {
                    $('.nav-tabs a[href="' + window.location.hash + '"]').tab('show');
                }

                $('div.col-md-12.issues-list.panel-group.collapse:last').addClass('in');

                $('#refuse-alerts').on('submit', function (event) {
                    event.preventDefault();
                    var action = $('#refuse-alerts').attr('action');
                    if (action == '') {
                        return;
                    }
                });
            });
        }());
    </script>
@endsection
