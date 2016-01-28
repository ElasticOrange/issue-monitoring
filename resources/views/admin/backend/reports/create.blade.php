@extends('admin.layouts.master')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="col-sm-6">
            <h1>Adauga Raport</h1>
        </div>
    </div>
</div>

<hr>

<div class="row">
    <div class="col-md-12">
        <form   class="form-horizontal"
                method="POST"
                action="{{ action('ReportController@store', [$report]) }}"
                enctype="multipart/form-data"
                data-ajax="true"
                success-message="Raport salvat"
                success-url="{{ action('ReportController@index') }}"
                error-message="Eroare"
        >
            @include('admin.backend.reports.form')
            <div class="form-group">
                <div class="col-sm-4" style="margin-top:25px;">
                    <button class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span> Salveaza schimbari</button>
                    <a href="{{ action('ReportController@index') }}"<button class="btn btn-info"><span class="glyphicon glyphicon-th-list"></span> Inapoi la lista</button></a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
    <script type="text/javascript" src="/js/report.js"></script>
@endsection
