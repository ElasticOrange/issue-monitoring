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
</div>
