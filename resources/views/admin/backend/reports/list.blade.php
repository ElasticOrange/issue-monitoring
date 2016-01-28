@extends('admin.layouts.master')

@section('content')

    <div class="row">
        <div class="col-lg-12 text-left">
            <h1 class="page-header">Rapoarte</h1>
        </div>
    </div>

    <div class="row">
        <div class="form-group">
            <div class="col-md-2">
                <a href="{{ action('ReportController@create') }}"><button class="btn btn-primary form-control"><span class="glyphicon glyphicon-plus"></span> Adauga</button></a>
            </div>
        </div>
    </div>

    <br>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" data-table="true">
                            <thead>
                                <tr role="row">
                                    <th  class="text-center" style="width: 5%;">Id</th>
                                    <th  class="text-center" style="width: 25%;">Titlu</th>
                                    <th  class="text-center" style="width: 10%;">Data</th>
                                    <th  class="text-center" style="width: 10%;">Actiuni</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reports as $report)
                                    <tr class='gradeA odd' role="row">
                                        <td>{{ $report->id }}</td>
                                        <td>{{ $report->title }}</td>
                                        <td>{{ $report->date->format('d-m-Y') }}</td>
                                        <td class="text-center">
                                            <a href="{{ action('ReportController@edit', [$report])}}" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span></a>
                                            <a href=" {{ action('ReportController@destroy', [$report]) }}" class="btn btn-danger delete-button"><span class="glyphicon glyphicon-trash"></span></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
