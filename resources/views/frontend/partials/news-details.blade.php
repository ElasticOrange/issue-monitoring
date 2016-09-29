<h3>
    {{ $news->translate(App::getLocale())->title }}
</h3>
<br>
@if($news->date)
    <p>
        <b>Data: </b>{{ $news->date->format('d-m-Y') }}
    </p>
@endif
@if($news->description)
    <p>
        <b>Extras :</b> {!! $news->translate(App::getLocale())->description ? strip_tags($news->translate(App::getLocale())->description) : 'Work in progress' !!}
    </p>
@endif
@if($news->fileDocument)
    <p>
        <b>Download: </b>
        <a href="{{ action( "UploadedFileController@downloadFile" , [$news->fileDocument->file_name]) }}" title="{{ $news->fileDocument->original_file_name }}">
            <i class="fa fa-file-pdf-o"></i>
        </a>
    </p>
@endif
@if($news->connectedStakeholders)
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
@endif
<br>

@if($news->link)
    <a href="{{ $news->link }}" target="_blank">
        Stire completa
    </a>
@endif
<br>
