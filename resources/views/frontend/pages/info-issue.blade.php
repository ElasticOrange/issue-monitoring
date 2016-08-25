@extends('frontend.layout.master')

@section('content')

<div class="container white">
    @include('frontend.layout.header')
    <div class="row">
        <div class="col-md-3">
            @include('frontend.partials.domainsTree')
        </div>
        <div class="col-md-9">
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

                $('#refuse-alerts').on('submit', function (event) {
                    event.preventDefault();
                    var action = $('#refuse-alerts').attr('action');
                    var method = $('#refuse-alerts').attr('method');
                    var formData = $('#refuse-alerts').serializeArray();

                    var request = $.ajax({
                        url: action,
                        method: method,
                        data: formData,
                    });

                    function setAlert(type, message) {
                        $('.unsubscribe-alert').removeClass('hidden');
                        $('.unsubscribe-alert .alert').addClass(type);
                        $('.unsubscribe-alert .alert .caption').text(message);
                        setTimeout(function () {
                            $('.unsubscribe-alert').addClass('hidden');
                            $('.unsubscribe-alert .alert').removeClass(type);
                            $('.unsubscribe-alert .alert .caption').text("");
                        }, 4000);
                    }

                    request.done(function(data) {
                        console.error(data);
                        if (data.success == 'fail') {
                            setAlert('alert-danger', 'Error updating!');
                        } else if (data.success == 'unsubscribed') {
                            setAlert('alert-warning', 'Unsubscribed succesfully!');
                        } else if (data.success == 'doubleUnsubscribed') {
                            setAlert('alert-info', 'Already unsubscribed from this issue.');
                        } else if (data.success == 'subscribed') {
                            setAlert('alert-success', 'Subscribed succesfully!');
                        } else if (data.success == 'doubleSubscribed') {
                            setAlert('alert-info', 'Already subscribed for this issue.');
                        }
                    });
                });

                if(window.location.hash) {
                    $('.nav-tabs a[href="' + window.location.hash + '"]').tab('show');
                }

                $('div.col-md-12.issues-list.panel-group.collapse:last').addClass('in');

                $('#domains').on('hidden.bs.collapse', function toggleTriangle(e) {
                    $(e.target)
                            .prev('.panel-heading')
                            .find('i.indicator')
                            .toggleClass('glyphicon-triangle-right glyphicon-triangle-bottom');
                });
                $('#domains').on('shown.bs.collapse', function toggleTriangle(e) {
                    $(e.target)
                            .prev('.panel-heading')
                            .find('i.indicator')
                            .toggleClass('glyphicon-triangle-right glyphicon-triangle-bottom');
                });

                function selectDomainWhenFilterIssue(domainIdToHighlight) {
                    var element = $('#domains').find('a[id-domain=' + domainIdToHighlight + ']');
                    var iconSelector = element
                        .parent()
                        .parent()
                        .parent()
                        .attr('id');

                    element.parent().parent().parent()
                        .attr('aria-expanded', 'true')
                        .addClass('in');

                    element.css('font-weight', 'bold');

                    $('#domains').find('a[href="#' + iconSelector + '"] i.indicator')
                        .removeClass('glyphicon-triangle-right')
                        .addClass('glyphicon-triangle-bottom');
                }

                var domainIdToHighlight = {{ $domain }}
                console.log(domainIdToHighlight);

                if(domainIdToHighlight) {
                    selectDomainWhenFilterIssue(domainIdToHighlight);
                }

            });
        }());
    </script>
@endsection
