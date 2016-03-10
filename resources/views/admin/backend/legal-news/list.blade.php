@extends('admin.layouts.master')

@section('content')
    @include('admin.backend.issues.action_buttons', ['controller' => 'LegalNewsController'])

    <div class="row">
        <div class="col-lg-12 text-left">
            <h1 class="page-header">Noutati legislative</h1>
        </div>
    </div>

    <br>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" data-table="true" id="legal-news-table">
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript" src="/js/legal-news.js"></script>
@endsection
