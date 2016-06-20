@extends('frontend.layout.master')

@section('content')

<div class="container white">
    @include('frontend.layout.header')
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
                    <div class="col-sm-3 col-sm-offset-2 checkbox-inline">
                        <label>
                            <input  type="checkbox"
                                    class="auto-refresh"
                                    value="1"
                                    name="viitor"
                                    @if($viitor)
                                        checked="checked"
                                    @endif
                                    />viitor
                        </label>
                    </div>
                    <div class="col-sm-3 checkbox-inline">
                        <label>
                            <input  type="checkbox"
                                    class="auto-refresh"
                                    value="1"
                                    name="curent"
                                    @if($curent or empty($all))
                                        checked="checked"
                                    @endif
                                    />curent
                        </label>
                    </div>
                    <div class="col-sm-2 checkbox-inline">
                        <label>
                            <input  type="checkbox"
                                    class="auto-refresh"
                                    value="1"
                                    name="arhivat"
                                    @if($arhivat)
                                        checked="checked"
                                    @endif
                                    />arhivat
                        </label>
                    </div>
                </div>
                <div class="row">
                    <br>
                    <div class="form-group">
                        <div class="col-md-5 col-md-offset-1">
                            <select class="form-control" name="type">
                                <option value="">Tipul inițiativei</option>
                                <option value="Propunere legislativă" @if($type == "Propunere legislativă") selected="selected" @endif>Propunere legislativă</option>
                                <option value="Proiect de lege" @if($type == "Proiect de lege") selected="selected" @endif>Proiect de lege</option>
                                <option value="Decizie" @if($type == "Decizie") selected="selected" @endif>Decizie</option>
                                <option value="Ordin" @if($type == "Ordin") selected="selected" @endif>Ordin</option>
                                <option value="Hotărâre de Guvern" @if($type == "Hotărâre de Guvern") selected="selected" @endif>Hotărâre de Guvern</option>
                                <option value="Ordonanță" @if($type == "Ordonanță") selected="selected" @endif>Ordonanță</option>
                                <option value="Directivă europeană" @if($type == "Directivă europeană") selected="selected" @endif>Directivă europeană</option>
                                <option value="Regulament" @if($type == "Regulament") selected="selected" @endif>Regulament</option>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <select class="form-control" name="phase">
                                <option value="">Faza inițiativei</option>
                                <option value="arhivatRespinsSauAbrogat" @if($phase == "arhivatRespinsSauAbrogat") selected="selected" @endif>Arhivată – Respinsă sau abrogată </option>
                                <option value="arhivatInactiv" @if($phase == "arhivatInactiv") selected="selected" @endif>Arhivată – Inactivă</option>
                                <option value="publicatMO" @if($phase == "publicatMO") selected="selected" @endif>Publicat in Monitorul Oficial</option>
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
                    'viitor' => $viitor,
                    'curent' => $curent,
                    'arhivat' => $arhivat
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
