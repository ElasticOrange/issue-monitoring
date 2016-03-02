@extends('admin.layouts.master')

@section('content')
    @include('admin.backend.step-autocomplete.delete-button', ['controller' => 'StepAutocompleteController'])
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
                        <table class="table table-striped table-bordered table-hover" data-table="true" id="step-autocomplete-table">
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script type="text/javascript" src="/js/stepAutocomplete.js"></script>
@endsection