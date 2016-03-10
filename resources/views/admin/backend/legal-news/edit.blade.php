@extends('admin.layouts.master')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="col-sm-6">
            <h1>Modifica Noutati Legislative</h1>
        </div>
    </div>
</div>

<hr>

<div class="row">
    <div class="col-md-12">
        <form   class="form-horizontal"
                method="POST"
                action="{{ action('LegalNewsController@update', [$legalNews]) }}"
                enctype="multipart/form-data"
                data-ajax="true"
                success-message="Item salvat"
                success-url="{{ action('LegalNewsController@index') }}"
                error-message="Eroare"
        >
            <input name="_method" type="hidden" value="PUT"/>
            @include('admin.backend.legal-news.form')

            <div class="form-group">
                <div class="col-sm-4" style="margin-top:25px;">
                    <button class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span> Salveaza schimbari</button>
                    <a href="{{ action('LegalNewsController@index') }}"><button type="button" class="btn btn-info"><span class="glyphicon glyphicon-th-list"></span> Inapoi la lista</button></a>
                </div>
                <div class="col-sm-2 col-sm-offset-6" style="margin-top:25px;">
                <a href="{{ action("LegalNewsController@destroy", [$legalNews]) }}" class="btn btn-danger delete-button"><span class="glyphicon glyphicon-trash"></span> Sterge</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
    <script type="text/javascript" src="/js/legal-news.js"></script>
@endsection
