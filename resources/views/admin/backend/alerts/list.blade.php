@extends('admin.layouts.master')

@section('content')
<div class="row">
    <div class="col-lg-12 text-left">
        <h1 class="page-header">Alerte</h1>
    </div>
</div>

<ul class="nav nav-tabs">
    <li class="active"><a href="#netrimise" data-toggle="tab"><strong>Netrimise</strong></a></li>
    <li><a href="#trimise" data-toggle="tab"><strong>Trimise</strong></a></li>
</ul>

<div class="tab-content">
    <br/>
    <div class="tab-pane active" id="netrimise">
        <br/>

        <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" data-table="true">
                            <thead>
                            <tr role="row">
                                <th class="text-center" style="width: 5%;">Id</th>
                                <th class="text-center" style="width: 10%;">Type</th>
                                <th class="text-center" style="width: 70%;">Item title</th>
                                <th class="text-center" style="width: 5%;">Generated</th>
                                <th class="text-center" style="width: 10%;">Actiuni</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($alerts as $alert)
                                @if(is_object($alert->alertable) && $alert->sent == 0)
                                    @if($alert->alertable_type == 'Issue\FlowStep' && !$alert->alertable->flowstepsInLocation->issue)
                                    @else
                                        <tr class="gradeA odd" role="row">
                                            <td>{{ $alert->id }}</td>
                                            <td>{{ $alert->alertable_type }}</td>
                                            @if($alert->alertable_type == 'Issue\News')
                                                <td>{{ $alert->alertable->title }}</td>
                                            @elseif($alert->alertable_type == 'Issue\Issue')
                                                <td>{{ $alert->alertable->name }}</td>
                                            @elseif($alert->alertable_type == 'Issue\FlowStep')
                                                <td>{{ $alert->alertable->flow_name }}</td>
                                            @elseif($alert->alertable_type == 'Issue\Report')
                                                <td>{{ $alert->alertable->title }}</td>
                                            @endif
                                            <td>{{ $alert->created_at }}</td>
                                            <td class="text-center">
                                                <div class="row">
                                                @if($alert->alertable_type == 'Issue\News')
                                                    <a href="{{ action('NewsController@edit', [$alert->alertable_id]) }}" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span></a>
                                                @elseif($alert->alertable_type == 'Issue\Issue')
                                                    <a href="{{ action('IssueController@edit', [$alert->alertable_id]) }}" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span></a>
                                                @elseif($alert->alertable_type == 'Issue\FlowStep')
                                                    <a href="{{ action('IssueController@edit', [$alert->alertable->flowstepsInLocation->issue->id]) }}" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span></a>
                                                @elseif($alert->alertable_type == 'Issue\Report')
                                                    <a href="{{ action('ReportController@edit', [$alert->alertable_id]) }}" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span></a>
                                                @endif

                                                <a href="{{ action('AlertController@preview', [$alert->id]) }}" class="btn btn-primary"><span class="glyphicon glyphicon-eye-open"></span></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>

    <div class="tab-pane" id="trimise">
        <br/>
        <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" data-table="true">
                            <thead>
                            <tr role="row">
                                <th class="text-center" style="width: 15%;">Id</th>
                                <th class="text-center" style="width: 10%;">Type</th>
                                <th class="text-center" style="width: 70%;">Item title</th>
                                <th class="text-center" style="width: 5%;">Generated</th>
                                <th class="text-center" style="width: 10%;">Actiuni</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($alerts as $alert)
                                @if(is_object($alert->alertable) && $alert->sent == 1)
                                    @if($alert->alertable_type == 'Issue\FlowStep' && !$alert->alertable->flowstepsInLocation->issue)
                                    @else
                                        <tr class="gradeA odd" role="row">
                                            <td>{{ $alert->id }}</td>
                                            <td>{{ $alert->alertable_type }}</td>
                                            @if($alert->alertable_type == 'Issue\News')
                                                <td>{{ $alert->alertable->title }}</td>
                                            @elseif($alert->alertable_type == 'Issue\Issue')
                                                <td>{{ $alert->alertable->name }}</td>
                                            @elseif($alert->alertable_type == 'Issue\FlowStep')
                                                <td>{{ $alert->alertable->flow_name }}</td>
                                            @elseif($alert->alertable_type == 'Issue\Report')
                                                <td>{{ $alert->alertable->title }}</td>
                                            @endif
                                            <td>{{ $alert->created_at }}</td>
                                            <td class="text-center">
                                                <div class="row">
                                                @if($alert->alertable_type == 'Issue\News')
                                                    <a href="{{ action('NewsController@edit', [$alert->alertable_id])}}" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span></a>
                                                @elseif($alert->alertable_type == 'Issue\Issue')
                                                    <a href="{{ action('IssueController@edit', [$alert->alertable_id])}}" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span></a>
                                                @elseif($alert->alertable_type == 'Issue\FlowStep')
                                                    <a href="{{ action('IssueController@edit', [$alert->alertable->flowstepsInLocation->issue->id]) }}" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span></a>
                                                @elseif($alert->alertable_type == 'Issue\Report')
                                                    <a href="{{ action('ReportController@edit', [$alert->alertable_id])}}" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span></a>
                                                @endif
                                                </div>

                                                <a href="{{ action('AlertController@preview', [$alert->id])}}" class="btn btn-primary"><span class="glyphicon glyphicon-eye-open"></span></a>
                                            </td>
                                        </tr>
                                    @endif
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

@endsection
