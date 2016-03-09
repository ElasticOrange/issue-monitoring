<input type="hidden" name="_token" value="{{ csrf_token() }}">
<ul class="nav nav-tabs">
    <li class="active"><a href="#informatii-generale" data-toggle="tab"><strong>Informatii generale</strong></a></li>
    <li><a href="#flux" data-toggle="tab"><strong> Flux</strong></a></li>
</ul>

<div class="tab-content">
    <br/>
    <div class="tab-pane active" id="informatii-generale">
        <br/>

        <div class="form-group">
            <label class="col-md-2 control-label">Tip</label>
            <div class="col-md-8">
                <select class="form-control" name="type">
                @foreach(\Config::get('issueTypes') as $type => $locale)
                    <option value="{{ $type }}"
                        @if(isset($issue->type) && $issue->type == $type)
                            selected="selected"
                        @endif
                    >{{ $type }}</option>
                @endforeach
                </select>
            </div>
        </div>

        <ul class="nav nav-tabs">
            <li class="active"><a href="#ro" data-toggle="tab">RO</a></li>
            <li><a href="#en" data-toggle="tab">EN</a></li>
        </ul>

        <div class="tab-content">
            <br/>
            <div class="tab-pane active" id="ro">

                <div class="form-group">
                    <label class="col-md-2 control-label">Nume</label>
                    <div class="col-md-8">
                        <textarea type="text"
                                prevent-enter="true"
                                name-ro="true" name="name[ro]"
                                rows="3"
                                class="form-control">{{ $issue->translateOrNew('ro')->name }}</textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Descriere</label>
                    <div class="col-md-8">
                        <textarea   name="description[ro]"
                                    id="editor1"
                                    class="form-control"
                                    rows="3"
                        >{{ $issue->translateOrNew('ro')->description }}</textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Impact asupra altor legi</label>
                    <div class="col-md-8">
                        <textarea   name="impact[ro]"
                                    id="editor2"
                                    class="form-control"
                                    rows="3"
                        >{{ $issue->translateOrNew('ro')->impact }}</textarea>
                    </div>
                </div>

                <div class="form-group" stakeholder-position="true">
                    <label class="col-md-2 control-label">Status</label>
                    <div class="col-md-8">
                        <textarea   name="status[ro]"
                                    id="editor3"
                                    class="form-control"
                                    rows="3"
                           >{{ $issue->translateOrNew('ro')->status }}</textarea>
                    </div>
                </div>

            </div>
            <div class="tab-pane" id="en">

                <div class="form-group">
                    <label class="col-md-2 control-label">Name</label>
                    <div class="col-md-8">
                        <textarea type="text"
                                  prevent-enter="true"
                                  name-en="true" name="name[en]"
                                  rows="3"
                                  class="form-control">{{ $issue->translateOrNew('en')->name }}</textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Description</label>
                    <div class="col-md-8">
                        <textarea   name="description[en]"
                                    id="editor4"
                                    class="form-control"
                                    rows="3"
                        >{{ $issue->translateOrNew('en')->description }}</textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Impact on other laws</label>
                    <div class="col-md-8">
                        <textarea   name="impact[en]"
                                    id="editor5"
                                    class="form-control"
                                    rows="3"
                        >{{ $issue->translateOrNew('en')->impact }}</textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Status</label>
                    <div class="col-md-8">
                        <textarea   name="status[en]"
                                    id="editor6"
                                    class="form-control"
                                    rows="3"
                           >{{ $issue->translateOrNew('en')->status }}</textarea>
                    </div>
                </div>

            </div><br/>

            <div class="form-group">
                <div class="row">
                    <div class="checkbox col-md-3 col-md-offset-2">
                        <label>
                            <input  type="checkbox"
                                    value="1"
                                    name="published"
                                    @if(! $issue->alerts()->notSent()->get()->isEmpty())
                                        checked="checked"
                                    @endif
                            />Publica
                        </label>
                    </div>
                    <div class="checkbox col-md-3">
                        <label>
                            <input  type="checkbox"
                                    value="1"
                                    name="addToLegalNews"
                            />Adauga la noutati legislative
                        </label>
                    </div>
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
                @include('admin.backend.issues.connected-domain')
                <div class="panel panel-success col-md-8 col-md-offset-2">
                    <div class="panel-heading">Domenii conectate</div>
                    <div class="list-group" id="connected-domains-container">
                        @foreach ($issue->connectedDomains as $domain_connected)
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
                <div class="col-md-2 text-right">
                    <label for="stakeholder-autocomplete" class="control-label">Stakeholderi</label>
                </div>
                <div class="col-md-8">
                    <input
                        id="stakeholder-autocomplete"
                        source-url="{{ action('IssueController@queryStakeholder') }}/?name={name}"
                        type="text"
                        placeholder="Nume"
                        class="form-control"
                        prevent-enter="true"
                            />
                </div>
            </div>

            <div class="form-group">
                @include('admin.backend.issues.connected-stakeholder')
                <div class="panel panel-success col-md-8 col-md-offset-2">
                    <div class="panel-heading">Stakeholderi conectati</div>
                    <div class="list-group" id="connected-stakeholders-container">
                        @foreach ($issue->connectedStakeholders as $stakeholder_connected)
                            <div class="list-group-item" stakeholder-id="{{ $stakeholder_connected->id }}">
                                <a class="badge" connected-stakeholder-delete="{{ $stakeholder_connected->id }}">
                                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> sterge
                                </a>
                                <h4 class="list-group-item-heading">{{ $stakeholder_connected->name }}</h4>
                                <p class="list-group-item-text"></p>
                                <input type="hidden" name="stakeholders_connected[]" value="{{ $stakeholder_connected->id }}" />
                            </div>
                        @endforeach
                    </div>
                </div>
            </div><br/>
            <div class="row">
                <div class="form-group">
                    <div class=" col-sm-4 col-sm-offset-2">
                    <a href="{{ action('StakeholderController@create') }}" target="_blank" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Adauga stakeholder</a>
                    </div>
                </div>
            </div>

            <hr/>

            <div class="form-group">
                <div class="col-md-2 text-right">
                    <label for="initiator-autocomplete" class="control-label">Initiatori</label>
                </div>
                <div class="col-md-8">
                    <input
                        id="initiator-autocomplete"
                        source-url="{{ action('IssueController@queryInitiator') }}/?name={name}"
                        type="text"
                        placeholder="Nume"
                        class="form-control"
                        prevent-enter="true"
                            />
                </div>
            </div>

            <div class="form-group">
                @include('admin.backend.issues.connected-initiator')
                <div class="panel panel-success col-md-8 col-md-offset-2">
                    <div class="panel-heading">Initiatori conectati</div>
                    <div class="list-group" id="connected-initiators-container">
                        @foreach ($issue->connectedInitiatorsStakeholders as $initiator_connected)
                            <div class="list-group-item" initiator-id="{{ $initiator_connected->id }}">
                                <a class="badge" connected-initiator-delete="{{ $initiator_connected->id }}">
                                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> sterge
                                </a>
                                <h4 class="list-group-item-heading">{{ $initiator_connected->name }}</h4>
                                <p class="list-group-item-text"></p>
                                <input type="hidden" name="initiators_connected[]" value="{{ $initiator_connected->id }}" />
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <hr/>

            <div class="form-group">
                <div class="col-md-2 text-right">
                    <label for="news-autocomplete" class="control-label">Stiri/declaratii</label>
                </div>
                <div class="col-md-8">
                    <input
                        id="news-autocomplete"
                        source-url="{{ action('IssueController@queryNews') }}/?name={name}"
                        type="text"
                        placeholder="Nume"
                        class="form-control"
                        prevent-enter="true"
                            />
                </div>
            </div>

            <div class="form-group">
                @include('admin.backend.issues.connected-news')
                <div class="panel panel-success col-md-8 col-md-offset-2">
                    <div class="panel-heading">Stiri/declaratii conectate</div>
                    <div class="list-group" id="connected-news-container">
                        @foreach ($issue->connectedNews as $news_connected)
                            <div class="list-group-item" news-id="{{ $news_connected->id }}">
                                <a class="badge" connected-news-delete="{{ $news_connected->id }}">
                                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> sterge
                                </a>
                                <h4 class="list-group-item-heading">{{ $news_connected->title }}</h4>
                                <p class="list-group-item-text"></p>
                                <input type="hidden" name="news_connected[]" value="{{ $news_connected->id }}" />
                            </div>
                        @endforeach
                    </div>
                </div>
            </div><br/>
            <div class="row">
                <div class="form-group">
                    <div class=" col-sm-4 col-sm-offset-2">
                        <a href="{{ action('NewsController@create') }}" target="_blank" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Adauga stire</a>
                    </div>
                </div>
            </div>

            <hr/>

            <div class="form-group">
                <div class="col-md-2 text-right">
                    <label for="issue-autocomplete" class="control-label">Initiative relevante</label>
                </div>
                <div class="col-md-8">
                    <input
                        id="issue-autocomplete"
                        source-url="{{ action('IssueController@queryIssue') }}/?name={name}"
                        type="text"
                        placeholder="Nume"
                        class="form-control"
                        prevent-enter="true"
                            />
                </div>
            </div>

            <div class="form-group">
                @include('admin.backend.issues.connected-issue')
                <div class="panel panel-success col-md-8 col-md-offset-2">
                    <div class="panel-heading">Initiative conectate</div>
                    <div class="list-group" id="connected-issues-container">
                        @foreach ($issue->issuesConnected as $issue_connected)
                            <div class="list-group-item" issue-id="{{ $issue_connected->id }}">
                                <a class="badge" connected-issue-delete="{{ $issue_connected->id }}">
                                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> sterge
                                </a>
                                <h4 class="list-group-item-heading">{{ $issue_connected->name }}</h4>
                                <p class="list-group-item-text"></p>
                                <input type="hidden" name="issues_connected[]" value="{{ $issue_connected->id }}" />
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <hr/>
    </div>

    <div class="tab-pane" id="flux">
        <div class="row">
            <label class="control-label col-sm-2">Importa template:</label>
            <div class="col-sm-6">
                <select class="form-control" name="" id="add-template" >
                    <option value=" ">Alege un template</option>
                    @foreach($flowTemplates as $template)
                        <option value="{{ $template->id }}">{{ $template->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="button"
                    class="btn btn-primary add_template"
                    style="margin-left: 40px;"
            >
                <span class="glyphicon glyphicon-plus"></span> Adauga template
            </button>
        </div><br /><br />
        <!-- flux starts here -->
        <div id="locations-container">
            @if(isset($locationSteps))
                @foreach($locationSteps as $locationStep)
                <div class="location panel panel-default" id="location-{{ $locationStep->id }}" location-id="{{ $locationStep->id }}">
                    <div class="form-group panel-heading" style="margin: 0px;">
                        <div class="row">
                            <label class="control-label col-sm-2">Locatie:</label>
                            <div class="col-sm-4">
                                @if($locationStep->location_id == 1)
                                    <input class="form-control"
                                           name="location[{{ $locationStep->id }}][name]"
                                           source-url="{{ action('IssueController@queryLocation') }}/?name={name}"
                                           location-name="true"
                                           value=" "
                                           save-id-to="location-id-location-{{ $locationStep->id }}"
                                           prevent-enter="true"
                                            />
                                @else
                                    <input class="form-control"
                                           name="location[{{ $locationStep->id }}][name]"
                                           source-url="{{ action('IssueController@queryLocation') }}/?name={name}"
                                           location-name="true"
                                           value="{{ $locationStep->location->name }}"
                                           save-id-to="location-id-location-{{ $locationStep->id }}"
                                           prevent-enter="true"
                                            />
                                @endif
                                <input type="hidden"
                                       name="location[{{ $locationStep->id }}][location_id]"
                                       value="{{ $locationStep->location_id }}"
                                       id="location-id-location-{{ $locationStep->id }}"
                                        />
                            </div>
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-danger delete_location" delete-id="location-{{ $locationStep->id }}"><span class="glyphicon glyphicon-trash"></span> Sterge locatie</button>
                        </div>
                        <div class="col-sm-1 col-sm-offset-3" style="cursor: pointer; cursor: hand;">
                            <span class="glyphicon glyphicon-move location-handle" style="padding: 10px; right: -40px;"></span>
                        </div>
                        </div><br/>
                        <div class="row">
                            <label class="control-label col-sm-2">Nr. Inregistrare:</label>
                            <div class="col-sm-4">
                                <input class="form-control"
                                       name="location[{{ $locationStep->id }}][nr_inregistrare]"
                                       value="{{ $locationStep->nr_inregistrare }}"
                                       prevent-enter="true"
                                        />
                            </div>
                        </div>
                    </div>
                    <br/>
                    <div id="flow-container-{{ $locationStep->id }}" class="panel panel-primary step-sort connectedSteps" style="min-height: 90px;" >
                        @foreach ($locationStep->flowsteps()->orderBy('flowstep_order', 'asc')->get() as $step)
                            <div class="location-step"
                                style="margin-top: 15px;"
                                id="location-{{ $locationStep->id }}flow_steps{{ $step->id }}"
                                step-id="{{ $step->id }}"
                                >
                                <div class="row">
                                    <div class="col-sm-1">
                                        <label></label>
                                    </div>
                                    <div class="col-sm-4">
                                        <label>Stadiu procedural</label>
                                    </div>
                                    <div class="col-sm-1">
                                        <label>Inceput la</label>
                                    </div>
                                    <div class="col-sm-1">
                                        <label>Durata</label>
                                    </div>
                                    <div class="col-sm-1">
                                        <label>Estimat finalizat</label>
                                    </div>
                                    <div class="col-sm-1">
                                    </div>
                                    <div class="col-sm-1">
                                        <label>Actiuni</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-1">
                                        <div class="accordion-toggle"
                                            data-toggle="collapse"
                                            data-target="#collapse{{ $step->id }}"
                                            style="margin-top: -10px;margin-left: 20px;padding: 20px 40px 20px 40px;">
                                            <span class="glyphicon glyphicon-menu-down"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <input class="form-control"
                                               id="autocomplete-{{ $step->id }}"
                                               name="location[{{ $locationStep->id }}][flow_steps][{{ $step->id }}][flow_name]"
                                               value="{{ $step->flow_name }}"
                                               source-url="{{ action('IssueController@queryStepAutocomplete') }}/?name={name}"
                                        />
                                    </div>
                                    <div class="col-sm-1">
                                        <input type="text"
                                               class="form-control"
                                               prevent-enter="true"
                                               id="startdate-widget-{{ $step->id }}"
                                               value="{{ $step->start_date->format('d-m-Y') }}"
                                               data-groupid="{{ $step->id }}"
                                               data-type="startdate"
                                        />
                                        <input type="hidden"
                                            id="startdate-result-{{ $step->id }}"
                                            name="location[{{ $locationStep->id }}][flow_steps][{{ $step->id }}][start_date]"
                                        />
                                    </div>
                                    <div class="col-sm-1">
                                        <input class="form-control" type="number" prevent-enter="true" name="location[{{ $locationStep->id }}][flow_steps][{{ $step->id }}][estimated_duration]" @if($step->estimated_duration == '0' || $step->estimated_duration == '') value="" @else value="{{ $step->estimated_duration }}" @endif min="0" data-duration="true" data-groupid="{{ $step->id }}" data-type="duration"/>
                                    </div>
                                    <div class="col-sm-1">
                                        <input type="text"
                                               class="form-control"
                                               prevent-enter="true"
                                               id="enddate-widget-{{ $step->id }}"
                                               @if (isset($step->end_date))
                                               value="{{ $step->end_date->format('d-m-Y') }}"
                                               @else
                                               value=""
                                               @endif
                                               data-groupid="{{ $step->id }}"
                                               data-type="enddate"
                                        />
                                        <input type="hidden"
                                            id="enddate-result-{{ $step->id }}"
                                            name="location[{{ $locationStep->id }}][flow_steps][{{ $step->id }}][end_date]"
                                        />
                                    </div>
                                    <div class="checkbox col-sm-1">
                                        <label>
                                            <input  type="checkbox"
                                                    value="1"
                                                    name="location[{{ $locationStep->id }}][flow_steps][{{ $step->id }}][finalizat]"
                                                    @if($step->finalizat == true)
                                                        checked="checked"
                                                    @endif
                                                    />Finalizat
                                        </label>
                                    </div>
                                    <div class="col-sm-1">
                                        <button type="button" class="btn btn-danger delete_step" delete-id="location-{{ $locationStep->id }}flow_steps{{ $step->id }}"><span class="glyphicon glyphicon-trash"></span></button>
                                    </div>
                                    <div class="col-sm-1" style="cursor: pointer; cursor: hand; padding: 0;">
                                        <span class="glyphicon glyphicon-move step-handle" style="padding: 10px; right: -40px;"></span>
                                    </div>
                                </div>
                                <div class="accordion-body collapse panel panel-primary"
                                     id="collapse{{ $step->id }}"
                                     style="margin-left: 3px; margin-right: 3px;"
                                        >
                                    <br/>
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#flow-documente{{ $step->id }}" data-toggle="tab">Documente</a></li>
                                        <li><a href="#flow-observatii{{ $step->id }}" data-toggle="tab">Observatii</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <br/>
                                        <div class="tab-pane active" id="flow-documente{{ $step->id }}">
                                            <br/>
                                            <div class="row">
                                                <div class="col-lg-10 col-lg-offset-1">
                                                    <input
                                                        id="document-autocomplete-{{ $step->id }}"
                                                        source-url="{{ action('IssueController@queryDocument') }}/?name={name}"
                                                        type="text"
                                                        placeholder="Cauta document"
                                                        class="form-control documente"
                                                        doc-step-id="{{ $step->id }}"
                                                        doc-location-id="{{ $locationStep->id }}"
                                                        prevent-enter="true"
                                                            />
                                                </div>
                                            </div>
                                            <br/>
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Titlu</th>
                                                        <th style="width: 35%;">Fisier</th>
                                                        <th style="width: 10%;">Data</th>
                                                        <th style="width: 10%;">Nr Inregistrare</th>
                                                        <th style="width: 5%;">Actiuni</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="autocomplete-document-{{ $step->id }}">
                                                    @foreach($step->documents()->get() as $document)
                                                        <tr id="document-{{ $document->id }}" >
                                                            <th>{{ $document->title }}</th>
                                                            <td>
                                                                @if($document->file)
                                                                    <a href="{{ action( "UploadedFileController@downloadFile" , [$document->file->file_name]) }}" target="_blank">
                                                                        <i class="fa fa-file-pdf-o"></i>
                                                                        {{ $document->file->original_file_name }}
                                                                    </a>
                                                                @endif
                                                            </td>
                                                            <td>{{ $document->init_at->format('d-m-Y') }}</td>
                                                            <td></td>
                                                            <td>
                                                                <a href="{{ action('DocumentController@edit', [$document]) }}" target="_blank" title="Edit">
                                                                    <span class="glyphicon glyphicon-pencil" style="margin-right: 15px;"></span>
                                                                </a>
                                                                <a class="badge delete_document" connected-document-delete="document-{{ $document->id }}">
                                                                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                                                </a>
                                                            </td>
                                                            <input type="hidden"
                                                            name="location[{{ $locationStep->id }}][flow_steps][{{ $step->id }}][document_id][]"
                                                            value="{{ $document->id }}" />
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table><br/><br/>

                                            <a href="{{ action('DocumentController@create') }}" class="btn btn-primary" target="_blank" style="margin-left: 10px;">
                                                <span class="glyphicon glyphicon-plus"></span> Adauga Document
                                            </a>
                                        </div>
                                        <div class="tab-pane" id="flow-observatii{{ $step->id }}">
                                            <br/>
                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-md-4 col-md-offset-1">Ro</label>
                                                    <label class="col-md-4 col-md-offset-1">En</label>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 col-md-offset-1">
                                                        <textarea name="location[{{ $locationStep->id }}][flow_steps][{{ $step->id }}][observatii][ro]" class="form-control" style="resize: none;" rows="6" cols="20">{{ $step->translateOrNew('ro')->observatii }}</textarea>
                                                    </div>
                                                    <div class="col-md-4 col-md-offset-1">
                                                        <textarea name="location[{{ $locationStep->id }}][flow_steps][{{ $step->id }}][observatii][en]" class="form-control" style="resize: none;" rows="6" cols="20">{{ $step->translateOrNew('en')->observatii }}</textarea>
                                                    </div>
                                                </div>
                                            </div><br/>
                                            <div class="form-group">
                                                <div class="checkbox col-md-3 col-md-offset-1">
                                                    <label>
                                                        <input  type="checkbox"
                                                                value="1"
                                                                name="location[{{ $locationStep->id }}][flow_steps][{{ $step->id }}][published]"
                                                                @if(! $step->alerts()->notSent()->get()->isEmpty())
                                                                    checked="checked"
                                                                @endif
                                                                />Publica
                                                    </label>
                                                </div>
                                                 
                                                <div class="checkbox col-md-3 col-md-offset-2">
                                                    <label>
                                                        <input  type="checkbox"
                                                                value="1"
                                                                name="location[{{ $locationStep->id }}][flow_steps][{{ $step->id }}][addToLegalNews]"
                                                        />Adauga la noutati legislative
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <br />
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <br/>
                        <button type="button" location-id="{{ $locationStep->id }}" class="btn btn-primary add_flowstep"><span class="glyphicon glyphicon-plus"></span> Adauga pas</button>
                    <br/><br/>
                </div>
                @endforeach
            @endif
            @include('admin.backend.issues.location-template')
            @include('admin.backend.issues.flowstep-template')
            @include('admin.backend.issues.connected-documents')
        </div>
        <br/><br/>

        <div class="form-group">
            <label class="col-md-2 control-label">Faza</label>
            <div class="col-md-8">
                <select class="form-control" name="phase">
                    <option value="viitor">Inițiativă viitoare</option>
                    <option value="curent" @if($issue->phase === 'curent') selected="selected" @endif>Inițiativă curentă</option>
                    <option value="arhivatRespinsSauAbrogat" @if($issue->phase === 'arhivatRespinsSauAbrogat') selected="selected" @endif>Arhivată – Respinsă sau abrogată </option>
                    <option value="arhivatInactiv" @if($issue->phase === 'arhivatInactiv') selected="selected" @endif>Arhivată – Inactivă</option>
                    <option value="publicatMO" @if($issue->phase === 'publicatMO') selected="selected" @endif>Publicat in Monitorul Oficial</option>
                </select>
            </div>
        </div>

        <button type="button"
                class="btn btn-primary add_location"
                style="margin-top: 40px;"
        >
            <span class="glyphicon glyphicon-plus"></span> Adauga locatie
        </button>

    </div>

</div>
