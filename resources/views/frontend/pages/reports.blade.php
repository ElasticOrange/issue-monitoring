@extends('frontend.layout.master')

@section('content')

<div class="container white">
    @include('frontend.layout.header')
    <div class="row" style="margin-top: -20px;">
        <div class="col-md-8 col-md-offset-2">
            <h2>Reports</h2>
        </div>
    </div><br><br><br>
    <div class="row" style="min-height: 400px;">
        <div class="col-md-3">
            <div class="panel-group" id="reports" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                                <a href="{{ action('HomeController@getReports', ['report_type' => 1]) }}"
                                    @if ($report_type == 1)
                                        style="font-weight: 700;"
                                    @endif
                                >
                                    Saptamanale
                                </a>
                        </h4>
                    </div>
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a href="{{ action('HomeController@getReports', ['report_type' => 2])}}"
                                @if ($report_type == 2)
                                    style="font-weight: 700;"
                                @endif
                            >
                                Lunare
                            </a>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="panel-group" id="reports-list">
                @foreach ($reports as $report)
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h5 class="panel-title">
                                <a class="accordion-toggle collapsed"
                                      data-toggle="collapse"
                                      data-parent="#reports-list"
                                      href="#reports_{{ $report->id }}"
                                      aria-expanded="false"
                                >

                                    <div class="glyph-background col-xs-1" style="margin-top: -4px;">
                                        <i class="indicator glyphicon glyphicon-plus"></i>
                                    </div>
                                    {{ $report->title}}
                                </a>
                            </h5>
                        </div>
                        <div id="reports_{{ $report->id }}" class="panel-collapse collapse" aria-expanded="false">
                            <div class="panel-body">
                                    {{ strip_tags($report->description) }}
                                <p>
                                    <br>
                                    @if(\Auth::user() and $report->file)
                                        <p>
                                            Descarca raportul:
                                            <a href="{{ action( "UploadedFileController@downloadFile" , [$report->file->file_name]) }}" target="_blank" title="{{ $report->file->original_file_name }}">
                                                <i class="fa fa-file-pdf-o" style="font-size: 18px;"></i>
                                            </a>
                                        </p>
                                    @else
                                        <a href="{{ action('Auth\AuthController@getLogin') }}">Pentru a downloada rapoartul trebuie să vă autentificați</a>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    <br />
                @endforeach
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
                $('#reports-list').on('hidden.bs.collapse', function toggleSign(e) {
                    $(e.target)
                            .prev('.panel-heading')
                            .find('i.indicator')
                            .toggleClass('glyphicon-plus glyphicon-minus');

                    $(e.target)
                            .prev('.panel-heading')
                            .find('div.glyph-background')
                            .css({'background-color': 'lightgrey'});
                });
                $('#reports-list').on('shown.bs.collapse', function toggleSign(e) {
                    $(e.target)
                            .prev('.panel-heading')
                            .find('i.indicator')
                            .toggleClass('glyphicon-plus glyphicon-minus');

                    $(e.target)
                            .prev('.panel-heading')
                            .find('div.glyph-background')
                            .css({'background-color': '#E02222', 'padding-left': '5px'});
                });
            });
        }());
    </script>
@endsection
