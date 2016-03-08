<input type="hidden" name="_token" value="{{ csrf_token() }}">
<ul class="nav nav-tabs">
    <li class="active"><a href="#report_ro" data-toggle="tab">RO</a></li>
    <li><a href="#report_en" data-toggle="tab">EN</a></li>
</ul>

<div class="tab-content">
    <div class="tab-pane active" id="report_ro">
        <div class="form-group">
            <br/>
            <label class="col-md-2 control-label">Titlu</label>
            <div class="col-md-8">
                <textarea type="text"
                       rows="3"
                       prevent-enter="true"
                       name="title[ro]"
                       class="form-control">{{ $report->translateOrNew('ro')->title}}</textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">Descriere</label>
            <div class="col-md-8">
                <textarea name="description[ro]" id="editor1" class="form-control" rows="3">{{ $report->translateOrNew('ro')->description}}</textarea>
            </div>
        </div>
    </div>

    <div class="tab-pane" id="report_en">
        <div class="form-group">
            <br/>
            <label class="col-md-2 control-label">Title</label>
            <div class="col-md-8">
                <textarea type="text"
                       prevent-enter="true"
                       rows="3"
                       name="title[en]"
                       class="form-control">{{ $report->translateOrNew('en')->title}}</textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">Description</label>
            <div class="col-md-8">
                <textarea name="description[en]" id="editor2" class="form-control" rows="3">{{ $report->translateOrNew('en')->description}}</textarea>
            </div>
        </div>
    </div>
</div>

<hr>

<div class="form-group">
    <label class="col-md-2 control-label">Data</label>
    <div class="col-md-8">
        <input type="text" date-widget="true" id="date-init" name="date_init" class="form-control" value="{{ $report->date ? $report->date->format('d-m-Y') : '' }}"/>
        <input type="hidden" id="date-result" name="date">
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">Document</label>
    <div class="col-md-8">
        <label>
            <span class="btn btn-primary selected-file ellipsis">Incarca fisier</span>
            <input type="file" name="document_file" class="hidden"/>
        </label>
        @if($report->file)
            <a href="{{ action( "UploadedFileController@downloadFile" , [$report->file->file_name]) }}" file-show="true" target="_blank">
                <i class="fa fa-file-pdf-o"></i>
                {{ $report->file->original_file_name }}
            </a>
            <a href="{{ action('ReportController@deleteFile', [$report])}}"
                delete-file="true"
                class="delete-button"
                style="margin-left: 10px;"
            >
                <span class="glyphicon glyphicon-remove" style="color:red;" title="Sterge fisier"></span>
            </a>
        @endif
    </div>
</div>

<hr/>

<div class="form-group">
    <div class="col-md-2 text-right">
        <label for="domain-autocomplete" class="control-label">Domenii</label>
    </div>
    <div class="col-md-8">
        <input
            id="domain-autocomplete"
            source-url="{{ action('IssueController@queryDomain') }}/?name={name}"
            type="text"
            placeholder="Nume"
            class="form-control"
            prevent-enter="true"
                />
    </div>
</div>

<div class="form-group">
    @include('admin.backend.news.connected-domain')
    <div class="panel panel-success col-md-8 col-md-offset-2">
        <div class="panel-heading">Domenii conectate</div>
        <div class="list-group" id="connected-domains-container">
            @foreach ($report->domains as $domain_connected)
                <div class="list-group-item" domain-id="{{ $domain_connected->id }}">
                    <a class="badge" connected-domain-delete="{{ $domain_connected->id }}">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> sterge
                    </a>
                    <h4 class="list-group-item-heading">{{ $domain_connected->name }}</h4>
                    <p class="list-group-item-text"></p>
                    <input type="hidden" name="domains_connected[]" value="{{ $domain_connected->id }}" />
                </div>
            @endforeach
        </div>
    </div>
</div>

<hr/>

<div class="form-group">
    <label class="col-md-2 control-label">Tipul raportului</label>
    <div class="col-md-8">
        <select class="form-control" name="report_type">
            <option value=""></option>
            <option value="1" @if($report->report_type === '1') selected="selected" @endif>Saptamanal</option>
            <option value="2" @if($report->report_type === '2') selected="selected" @endif>Lunar</option>
            <option value="3" @if($report->report_type === '3') selected="selected" @endif>Progres</option>
            <option value="4" @if($report->report_type === '4') selected="selected" @endif>Minuta</option>
        </select>
    </div>
</div><br/><br/>
<hr>

<div class="form-group">
    <div class="checkbox col-md-8 col-md-offset-2">
        <label>
            <input  type="checkbox"
                    value="1"
                    name="public"
                    @if($report->public)
                        checked="checked"
                    @endif
            />Arata pe prima pagina
        </label>
    </div>
</div>

<hr>

<div class="form-group">
    <div class="checkbox col-md-8 col-md-offset-2">
        <label>
            <input  type="checkbox"
                    value="1"
                    name="published"
                    @if(! $report->alerts()->notSent()->get()->isEmpty())
                        checked="checked"
                    @endif
            />Publica
        </label>
    </div>
</div>

<hr/>
