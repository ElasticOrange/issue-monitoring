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
	<label class="col-md-2 control-label">Tag-uri</label>
	<div class="col-md-8">
		<textarea name="tags" class="form-control" rows="2"></textarea>
	</div>
</div>

<div class="form-group">
	<label class="col-md-2 control-label">Data</label>
	<div class="col-md-8">
		<input type="text" date-widget="true" name="init_at" class="form-control" value="{{ $news->date ? $news->date->format('d-m-Y') : '' }}"/>
		<input type="hidden" name="date">
	</div>
</div>

<div class="form-group">
	<label class="col-md-2 control-label">Link</label>
	<div class="col-md-8">
		<input type="text" name="link" class="form-control" value="{{ $news->link }}"></input>
	</div>
</div>

<div class="form-group">
	<div class="col-md-2 text-right">
		<label class="control-label">Documente</label>
	</div>
	<div class="col-md-8">
		<div class="input-group">
			<input type="text" class="form-control" placeholder="Search for...">
			<span class="input-group-btn">
				<button class="btn btn-default" type="button">Go!</button>
			</span>
		</div>
	</div>
	<div class="col-md-2">
		<a href="/backend/news/create"><button type="button" class="btn btn-primary form-control"><span class="glyphicon glyphicon-plus"></span> Adauga</button></a>
	</div>
	<div class="col-md-offset-2 col-md-8">
	<textarea name="tags" class="form-control" rows="2"></textarea>
	</div>
</div>


<div class="form-group">
	<div class="col-md-2 text-right">
		<label class="control-label">Stakeholderi</label>
	</div>
	<div class="col-md-8">
		<div class="input-group">
			<input type="text" class="form-control" placeholder="Search for...">
			<span class="input-group-btn">
				<button class="btn btn-default" type="button">Go!</button>
			</span>
		</div>
	</div>
	<div class="col-md-2">
		<a href="/backend/news/create"><button type="button" class="btn btn-primary form-control"><span class="glyphicon glyphicon-plus"></span> Adauga</button></a>
	</div>
	<div class="col-md-offset-2 col-md-8">
	<textarea name="tags" class="form-control" rows="2"></textarea>
	</div>
</div>

<div class="form-group">
	<div class="col-md-2 text-right">
		<label class="control-label">Domenii</label>
	</div>
	<div class="col-md-8">
		<div class="input-group">
			<input type="text" class="form-control" placeholder="Search for...">
			<span class="input-group-btn">
				<button class="btn btn-default" type="button">Go!</button>
			</span>
		</div>
	</div>
	<div class="col-md-2">
		<a href="/backend/news/create"><button type="button" class="btn btn-primary form-control"><span class="glyphicon glyphicon-plus"></span> Adauga</button></a>
	</div>
	<div class="col-md-offset-2 col-md-8">
	<textarea name="tags" class="form-control" rows="2"></textarea>
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
