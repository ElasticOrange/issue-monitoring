@extends('frontend.layout.master')

@section('content')
<div class="container white">
    @include('frontend.layout.header')
    <div class="row" style="margin-top: -20px;">
        <div class="col-md-8 col-md-offset-3">
            <h2>
                <a href="{{ url('/reports') }}">
                    {{ trans('home.reports') }}
                </a>
            </h2>
        </div>
    </div><br><br><br>
    <div class="row" style="min-height: 400px;">
        <div class="col-md-3">
            @include('frontend.partials.domainsTreeForReports')
        </div>
        <div class="col-md-9">
            <form method="GET">
                @if($domain)
                    <input type="hidden" name="domain" value="{{ $domain }}">
                @endif
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <select class="form-control" name="report_type">
                                <option value="">{{ trans('reports.report_type') }}</option>
                                <option value="4" @if($report_type == 4) selected="selected" @endif>{{ trans('reports.minute') }}</option>
                                <option value="3" @if($report_type == 3) selected="selected" @endif>{{ trans('reports.progress') }}</option>
                                <option value="1" @if($report_type == 1) selected="selected" @endif>{{ trans('reports.weekly') }}</option>
                                <option value="2" @if($report_type == 2) selected="selected" @endif>{{ trans('reports.monthly') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-9">
                        <div class="input-group">
                        <input type="text"
                               name="report_search"
                               class="form-control"
                               placeholder="Search"
                               @if($report_search)
                                   value="{{ $report_search }}"
                               @endif
                        >
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit"> Search </button>
                            </span>
                        </div>
                    </div>
                </div>
            </form>

            <br />

            <div class="panel-group" id="reports-list">
                @foreach ($reports as $report)
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h5 class="panel-title">
                                {{ $report->title}}
                            </h5>
                        </div>
                        <div class="panel-body">
                                {{ strip_tags($report->description) }}
                            <p>
                                <br>
                                @if(\Auth::user() and $report->file)
                                    <p>
                                        {{ trans('reports.download_report') }}:
                                        <a href="{{ action( "UploadedFileController@downloadFile" , [$report->file->file_name]) }}" target="_blank" title="{{ $report->file->original_file_name }}">
                                            <i class="fa fa-file-pdf-o" style="font-size: 18px;"></i>
                                        </a>
                                    </p>
                                @else
                                    <a href="{{ action('Auth\AuthController@getLogin') }}">{{ trans('reports.login_to_download') }}</a>
                                @endif
                            </p>
                        </div>
                    </div>
                    <br />
                @endforeach
                {!! $reports->appends([
                    'report_search' => $report_search,
                    'domain'        => $domain,
                    'report_type'   => $report_type
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

                $('select[name="report_type"]').on('focus', function() {
                    $(this).find('option:first').attr('disabled', 'disabled');
                });

                var domainIdToHighlight = {{ $domain }}
                console.log(domainIdToHighlight);

                if(domainIdToHighlight) {
                    selectDomainWhenFilterIssue(domainIdToHighlight);
                }
            });
        }());
    </script>
@endsection
