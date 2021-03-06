<ul class="nav nav-tabs">
    <li class="active"><a href="#summary" data-toggle="tab">Sumar</a></li>
    <li><a href="#flux" data-toggle="tab">Flux procedural</a></li>
    <li><a href="#documents" data-toggle="tab">Documente</a></li>
    <li><a href="#news" data-toggle="tab">Stiri si declaratii</a></li>
    <li><a href="#stakeholders" data-toggle="tab">Stakeholders</a></li>
    <li><a href="#notifications" data-toggle="tab">Notificari</a></li>
</ul>

<div class="tab-content">
    <br/>
    <div class="tab-pane active" id="summary">
        @if($issue->type)
            <p>
                <b>Tip:</b> {{ $issue->type }}
            </p>
        @endif
        @if(count($initiatorsList) > 1)
        <p>
            <b>
                Initiatori:
            </b>
        </p>
        @foreach ($initiatorsList[0] as $initiator)
            <ul>
                <li>
                    <a href="{{ action('HomeController@getStakeholderInfo', ['id' => $initiator->id, 'name' => Illuminate\Support\Str::slug($initiator->name)]) }}">
                    {{ $initiator->name }}
                    </a>
                </li>
            </ul>
        @endforeach
            <div class="collapse" id="stakeholdersList">
                @for ($i = 1; $i < count($initiatorsList); $i++)
                    @foreach ($initiatorsList[$i] as $initiator)
                        <ul>
                            <li>
                                <a href="{{ action('HomeController@getStakeholderInfo', ['id' => $initiator->id, 'name' => Illuminate\Support\Str::slug($initiator->name)]) }}">
                                {{ $initiator->name }}
                                </a>
                            </li>
                        </ul>
                    @endforeach
                @endfor
            </div>
            <a role="button" data-toggle="collapse" href="#stakeholdersList" aria-expanded="false" aria-controls="stakeholdersList">
                Arata toti stakeholderii
            </a>
        @endif
        @if ($issue->impact)
            <p>
                <b>
                    <br>
                    Impact asupra altor legi:
                </b>
            </p>
                {!! $issue->impact !!}
        @endif
        @if ($issue->description)
        <p>
            <b>
                <br>
                Descriere scurta:
            </b>
        </p>
            {!! $issue->description !!}
        @endif
        @if ($issue->status)
        <p>
            <b>
                <br>
                Status:
            </b>
        </p>
            {!! $issue->status !!}
        @endif
    </div>

    <div class="tab-pane" id="flux">
        <div class="tab-pane row fade active in" id="tab-flux">
            <div id="legenda" class="pull-right">
                <span class="s-f"><g></g> Stadiu finalizat</span>
                <span class="s-i"><g></g> Stadiu în curs</span>
                <span class="s-n"><g></g> Stadiu neînceput</span>
                <span class="s-e" style="margin-right: 25px;"><g></g> Termen depășit</span>
            </div>
        </div>
            @if($issue->locationsteps)
                @foreach($issue->locationsteps()->orderBy('step_order', 'asc')->get() as $locationStep)
                <br>
                <br>
                <a role="button" data-toggle="collapse" href="#collapse-{{ $locationStep->id }}" aria-expanded="false" aria-controls="collapse-{{ $locationStep->id }}">
                    <p class="flux_closed_location">
                        @if (! $locationStep->flowsteps->contains('finalizat', 0))
                        <div class="glyph-background col-xs-1" style="margin-top: -4px;">
                            <i class="indicator glyphicon glyphicon-plus"></i>
                        </div>
                        @endif
                        {{ $locations->where('id', $locationStep->location_id)->lists('name')->toArray()[0] }}
                        &nbsp;&nbsp;{{ $locationStep->nr_inregistrare }}
                    </p>
                </a>
                    <div class="col-md-12 collapse issues-list panel-group" id="collapse-{{ $locationStep->id }}" style="text-align:center">
                        <div class="clearfix steps-header">
                            <div class="col-md-4 col-xs-4 step" style="text-align:left">Stadiu procedural</div>
                            <div class="col-md-2 col-xs-2 step">Status</div>
                            <div class="col-md-2 col-xs-2 step">Data de început</div>
                            <div class="col-md-2 col-xs-2 step">Data de sfârșit<sup>1</sup></div>
                            <div class="col-md-2 col-xs-2 step">Mai mult...</div>
                        </div>
                        <div>
                    @if($locationStep->flowsteps)
                        @foreach($locationStep->flowsteps as $step)
                            @if(! $step->start_date and ! $step->end_date and !$step->finalizat)
                                <div class="clearfix individual-step">
                            @elseif($step->start_date and !$step->end_date and !$step->finalizat)
                                <div class="clearfix individual-step in-curs">
                            @elseif($step->finalizat == 1)
                                <div class="clearfix individual-step finalizat">
                            @elseif($step->end_date and !$step->finalizat and $dateNow > $step->end_date)
                                <div class="clearfix individual-step depasit">
                            @endif
                                <div class="col-md-4 col-xs-4 step" style="text-align:left">
                                    {{ $step->flow_name }}
                                </div>
                                <div class="col-md-2 col-xs-2 step">
                                @if($step->finalizat == 0)
                                    <i class="fa fa-square-o"></i>
                                @else
                                    <i class="fa fa-check-square-o"></i>
                                @endif
                                </div>
                                <div class="col-md-2 col-xs-2 step">
                                @if($step->start_date)
                                    {{ $step->start_date->format('d-m-Y') }}
                                @else - @endif
                                </div>
                                <div class="col-md-2 col-xs-2 step">
                                @if($step->end_date)
                                    {{ $step->end_date->format('d-m-Y') }}
                                @else - @endif
                                </div>
                                @if ($step->observatii != '' or ! empty($step->documents))
                                    <div class="col-md-2 col-xs-2 step">
                                        <i class="fa fa-plus accordion-toggle collapsed"
                                            data-toggle="collapse"
                                            data-parent="#collapse-{{ $locationStep->id }}"
                                            href="#step_{{ $step->id }}"
                                            aria-expanded="false">
                                        </i>
                                    </div>
                                    <div id="step_{{ $step->id }}"
                                        class="col-md-12 col-xs-12 panel-collapse collapse"
                                        aria-expanded="false"
                                        style="height: 0px;"
                                    >
                                            {!! $step->observatii !!}
                                        @if(! $step->documents->isEmpty())
                                            <br>
                                            <table class="table table-bordered table-striped" style="background-color: #fff;">
                                                <thead>
                                                <tr>
                                                    <th>Descriere scurtă</th>
                                                    <th>Fișiere</th>
                                                    <th>Data</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($step->documents as $document)
                                                    <tr>
                                                        <td>
                                                            {{ $document->title }}
                                                        </td>
                                                        <td style="text-align: center; vertical-align: middle;">
                                                            @if($document->file)
                                                                <a href="{{ action( "UploadedFileController@downloadFile" , [$document->file->file_name]) }}" title="{{ $document->file->original_file_name }}">
                                                                    <i class="fa fa-file-pdf-o"></i>
                                                                </a>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            {{ $document->init_at->format('d-m-Y') }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            @endforeach
        @endif
    </div>

    <div class="tab-pane" id="documents">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Descriere scurtă</th>
                    <th>Fișiere</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($issue->locationsteps as $locationStep)
                    @foreach ($locationStep->flowsteps as $step)
                        @foreach ($step->documents as $document)
                            <tr>
                                <td>
                                    {{ $document->title }}
                                </td>
                                <td style="text-align: center; vertical-align: middle;">
                                    @if($document->file)
                                        <a href="{{ action( "UploadedFileController@downloadFile" , [$document->file->file_name]) }}" title="{{ $document->file->original_file_name }}">
                                            <i class="fa fa-file-pdf-o"></i>
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    {{ $document->init_at->format('d-m-Y') }}
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="tab-pane" id="news">
        <br>
        @if(! $newsList->isEmpty())
        @foreach ($newsList as $news)
            <ul>
                <li>
                    {{ $news->date->format('d-m-Y') }}
                    <a href="{{ $news->link }}">
                        <b>{{ $news->title }}</b>
                    </a><br>
                    <span class="news-ellipsis">
                        {{ strip_tags($news->description) }}
                    </span>
                    <a href="{{ action('HomeController@getNewsInfo', ['id' => $news->id, 'name' => Illuminate\Support\Str::slug($news->title)])  }}">
                        Detalii
                    </a>
                </li><br>
            </ul>
        @endforeach
        @endif
        {!! $newsList->fragment('news')->render() !!}
    </div>

    <div class="tab-pane" id="stakeholders">
        <h4 class="row col-md-11 col-md-offset-1">Stakeholderi</h4>
        <div class="row col-md-11 col-md-offset-2">
            @if($issue->connectedStakeholders->contains('type', 'organizatie'))
            <p>
                <b>Organizaţii</b>
            </p>
            @endif
            @foreach ($issue->connectedStakeholders as $stakeholder)
            @if($stakeholder->type == 'organizatie')
            <ul>
                <li>
                    <a href="{{ action('HomeController@getStakeholderInfo', ['id' => $stakeholder->id, 'name' => Illuminate\Support\Str::slug($stakeholder->name)]) }}">
                        {{ $stakeholder->name }}
                    </a>
                </li>
            </ul>
            @endif
            @endforeach
            @if($issue->connectedStakeholders->contains('type', 'persoana'))
            <p>
                <b>Persoane</b>
            </p>
            @endif
            @foreach ($issue->connectedStakeholders as $stakeholder)
            @if($stakeholder->type == 'persoana')
            <ul>
                <li>
                    <a href="{{ action('HomeController@getStakeholderInfo', ['id' => $stakeholder->id, 'name' => Illuminate\Support\Str::slug($stakeholder->name)]) }}">
                        {{ $stakeholder->name }}
                    </a>
                </li>
            </ul>
            @endif
            @endforeach
            <br>
        </div>
        <!--  -->
        <h4 class="row col-md-11 col-md-offset-1">Iniţiatori</h4>
        <div class="row col-md-11 col-md-offset-2">
            @if($issue->connectedInitiatorsStakeholders->contains('type', 'organizatie'))
            <p>
                <b>Organizaţii</b>
            </p>
            @endif
            @foreach ($issue->connectedInitiatorsStakeholders as $initiator)
            @if($initiator->type == 'organizatie')
            <ul>
                <li>
                    <a href="{{ action('HomeController@getStakeholderInfo', ['id' => $initiator->id, 'name' => Illuminate\Support\Str::slug($initiator->name)]) }}">
                        {{ $initiator->name }}
                    </a>
                </li>
            </ul>
            @endif
            @endforeach
            @if($issue->connectedInitiatorsStakeholders->contains('type', 'persoana'))
            <p>
                <b>Persoane</b>
            </p>
            @endif
            @foreach ($issue->connectedInitiatorsStakeholders as $initiator)
            @if($initiator->type == 'persoana')
            <ul>
                <li>
                    <a href="{{ action('HomeController@getStakeholderInfo', ['id' => $initiator->id, 'name' => Illuminate\Support\Str::slug($initiator->name)]) }}">
                        {{ $initiator->name }}
                    </a>
                </li>
            </ul>
            @endif
            @endforeach
        </div>
    </div>

    <div class="tab-pane" id="notifications">
        <div class="tab-pane fade active in" id="tab-notificari">
            <div class="unsubscribe-alert hidden">
                <div class="alert">
                    <span class="caption"></span>
                </div>
            </div>
            <form action="{{ action('UserController@refuseIssueNotification') }}"
                  id="refuse-alerts"
                  method="GET"
            >
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="issue_id" value="{{ $issue->id }}">
                <input type="hidden" name="user_id" value="{{ \Auth::check() ? \Auth::user()->id : '' }}">
                <label>Vreau să-mi transmiteți notificări pentru aceasta inițiativă</label>
                <select name="notify" id="notify">
                    <option value="dont"
                        @if(\Auth::check() && \Auth::user()->issues()->where('issue_id', $issue->id)->first())
                            selected="selected"
                        @endif
                            >NU
                    </option>
                    <option value="zilnic"
                        @if(\Auth::check() && ! \Auth::user()->issues()->where('issue_id', $issue->id)->first())
                            selected="selected"
                        @endif
                            >ZILNIC
                        </option>
                </select>
                <input type="submit" class="btn btn-default btn-sm" value="Salvează">
            </form>
        </div>
    </div>
</div>
