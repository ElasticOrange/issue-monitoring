@extends('frontend.layout.master')

@section('content')

<div class="container white">
    @include('frontend.layout.header')
    <div class="row">
        <div class="col-md-3">
            @include('frontend.partials.domainsTree')
        </div>
        <div class="col-md-9">
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
