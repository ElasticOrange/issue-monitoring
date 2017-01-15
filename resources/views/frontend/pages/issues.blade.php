@extends('frontend.layout.master')

@section('content')

<div class="container white">
    @include('frontend.layout.header')
    <div class="row" style="margin-top: -20px;">
        <div class="col-md-8 col-md-offset-3">
            <h2>
                <a href="{{ url('/issues') }}?issue_search=&type=&phase=curent">
                    {{ trans('home.initiatives') }}
                </a>
            </h2><br><br>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            @include('frontend.partials.domainsTree')
        </div>
        <div class="col-md-9" style="min-height: 690px;">
            <form method="GET">
                @if($domain)
                    <input type="hidden" name="domain" value="{{ $domain }}">
                @endif
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <div class="input-group">
                        <input type="text"
                               name="issue_search"
                               class="form-control"
                               placeholder="Search"
                               @if($issue_search)
                                   value="{{ $issue_search }}"
                               @endif
                        >
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit"> Search </button>
                            </span>
                        </div>
                    </div>
                </div>
                <br />

                <div class="row">
                    <br>
                    <div class="form-group">
                        <div class="col-md-5 col-md-offset-1">
                            <select class="form-control auto-refresh" name="type">
                                <option value="">{{ trans('issue.issue_type') }}</option>
                                <option value="Propunere legislativă" @if($type == "Propunere legislativă") selected="selected" @endif>{{ trans('issue.legislative_proposal') }}</option>
                                <option value="Proiect de lege" @if($type == "Proiect de lege") selected="selected" @endif>{{ trans('issue.bill') }}</option>
                                <option value="Decizie" @if($type == "Decizie") selected="selected" @endif>{{ trans('issue.decision') }}</option>
                                <option value="Ordin" @if($type == "Ordin") selected="selected" @endif>{{ trans('issue.order') }}</option>
                                <option value="Hotărâre de Guvern" @if($type == "Hotărâre de Guvern") selected="selected" @endif>{{ trans('issue.government_resolution') }}</option>
                                <option value="Ordonanță" @if($type == "Ordonanță") selected="selected" @endif>{{ trans('issue.ordinance') }}</option>
                                <option value="Directivă europeană" @if($type == "Directivă europeană") selected="selected" @endif>{{ trans('issue.european_directive') }}</option>
                                <option value="Regulament" @if($type == "Regulament") selected="selected" @endif>{{ trans('issue.regulation') }}</option>
                                <option value="Plan" @if($type == "Plan") selected="selected" @endif>{{ trans('issue.plan') }}</option>
                                <option value="Strategie" @if($type == "Strategie") selected="selected" @endif>{{ trans('issue.strategy') }}</option>
                                <option value="Memorandum" @if($type == "Memorandum") selected="selected" @endif>{{ trans('issue.memorandum') }}</option>
                                <option value="Program" @if($type == "Program") selected="selected" @endif>{{ trans('issue.program') }}</option>
                                <option value="Instructiune" @if($type == "Instructiune") selected="selected" @endif>{{ trans('issue.instruction') }}</option>
                                <option value="Tip" @if($type == "Tip") selected="selected" @endif>{{ trans('issue.type') }}</option>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <select class="form-control auto-refresh" name="phase">
                                <option value="">{{ trans('issue.phase') }}</option>
                                <option value="curent" @if($phase == "curent") selected="selected" @endif>{{ trans('issue.current') }}</option>
                                <option value="viitor" @if($phase == "viitor") selected="selected" @endif>{{ trans('issue.future') }}</option>
                                <option value="arhivatRespinsSauAbrogat" @if($phase == "arhivatRespinsSauAbrogat") selected="selected" @endif>{{ trans('issue.archived_rejected') }}</option>
                                <option value="arhivatInactiv" @if($phase == "arhivatInactiv") selected="selected" @endif>{{ trans('issue.archived_inactive') }}</option>
                                <option value="publicatMO" @if($phase == "publicatMO") selected="selected" @endif>{{ trans('issue.in_effect') }}</option>
                            </select>
                        </div>
                    </div>
                </div>
            <br />
            </form>

            <div class="row">
                <div class="col-sm-12">
                    <div class="panel-group" id="issues">
                        @foreach($issues as $issue)
                            @include('frontend.partials.issuesList', ['issue' => $issue])
                        @endforeach
                    </div>
                </div>
                {!! $issues->appends([
                    'domain' => $domain,
                    'issue_search' => $issue_search,
                    'type' => $type,
                    'phase' => $phase,
                    ])->render() !!}
            </div>
        </div>
    </div>
    @include('frontend.layout.footer')
</div>

@endsection

@section('js')
    <script>
        (function() {
            $(document).ready(function() {
                $('.auto-refresh').change(function() {
                    $(this).parents('form').submit();
                });
                $('#issues').on('hidden.bs.collapse', function toggleSign(e) {
                    $(e.target)
                            .prev('.panel-heading')
                            .find('i.indicator')
                            .toggleClass('glyphicon-plus glyphicon-minus');

                    $(e.target)
                            .prev('.panel-heading')
                            .find('div.glyph-background')
                            .css({'background-color': 'lightgrey'});
                });
                $('#issues').on('shown.bs.collapse', function toggleSign(e) {
                    $(e.target)
                            .prev('.panel-heading')
                            .find('i.indicator')
                            .toggleClass('glyphicon-plus glyphicon-minus');

                    $(e.target)
                            .prev('.panel-heading')
                            .find('div.glyph-background')
                            .css({'background-color': '#E02222', 'padding-left': '5px'});
                });

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
