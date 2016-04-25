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
        <p>
            <b>
                Initiatori:
            </b>
        </p>
        @foreach ($initiatorsList[0] as $initiator)
            <ul>
                <li>
                    <a href="{{ action('HomeController@getStakeholderInfo', ['id' => $initiator->id, 'name' => Illuminate\Support\Str::slug($initiator->name)]) }}" target="_blank">
                    {{ $initiator->name }}
                    </a>
                </li>
            </ul>
        @endforeach
        @if(count($initiatorsList) > 1)
            <a role="button" data-toggle="collapse" href="#stakeholdersList" aria-expanded="false" aria-controls="stakeholdersList">
                Arata toti stakeholderii
            </a>
            <div class="collapse" id="stakeholdersList">
                @for ($i = 1; $i < count($initiatorsList); $i++)
                    @foreach ($initiatorsList[$i] as $initiator)
                        <ul>
                            <li>
                                <a href="{{ action('HomeController@getStakeholderInfo', ['id' => $initiator->id, 'name' => Illuminate\Support\Str::slug($initiator->name)]) }}" target="_blank">
                                {{ $initiator->name }}
                                </a>
                            </li>
                        </ul>
                    @endforeach
                @endfor
            </div>
        @endif
        <p>
            <b>
                <br>
                Descriere scurta:
            </b>
        </p>
            {!! strip_tags($issue->description) !!}
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
                @foreach($issue->locationsteps as $locationStep)
                <br>
                <br>
                <a role="button" data-toggle="collapse" href="#collapse-{{ $locationStep->id }}" aria-expanded="false" aria-controls="collapse-{{ $locationStep->id }}">
                    <p>
                        {{ $locations->where('id', $locationStep->location_id)->lists('name')->toArray()[0] }}
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
                            @if($step->finalizat == 1)
                                <div class="clearfix individual-step finalizat">
                            @elseif($step->start_date and $step->finalizat == 0)
                                <div class="clearfix individual-step in-curs">
                            @elseif(! $step->start_date)
                                <div class="clearfix individual-step">
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
                                        <div class="panel-body">
                                            {!! strip_tags($step->observatii) !!}
                                        </div>
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
                                                                <a href="{{ action( "UploadedFileController@downloadFile" , [$document->file->file_name]) }}" target="_blank" title="{{ $document->file->original_file_name }}">
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
                                        <a href="{{ action( "UploadedFileController@downloadFile" , [$document->file->file_name]) }}" target="_blank" title="{{ $document->file->original_file_name }}">
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
                    <a href="{{ $news->link }}" target="_blank">
                        <b>{{ $news->title }}</b>
                    </a><br>
                    <span class="news-ellipsis">
                        {{ strip_tags($news->description) }}
                    </span>
                    <a href="{{ action('HomeController@getNewsInfo', ['id' => $news->id, 'name' => Illuminate\Support\Str::slug($news->title)])  }}" target="_blank">
                        Detalii
                    </a>
                </li><br>
            </ul>
        @endforeach
        @endif
        {!! $newsList->fragment('news')->render() !!}
    </div>

    <div class="tab-pane" id="stakeholders">
        @if($issue->connectedStakeholders->contains('type', 'organizatie'))
            <p>
                <b>Organizatii</b>
            </p>
        @endif
        @foreach ($issue->connectedStakeholders as $stakeholder)
            @if($stakeholder->type == 'organizatie')
            <ul>
                <li>
                    <a href="{{ action('HomeController@getStakeholderInfo', ['id' => $stakeholder->id, 'name' => Illuminate\Support\Str::slug($stakeholder->name)]) }}" target="_blank">
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
                    <a href="{{ action('HomeController@getStakeholderInfo', ['id' => $stakeholder->id, 'name' => Illuminate\Support\Str::slug($stakeholder->name)]) }}" target="_blank">
                        {{ $stakeholder->name }}
                    </a>
                </li>
            </ul>
            @endif
        @endforeach
    </div>

    <div class="tab-pane" id="notifications">
        <div class="tab-pane fade active in" id="tab-notificari">
            <form action="" method="POST">
                <label>Vreau să-mi transmiteți notificări pentru aceasta inițiativă</label>
                <select name="notify" id="notify">
                    <option value="N" selected="">NU</option>
                    <option value="Z">ZILNIC</option>
                    <option value="S">SĂPTĂMÂNAL</option>
                </select>
                <input type="submit" value="Salvează">
            </form>
            <p>
                Este in lucru.
            </p>
        </div>
    </div>
</div>
