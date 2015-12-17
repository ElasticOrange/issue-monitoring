@extends('admin.layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-12 text-left">
            <h1 class="page-header">Stadii procedurale</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" data-table="true">
                            <thead>
                            <tr role="row">
                                <th class="text-center" style="width: 10%;">Id</th>
                                <th class="text-center" style="width: 80%;">Nume</th>
                                <th class="text-center" style="width: 10%;">Actiuni</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($steps as $step)
                                <tr class="gradeA odd" role="row">
                                    <td>{{ $step->id }}</td>
                                    <td>{{ $step->name }}</td>
                                    </td>
                                    <td class="text-center">
                                        <div class="row">
                                            <a href="{{ action('StepAutocompleteController@destroy', [$step]) }}" class="btn btn-danger delete-button"><span class="glyphicon glyphicon-trash"></span></a>
                                        </div>
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
