<div class="row">
    <div class="col-md-4">
        @if($stakeholder->photo_source)
            <div class="text-right">
                <small>
                    Sursa: {{ $stakeholder->photo_source }}
                </small>
            </div>
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
                {!! $stakeholder->position !!}
            </div><br>
        @endif
        @if($stakeholder->site)
            <div class="text-center">
                    <a href="{{ $stakeholder->site }}" target="_blank" rel="nofollow" class="btn btn-circle green-haze">Blog</a>
            </div>
        @endif
        @if ($stakeholder->email or $stakeholder->telephone or $stakeholder->address or $stakeholder->other_details)
            <hr>
            <div>
                <h4 class="text-center">
                    Date de contact
                </h4><br>
                <p>
                    @if($stakeholder->email)
                        <b>Email:</b> {{ $stakeholder->email }}<br><br>
                    @endif
                    @if($stakeholder->telephone)
                        <b>Telefon:</b> {{ $stakeholder->telephone }}<br><br>
                    @endif
                    @if($stakeholder->address)
                        <b>Adresa:</b> {{ $stakeholder->address }}<br><br>
                    @endif
                    @if($stakeholder->other_details)
                        <b>Alte detalii:</b> {{ $stakeholder->other_details }}<br>
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
        @if(! $stakeholder->connectedIssues()->get()->isEmpty())
            <div>
                <h3>Inițiative pentru care este relevant</h3>
            </div>
            <hr>
            @foreach($stakeholder->connectedIssues()->limit(5)->get() as $stakeholderIssue)
                    <ul>
                        <li>
                            <a href="{{ action('HomeController@getIssueInfo', ['id' => $stakeholderIssue->id, 'name' => Illuminate\Support\Str::slug($stakeholderIssue->name)]) }}">{{ $stakeholderIssue->name }}</a>
                        </li>
                </ul>
            @endforeach
            <br>
            @if($stakeholder->connectedIssues()->count() > 5)
                <a href="{{ action('HomeController@getAllStakeholderIssues', ['id' => $stakeholder, 'name' => Illuminate\Support\Str::slug($stakeholder->name)]) }}" target="_blank">
                    Vezi toate
                </a>
            @endif
            <hr>
            <br><br>
        @endif

        @if(! $stakeholder->connectedNews()->get()->isEmpty())
            <div>
                <h3>Știri / declarații în care este menționat</h3>
            </div>
            <hr>
            @foreach($stakeholder->connectedNews()->orderBy('id', 'desc')->limit(5)->get() as $stakeholderNews)
                <ul>
                    <li>
                        <a href="{{ action('HomeController@getNewsInfo', ['id' => $stakeholderNews->id, 'name' => Illuminate\Support\Str::slug($stakeholderNews->title)]) }}" target="_blank">
                            {{ $stakeholderNews->title }}
                        </a>
                    </li>
                </ul>
            @endforeach
            <br>
            @if($stakeholder->connectedNews()->count() > 5)
                <a href="{{ action('HomeController@getAllStakeholderNews', ['id' => $stakeholder, 'name' => Illuminate\Support\Str::slug($stakeholder->name)]) }}">Vezi toate</a>
            @endif
            <hr>
            <br><br>
        @endif
    </div>
</div>
