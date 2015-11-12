<input type="hidden" name="_token" value="{{ csrf_token() }}">
<ul class="nav nav-tabs">
	<li class="active"><a href="#news_ro" data-toggle="tab">RO</a></li>
	<li><a href="#news_en" data-toggle="tab">EN</a></li>
</ul>

<div class="tab-content">
	<div class="tab-pane active" id="news_ro">
		<div class="form-group">
			<label class="col-md-2 control-label">Titlu</label>
			<div class="col-md-8">
				<input type="text" name="title[ro]" class="form-control" value="{{ $news->translateOrNew('ro')->title}}">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label">Descriere</label>
			<div class="col-md-8">
				<textarea name="description[ro]" class="form-control" rows="3">{{ $news->translateOrNew('ro')->description}}</textarea>
			</div>
		</div>
	</div>

	<div class="tab-pane" id="news_en">
		<div class="form-group">
			<label class="col-md-2 control-label">Title</label>
			<div class="col-md-8">
				<input type="text" name="title[en]" class="form-control" value="{{ $news->translateOrNew('en')->title}}">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label">Description</label>
			<div class="col-md-8">
				<textarea name="description[en]" class="form-control" rows="3">{{ $news->translateOrNew('en')->description}}</textarea>
			</div>
		</div>
	</div>
</div>

<hr>

<div class="form-group">
	<label class="col-md-2 control-label">Data</label>
	<div class="col-md-8">
		<input type="text" date-widget="true" name="date_init" class="form-control" value="{{ $news->date ? $news->date->format('d-m-Y') : '' }}"/>
		<input type="hidden" name="date">
	</div>
</div>

<div class="form-group">
	<label class="col-md-2 control-label">Link</label>
	<div class="col-md-8">
		<input type="text" name="link" class="form-control" value="{{ $news->link }}" placeholder="Ex: http://www.google.ro"></input>
	</div>
</div>

<div class="form-group">
	<label class="col-md-2 control-label">Document</label>
	<div class="col-md-8">
		<label>
			<span class="btn btn-primary selected-file ellipsis">Incarca fisier</span>
			<input type="file" name="document_file" class="hidden"/>
		</label>
		@if($news->fileDocument)
			<a href="{{ action( "UploadedFileController@downloadFile" , [$news->fileDocument->file_name]) }}" target="_blank">
				<i class="fa fa-file-pdf-o"></i>
				{{ $news->fileDocument->original_file_name }}
			</a>
		@endif
	</div>
</div>

<div class="form-group">
	<div class="col-md-2 text-right">
		<label for="stakeholder-autocomplete" class="control-label">Stakeholderi cu care este conectat</label>
	</div>
	<div class="col-md-8">
		<input
			id="stakeholder-autocomplete"
			source-url="{{ action('NewsController@queryStakeholder') }}/?name={name}"
			type="text"
			placeholder="Nume"
			class="form-control"
		/>
	</div>
</div>

<div class="form-group">
	@include('admin.backend.news.connected-stakeholder')
	<div class="panel panel-success col-md-8 col-md-offset-2">
		<div class="panel-heading">Stakeholderi conectati</div>
		<div class="list-group" id="connected-stakeholders-container">
			@foreach ($news->connectedStakeholders as $stakeholder_connected)
				<div class="list-group-item" stakeholder-id="{{ $stakeholder_connected->id }}">
					<a class="badge" connected-stakeholder-delete="{{ $stakeholder_connected->id }}">
						<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> sterge
					</a>
					<h4 class="list-group-item-heading">{{ $stakeholder_connected->name }}</h4>
					<p class="list-group-item-text"></p>
					<input type="hidden" name="stakeholders_connected[]" value="{{ $stakeholder_connected->id }}" />
				</div>
			@endforeach
		</div>
	</div>
</div>

<div class="form-group">
	<div class="col-md-2 text-right">
		<label for="domain-autocomplete" class="control-label">Domenii cu care este conectat</label>
	</div>
	<div class="col-md-8">
		<input
			id="domain-autocomplete"
			source-url="{{ action('NewsController@queryDomain') }}/?name={name}"
			type="text"
			placeholder="Nume"
			class="form-control"
		/>
	</div>
</div>

<div class="form-group">
	@include('admin.backend.news.connected-domain')
	<div class="panel panel-success col-md-8 col-md-offset-2">
		<div class="panel-heading">Domenii conectate</div>
		<div class="list-group" id="connected-domains-container">
			@foreach ($news->connectedDomains as $domain_connected)
				<div class="list-group-item" domain-id="{{ $domain_connected->id }}">
					<a class="badge" connected-domain-delete="{{ $domain_connected->id }}">
						<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> sterge
					</a>
					<h4 class="list-group-item-heading">{{ $domain_connected->name }}</h4>
					<p class="list-group-item-text"></p>
					<input type="hidden" name="domains_connected[]" value="{{ $domain_connected->id }}" />
				</div>
			@endforeach
		</div>
	</div>
</div>

<div class="form-group">
	<div class="col-md-2 text-right">
		<label for="tag-autocomplete" class="control-label">Taguri</label>
	</div>
	<div class="col-md-8">
		<input
			id="tag-autocomplete"
			source-url="{{ action('NewsController@queryTag') }}/?name={name}"
			type="text"
			placeholder="Nume"
			class="form-control"
		/>
	</div>
</div>

<div class="form-group">
	@include('admin.backend.news.connected-tag')
	<div class="panel panel-success col-md-8 col-md-offset-2">
		<div class="panel-heading">Taguri conectate</div>
		<div class="list-group" id="connected-tags-container">
			@foreach ($news->connectedTags as $tag_connected)
				<div class="list-group-item" tag-id="{{ $tag_connected->id }}">
					<a class="badge" connected-tag-delete="{{ $tag_connected->id }}">
						<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> sterge
					</a>
					<h4 class="list-group-item-heading">{{ $tag_connected->name }}</h4>
					<p class="list-group-item-text"></p>
					<input type="hidden" name="tags_connected[]" value="{{ $tag_connected->id }}" />
				</div>
			@endforeach
		</div>
	</div>
</div>

<div class="form-group">
	<div class="checkbox col-md-8 col-md-offset-1">
		<label>
			<input  type="checkbox"
					value="1"
					name="published"
					@if($news->published)
						checked="checked"
					@endif
			/>Publica
		</label>
	</div>
</div>
