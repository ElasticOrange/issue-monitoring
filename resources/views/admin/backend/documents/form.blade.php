<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="form-group">
	<label class="col-md-3 control-label">Titlu</label>
	<div class="col-md-7">
		<textarea id="content" name="description[ro]" class="form-control" rows="3">{{ $document->translateOrNew('ro')->description }}</textarea>
	</div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">Title</label>
    <div class="col-md-7">
        <textarea id="encontent" name="description[en]" class="form-control" rows="3">{{ $document->translateOrNew('en')->description }}</textarea>
    </div>
</div>
<div class="form-group text-left">
    <label class="col-md-3 control-label">Incarca document</label>
    <div class="col-md-9">
        <label class="">
            <span class="btn btn-primary selected-file">Incarca fisier</span>
    	    <input type="file" id="file" name="file" class="hidden"/>
        </label>
        @if($document->file)
            <a href="{{ action( "UploadedFileController@downloadFile" , [$document->file->file_name]) }}" target="_blank">
                <i class="fa fa-file-pdf-o"></i>
        	   {{ $document->file->original_file_name }}
            </a>
        @endif
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">Data</label>
    <div class="col-md-7">
        <input type="text" date-widget="true" name="init_at" class="form-control" />
        <input type="hidden" name="date">
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">Link</label>
    <div class="col-md-7">
        <input type="text" id="link" name="link" placeholder="Ex: www.server.com/test/document.doc" class="form-control" value="{{ $document->link }}" size="105" />
    </div>
</div>
<div class="form-actions">
    <div class="row">
        <div class="col-md-offset-3 col-md-7">
        	<input type="submit" value="Salveaza" class="btn btn-primary btn-lg btn-block" />
     	</div>
    </div>
</div>
