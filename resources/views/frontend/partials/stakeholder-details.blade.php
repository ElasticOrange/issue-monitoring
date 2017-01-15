<div class="row">
    <div class="col-md-4">
        @if($stakeholder->filePoza)
            <div class="text-center">
                <img src="{{ action( "UploadedFileController@downloadFile" , [$stakeholder->filePoza->file_name]) }}" width=200 alt="" />
            </div>
        @endif
        @if($stakeholder->photo_source)
            <div class="text-right">
                <small>
                    {{ trans('stakeholders.source') }}: {{ $stakeholder->photo_source }}
                </small>
            </div><br>
        @endif
        @if($stakeholder->name)
            <div class="profile-usertitle-name text-center">
                {{ $stakeholder->name }}
            </div>
        @endif
        @if($stakeholder->org_name)
            <div class="profile-usertitle-name text-center">
                {{ $stakeholder->org_name }}
            </div>
        @endif
        @if($stakeholder->position)
            <div class="profile-usertitle-job text-center">
                {{ strip_tags($stakeholder->position) }}
            </div><br>
        @endif
        @if($stakeholder->site || $stakeholder->fileCv)
            <div class="text-center">
                @if($stakeholder->site)
                    <a href="{{ $stakeholder->site }}" target="_blank" rel="nofollow" class="btn btn-circle green-haze">Blog</a>
                @endif
                @if($stakeholder->fileCv)
                    <a href="{{ action( "UploadedFileController@downloadFile" , [$stakeholder->fileCv->file_name]) }}" target="_blank" rel="nofollow" class="btn btn-circle green-haze">Curriculum Vitae</a>
                @endif
            </div>
        @endif
        @if ($stakeholder->email or $stakeholder->telephone or $stakeholder->address or $stakeholder->other_details)
            <hr>
            <div>
                <h4 class="text-center">
                    {{ trans('stakeholders.contact_information') }}
                </h4><br>
                <p>
                    @if($stakeholder->email)
                        <b>Email:</b> {{ $stakeholder->email }}<br><br>
                    @endif
                    @if($stakeholder->telephone)
                        <b>{{ trans('stakeholders.tel') }}:</b> {{ $stakeholder->telephone }}<br><br>
                    @endif
                    @if($stakeholder->address)
                        <b>{{ trans('stakeholders.address') }}:</b> {!! $stakeholder->address !!}<br><br>
                    @endif
                    @if($stakeholder->other_details)
                        <b>Alte detalii:</b> {{ strip_tags($stakeholder->other_details) }}<br>
                    @endif
                </p>
            </div>
       @endif
    </div>
    <div class="col-md-8">
        @if($stakeholder->profile)
            <div class="row">
                <div class="col-md-12">
                    <p>
                        {!! $stakeholder->profile !!}
                    </p>
                </div>
            </div><br>
        @endif
        @if($stakeholder->sections)
            <div class="row">
                <div class="col-md-12">
                    @foreach($stakeholder->sections as $section)
                    <div>
                        <h4>
                            @if($section->title)
                                {{ $section->title }}
                            @endif
                        </h4>
                    </div>
                    <p>
                        @if($section->description)
                            {{ $section->description }}
                        @endif
                    </p>
                    @endforeach
                </div>
            </div><br>
        @endif
        @if(! $stakeholder->connectedIssues()->get()->isEmpty())
            <div>
                <h3>{{ trans('stakeholders.issue_relevant') }}</h3>
            </div>
            <hr>
            @foreach($stakeholder->connectedIssues()->orderBy('id', 'desc')->limit(5)->get() as $stakeholderIssue)
                    <ul>
                        <li>
                            <a href="{{ action('HomeController@getIssueInfo', ['id' => $stakeholderIssue->id, 'name' => Illuminate\Support\Str::slug($stakeholderIssue->name)]) }}">{{ $stakeholderIssue->name }}</a>
                        </li>
                </ul>
            @endforeach
            <br>
            @if($stakeholder->connectedIssues()->count() > 5)
                <a href="{{ action('HomeController@getAllStakeholderIssues', ['id' => $stakeholder, 'name' => Illuminate\Support\Str::slug($stakeholder->name)]) }}">
                    {{ trans('stakeholders.show_all') }}
                </a>
            @endif
            <hr>
            <br><br>
        @endif

        @if(! $stakeholder->connectedNews()->get()->isEmpty())
            <div>
                <h3>{{ trans('stakeholders.news_mentions') }}</h3>
            </div>
            <hr>
            @foreach($stakeholder->connectedNews()->orderBy('id', 'desc')->limit(5)->get() as $stakeholderNews)
                <ul>
                    <li>
                        <a href="{{ action('HomeController@getNewsInfo', ['id' => $stakeholderNews->id, 'name' => Illuminate\Support\Str::slug($stakeholderNews->title)]) }}">
                            {{ $stakeholderNews->title }}
                        </a>
                    </li>
                </ul>
            @endforeach
            <br>
            @if($stakeholder->connectedNews()->count() > 5)
                <a href="{{ action('HomeController@getAllStakeholderNews', ['id' => $stakeholder, 'name' => Illuminate\Support\Str::slug($stakeholder->name)]) }}">{{ trans('stakeholders.show_all') }}</a>
            @endif
            <hr>
            <br><br>
        @endif
        @if(! $stakeholder->stakeholdersConnectedOfMine()->get()->isEmpty())
            <div>
                <h3>{{ trans('stakeholders.connected_stakeholders') }}</h3>
            </div>
            <hr>
            @foreach($stakeholder->stakeholdersConnectedOfMine()->orderBy('id', 'desc')->limit(5)->get() as $s)
                <ul>
                    <li>
                        @if($s->name)
                            <a href="{{ action('HomeController@getStakeholderInfo', ['id' => $s->id, 'name' => Illuminate\Support\Str::slug($s->name)]) }}">
                                {{ $s->name }}
                            </a>
                        @endif
                        @if($s->org_name)
                            <a href="{{ action('HomeController@getStakeholderInfo', ['id' => $s->id, 'name' => Illuminate\Support\Str::slug($s->org_name)]) }}">
                                {{ $s->org_name }}
                            </a>
                        @endif
                    </li>
                </ul>
            @endforeach
            <br>
            @if($stakeholder->stakeholdersConnectedOfMine()->count() > 5)
                <a href="{{ action('HomeController@getAllStakeholdersConnected', ['id' => $stakeholder, 'name' => Illuminate\Support\Str::slug($stakeholder->name)]) }}">{{ trans('stakeholders.show_all') }}</a>
            @endif
            <hr>
            <br><br>
        @endif
    </div>
</div>
