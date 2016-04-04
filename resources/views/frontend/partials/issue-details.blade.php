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
        <p>
            <b>Tip:</b> {{ $issue->type }}
        </p>
        <p>
            <b>
                Initiatori:
            </b>
        </p>
            @foreach ($issue->connectedInitiatorsStakeholders as $initiator)
                <ul>
                    <li>
                        <a href="#" target="_blank">
                        {{ $initiator->name }}
                        </a>
                    </li>
                </ul>
            @endforeach
        <p>
            <b>
                Descriere scurta:
            </b>
        </p>
            {{ $issue->description }}
    </div>

    <div class="tab-pane" id="flux">
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
                <tr>
                    @foreach ($issue->locationsteps as $locationStep)
                        @foreach ($locationStep->flowsteps as $step)
                            @foreach ($step->documents as $document)
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
                            @endforeach
                        @endforeach
                    @endforeach
                </tr>
            </tbody>
        </table>
    </div>

    <div class="tab-pane" id="news">
        @foreach ($issue->connectedNews as $n)
            <p>
                <b>{{ $n->title }}</b>
            </p>
            <br>
            <p>
                <b>Data: </b>{{ $n->date->format('d-m-Y') }}
            </p>
            <p>
                <b>Extras :</b> {!! strip_tags($n->description) !!}
            </p>
            <p>
                <b>Stakeholderi: </b>
                @foreach ($n->connectedStakeholders as $stakeholder)
                <ul>
                    <li>
                        <a href="#" target="_blank">
                            {{ $stakeholder->name }}
                        </a>
                    </li>
                </ul>
                @endforeach
            </p>
            <br>

            <a href="{{ $n->link }}" target="_blank">
                Stire completa
            </a>
            <br><hr>
        @endforeach 
    </div>

    <div class="tab-pane" id="stakeholders">
    </div>

    <div class="tab-pane" id="notifications">
    </div>

</div>
