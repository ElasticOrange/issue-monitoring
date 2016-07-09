<h3>
    {{ $report->title }}
</h3>
<br>
<p>
    <b>Data: </b>{{ $report->date->format('d-m-Y') }}
</p>
<p>
    <b>Extras :</b> {!! strip_tags($report->description) !!}
</p>

@if($report->file)
    <p>
        Descarca raportul:
        <a href="{{ action( "UploadedFileController@downloadFile" , [$report->file->file_name]) }}" target="_blank" title="{{ $report->file->original_file_name }}">
            <i class="fa fa-file-pdf-o" style="font-size: 18px;"></i>
        </a>
    </p>
@endif