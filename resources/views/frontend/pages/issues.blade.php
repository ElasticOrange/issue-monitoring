@extends('frontend.layout.master')
@include('frontend.partials.user')

@section('content')

<div class="container white">
    @include('frontend.layout.header')
    <div class="row">
        <div class="col-md-4">
            @include('frontend.partials.domainsTree')
        </div>
        <div class="col-md-8">
            <form method="POST">
                {!! csrf_field() !!}
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <div class="input-group">
                        <input type="text" name="issue_search" class="form-control" placeholder="Search" required>
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit"> Search </button>
                            </span>
                        </div>
                    </div>
                </div>
                <br />

                <div class="row">
                    <div class="col-sm-3 col-sm-offset-2">
                        <label>
                            <input  type="checkbox"
                                    value="1"
                                    name="viitor"
                                    checked="checked"
                                    />viitor
                        </label>
                    </div>
                    <div class="col-sm-3">
                        <label>
                            <input  type="checkbox"
                                    value="1"
                                    name="curent"
                                    checked="checked"
                                    />curent
                        </label>
                    </div>
                    <div class="col-sm-2">
                        <label>
                            <input  type="checkbox"
                                    value="1"
                                    name="arhivat"
                                    checked="checked"
                                    />arhivat
                        </label>
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
            </div>
        </div>
    </div>
    @include('frontend.layout.footer')
</div>

@endsection

@section('js')
    <script>
        $(document).ready(function() {
            var domainIdToHighlight = {{ $domainIdToHighlight }}

            function toggleSign(e) {
                $(e.target)
                    .prev('.panel-heading')
                    .find('i.indicator')
                    .toggleClass('glyphicon-plus glyphicon-minus');
            }
            $('#issues').on('hidden.bs.collapse', toggleSign);
            $('#issues').on('shown.bs.collapse', toggleSign);

            function toggleTriangle(e) {
                $(e.target)
                    .prev('.panel-heading')
                    .find('i.indicator')
                    .toggleClass('glyphicon-triangle-right glyphicon-triangle-bottom');
            }
            $('#domains').on('hidden.bs.collapse', toggleTriangle);
            $('#domains').on('shown.bs.collapse', toggleTriangle);

            function selectDomainWhenFilterIssue() {
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

            selectDomainWhenFilterIssue();
        });
    </script>
@endsection
