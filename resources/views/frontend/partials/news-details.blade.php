<h3>
    {{ $news->title }}
</h3>
<br>
<p>
    <b>Data: </b>{{ $news->date->format('d-m-Y') }}
</p>
<p>
    <b>Extras :</b> {!! strip_tags($news->description) !!}
</p>
<p>
    <b>Stakeholderi: </b>
    @foreach ($news->connectedStakeholders as $stakeholder)
    <ul>
        <li>
            <a href="{{ action('HomeController@getStakeholderInfo', ['id' => $stakeholder->id, 'name' => Illuminate\Support\Str::slug($stakeholder->name)]) }}">
                {{ $stakeholder->name }}
            </a>
        </li>
    </ul>
    @endforeach
</p>
<br>

<a href="{{ $news->link }}" target="_blank">
    Stire completa
</a>
<br>