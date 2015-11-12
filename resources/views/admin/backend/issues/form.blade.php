<input type="hidden" name="_token" value="{{ csrf_token() }}">

<div class="form-group">
	<label class="col-md-2 control-label">Tip</label>
	<div class="col-md-8">
		<select class="form-control" name="type">
		</select>
	</div>
</div>

<ul class="nav nav-tabs">
	<li class="active"><a href="#ro" data-toggle="tab">RO</a></li>
	<li><a href="#en" data-toggle="tab">EN</a></li>
</ul>

<div class="tab-content">
	<br/>
	<div class="tab-pane active" id="ro">

		<div class="form-group">
			<label class="col-md-2 control-label">Nume</label>
			<div class="col-md-8">
				<input type="text" name="name[ro]" class="form-control" value="{{ $issue->translateOrNew('ro')->name }}">
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label">Descriere</label>
			<div class="col-md-8">
				<textarea 	name="description[ro]"
							id="editor1"
							class="form-control"
							rows="3"
				>{{ $issue->translateOrNew('ro')->description }}</textarea>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label">Impact asupra altor legi</label>
			<div class="col-md-8">
				<textarea 	name="impact[ro]"
							id="editor2"
							class="form-control"
							rows="3"
				>{{ $issue->translateOrNew('ro')->impact }}</textarea>
			</div>
		</div>

		<div class="form-group" stakeholder-position="true">
			<label class="col-md-2 control-label">Status</label>
			<div class="col-md-8">
				<textarea 	name="status[ro]"
							id="editor3"
							class="form-control"
							rows="3"
				   >{{ $issue->translateOrNew('ro')->status }}</textarea>
			</div>
		</div>

	</div>
	<div class="tab-pane" id="en">

		<div class="form-group">
			<label class="col-md-2 control-label">Name</label>
			<div class="col-md-8">
				<input type="text" name="name[en]" class="form-control" value="{{ $issue->translateOrNew('en')->name }}">
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label">Description</label>
			<div class="col-md-8">
				<textarea 	name="description[en]"
							id="editor4"
							class="form-control"
							rows="3"
				>{{ $issue->translateOrNew('en')->description }}</textarea>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label">Impact on other laws</label>
			<div class="col-md-8">
				<textarea 	name="impact[en]"
							id="editor5"
							class="form-control"
							rows="3"
				>{{ $issue->translateOrNew('en')->impact }}</textarea>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label">Status</label>
			<div class="col-md-8">
				<textarea 	name="status[en]"
							id="editor6"
							class="form-control"
							rows="3"
				   >{{ $issue->translateOrNew('en')->status }}</textarea>
			</div>
		</div>

	</div>

	<div class="form-group">
		<div class="col-md-2 text-right">
			<label for="domain-autocomplete" class="control-label">Domenii cu care este conectat</label>
		</div>
		<div class="col-md-8">
			<div class="input-group">
				<input
					id="domain-autocomplete"
					source-url="{{ action('IssueController@queryDomain') }}/?name={name}"
					type="text"
					placeholder="Nume"
					class="form-control"
				/>
			</div>
		</div>
	</div>

	<div class="form-group">
		@include('admin.backend.issues.connected-domain')
		<div class="panel panel-success col-md-8 col-md-offset-2">
			<div class="panel-heading">Domenii conectate</div>
			<div class="list-group" id="connected-domains-container">
				@foreach ($issue->connectedDomains as $domain_connected)
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
			<label for="stakeholder-autocomplete" class="control-label">Stakeholderi cu care este conectat</label>
		</div>
		<div class="col-md-8">
			<div class="input-group">
				<input
					id="stakeholder-autocomplete"
					source-url="{{ action('IssueController@queryStakeholder') }}/?name={name}"
					type="text"
					placeholder="Nume"
					class="form-control"
				/>
			</div>
		</div>
	</div>

	<div class="form-group">
		@include('admin.backend.issues.connected-stakeholder')
		<div class="panel panel-success col-md-8 col-md-offset-2">
			<div class="panel-heading">Stakeholderi conectati</div>
			<div class="list-group" id="connected-stakeholders-container">
				@foreach ($issue->connectedStakeholders as $stakeholder_connected)
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
			<label for="news-autocomplete" class="control-label">Stiri/declaratii cu care este conectat</label>
		</div>
		<div class="col-md-8">
			<div class="input-group">
				<input
					id="news-autocomplete"
					source-url="{{ action('IssueController@queryNews') }}/?name={name}"
					type="text"
					placeholder="Nume"
					class="form-control"
				/>
			</div>
		</div>
	</div>

	<div class="form-group">
		@include('admin.backend.issues.connected-news')
		<div class="panel panel-success col-md-8 col-md-offset-2">
			<div class="panel-heading">Stiri/declaratii conectate</div>
			<div class="list-group" id="connected-news-container">
				@foreach ($issue->connectedNews as $news_connected)
					<div class="list-group-item" news-id="{{ $news_connected->id }}">
						<a class="badge" connected-news-delete="{{ $news_connected->id }}">
							<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> sterge
						</a>
						<h4 class="list-group-item-heading">{{ $news_connected->title }}</h4>
						<p class="list-group-item-text"></p>
						<input type="hidden" name="news_connected[]" value="{{ $news_connected->id }}" />
					</div>
				@endforeach
			</div>
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-2 text-right">
			<label for="issue-autocomplete" class="control-label">Initiative relevante</label>
		</div>
		<div class="col-md-8">
			<div class="input-group">
				<input
					id="issue-autocomplete"
					source-url="{{ action('IssueController@queryIssue') }}/?name={name}"
					type="text"
					placeholder="Nume"
					class="form-control"
				/>
			</div>
		</div>
	</div>

	<div class="form-group">
		@include('admin.backend.issues.connected-issue')
		<div class="panel panel-success col-md-8 col-md-offset-2">
			<div class="panel-heading">Initiative conectate</div>
			<div class="list-group" id="connected-issues-container">
				@foreach ($issue->issuesConnected as $issue_connected)
					<div class="list-group-item" issue-id="{{ $issue_connected->id }}">
						<a class="badge" connected-issue-delete="{{ $issue_connected->id }}">
							<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> sterge
						</a>
						<h4 class="list-group-item-heading">{{ $issue_connected->name }}</h4>
						<p class="list-group-item-text"></p>
						<input type="hidden" name="issues_connected[]" value="{{ $issue_connected->id }}" />
					</div>
				@endforeach
			</div>
		</div>
	</div>
</div>
