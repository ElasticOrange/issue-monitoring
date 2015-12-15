<input type="hidden" name="_token" value="{{ csrf_token() }}">


<div class="form-group">
	<label class="control-label col-sm-2">Nume Template:</label>
	<div class="col-sm-6">
        <input class="form-control" template-name="true" name="name" value="{{ $flowTemplate->name }}" />
    </div>
</div><br /><br />

<!-- flux starts here -->
<div id="locations-container">
    @if(isset($locationSteps))
        @foreach($locationSteps as $locationStep)
        <div class="location panel panel-default" id="location-{{ $locationStep->id }}">
            <div class="form-group panel-heading" style="margin: 0px;">
                <div class="row">
                    <label class="control-label col-sm-2">Locatie:</label>
                    <div class="col-sm-4">
                        <input class="form-control"
                               name="location[{{ $locationStep->id }}][name]"
                               source-url="{{ action('IssueController@queryLocation') }}/?name={name}"
                               location-name="true"
                               value="{{ $locationStep->location->name }}"
                               save-id-to="location-id-location-{{ $locationStep->id }}"
                               prevent-enter="true"
                                />
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
                                <label>Durata</label>
                            </div>
                            <div class="col-sm-2">
                                <label>Inceput la</label>
                            </div>
                            <div class="col-sm-2">
                                <label>Finalizat la</label>
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
                                <input class="form-control" type="number" prevent-enter="true" name="location[{{ $locationStep->id }}][flow_steps][{{ $step->id }}][estimated_duration]" value="{{ $step->estimated_duration }}"/>
                            </div>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" prevent-enter="true" id="startdate-widget-{{ $step->id }}" value="{{ $step->start_date->format('d-m-Y') }}"/>
                                <input type="hidden"
                                    id="startdate-result-{{ $step->id }}"
                                    name="location[{{ $locationStep->id }}][flow_steps][{{ $step->id }}][start_date]"
                                />
                            </div>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" prevent-enter="true" id="enddate-widget-{{ $step->id }}" value="{{ $step->end_date->format('d-m-Y') }}"/>
                                <input type="hidden"
                                    id="enddate-result-{{ $step->id }}"
                                    name="location[{{ $locationStep->id }}][flow_steps][{{ $step->id }}][end_date]"
                                />
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
    @include('admin.backend.flow-template.location-template')
    @include('admin.backend.flow-template.flowstep-template')
    @include('admin.backend.flow-template.connected-documents')
</div>
<button type="button"
        class="btn btn-primary add_location"
        style="margin-top: 40px;"
>
    <span class="glyphicon glyphicon-plus"></span> Adauga locatie
</button>