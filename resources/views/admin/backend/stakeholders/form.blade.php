<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="form-group">
	<label class="col-md-2 control-label">Nume</label>
	<div class="col-md-8">
		<input type="text" name="name" class="form-control" value="{{ $stakeholder->name }}"/>
	</div>
</div>

<div class="form-group">
	<label class="col-md-2 control-label">Tip</label>
	<div class="col-md-8">
		<select class="form-control" name="type">
			<option value="persoana">persoana</option>
			<option value="organizatie" @if($stakeholder->type === 'organizatie') selected="selected" @endif>organizatie</option>
		</select>
	</div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">Email</label>
    <div class="col-md-8">
        <input type="text" name="email" class="form-control" value="{{ $stakeholder->email }}"/>
    </div>
</div>

<div class="form-group" stakeholder-type="true">
    <label class="col-md-2 control-label">Telefon</label>
    <div class="col-md-8">
        <input type="text" name="telephone" class="form-control" value="{{ $stakeholder->telephone }}"/>
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
            <label class="col-md-2 control-label">Adresa</label>
            <div class="col-md-8">
                <input type="text" name="address[ro]" class="form-control" value="{{ $stakeholder->translateOrNew('ro')->address }}">
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-2 control-label">Alte detalii</label>
            <div class="col-md-8">
                <textarea name="other_details[ro]" class="form-control" rows="3">{{ $stakeholder->translateOrNew('ro')->other_details }}</textarea>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-2 control-label">Profil</label>
            <div class="col-md-8">
                <textarea 	name="profile[ro]"
                			id="editor1"
                			class="form-control"
                			rows="3"
                >{{ $stakeholder->translateOrNew('ro')->profile }}</textarea>
            </div>
        </div>

        <div class="form-group" stakeholder-position="true">
            <label class="col-md-2 control-label">Pozitie si apartenenta</label>
            <div class="col-md-8">
                <textarea 	name="position[ro]"
                			id="editor2"
                			class="form-control"
                			rows="3"
               	>{{ $stakeholder->translateOrNew('ro')->position }}</textarea>
            </div>
        </div>

    </div>

    <div class="tab-pane" id="en">

        <div class="form-group">
            <label class="col-md-2 control-label">Address</label>
            <div class="col-md-8">
                <input type="text" name="address[en]" class="form-control" value="{{ $stakeholder->translateOrNew('en')->address }}">
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-2 control-label">Other details</label>
            <div class="col-md-8">
                <textarea name="other_details[en]" class="form-control" rows="3">{{ $stakeholder->translateOrNew('en')->other_details }}</textarea>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-2 control-label">Profile</label>
            <div class="col-md-8">
                <textarea 	name="profile[en]"
                			class="form-control"
                			rows="3"
                			id="editor3"
                >{{ $stakeholder->translateOrNew('en')->profile }}</textarea>
            </div>
        </div>

        <div class="form-group" stakeholder-position="true">
            <label class="col-md-2 control-label">Position and affiliation</label>
            <div class="col-md-8">
                <textarea 	name="position[en]"
                			class="form-control"
                			rows="3"
 							id="editor4"
                 >{{ $stakeholder->translateOrNew('en')->profile }}</textarea>
            </div>
        </div>

    </div>
</div>

<hr>

<div class="sections">
	@if(isset($sections))
		@foreach($sections as $section)
		<div class="section" id="section{{ $section->id }}">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#section_ro{{ $section->id }}" data-toggle="tab">RO</a></li>
				<li><a href="#section_en{{ $section->id }}" data-toggle="tab">EN</a></li>
			</ul>

			<div class="tab-content">
				<br/>
				<div class="tab-pane active" id="section_ro{{ $section->id }}">
					<div class="form-group">
						<label class="col-md-2 control-label">Titlu</label>
						<div class="col-md-8">
							<input type="text" name="section[{{ $section->id }}][title][ro]" class="form-control" value="{{ $section->translateOrNew('ro')->title }}"></input>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2 control-label">Descriere</label>
						<div class="col-md-8">
							<textarea name="section[{{ $section->id }}][description][ro]" class="form-control" rows="3">{{ $section->translateOrNew('ro')->description }}</textarea>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="section_en{{ $section->id }}">
					<div class="form-group">
						<label class="col-md-2 control-label">Title</label>
						<div class="col-md-8">
							<input type="text" name="section[{{ $section->id }}][title][en]" class="form-control" value="{{ $section->translateOrNew('en')->title }}">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2 control-label">Description</label>
						<div class="col-md-8">
							<textarea name="section[{{ $section->id }}][description][en]" class="form-control" rows="3">{{ $section->translateOrNew('en')->description }}</textarea>
						</div>
					</div>
				</div>
				<button type="button" class="btn btn-danger delete_section" id="{{ $section->id }}">Sterge Sectiune</button>
			</div>
			<hr>
		</div>
		@endforeach
	@endif
	@include('admin.backend.stakeholders.section')
</div>

<button type="button" class="btn btn-primary add_section"><span class="glyphicon glyphicon-plus"></span> Adauga sectiune</button>

<hr/>

<div class="form-group">
	<label class="col-md-2 control-label">Site/blog</label>
	<div class="col-md-8">
		<input type="text" name="site" class="form-control" value="{{ $stakeholder->site }}"></input>
	</div>
</div>

<div class="form-group">
	<label class="col-md-2 control-label">CV</label>
	<div class="col-md-8">
		<label>
			<span class="btn btn-primary selected-file">Incarca fisier</span>
			<input type="file" name="cv_file" class="hidden"/>
		</label>
		@if($stakeholder->fileCv)
			<a href="{{ action( "UploadedFileController@downloadFile" , [$stakeholder->fileCv->file_name]) }}" target="_blank">
				<i class="fa fa-file-pdf-o"></i>
				{{ $stakeholder->fileCv->original_file_name }}
			</a>
		@endif
	</div>
</div>

<div class="form-group">
	<label class="col-md-2 control-label">Poza</label>
	<div class="col-md-8">
		<label>
			<span class="btn btn-primary selected-file">Incarca fisier</span>
			<input type="file" name="poza_file" class="hidden"/>
		</label>
		@if($stakeholder->filePoza)
			<a href="{{ action( "UploadedFileController@downloadFile" , [$stakeholder->filePoza->file_name]) }}" target="_blank">
				<i class="fa fa-file-pdf-o"></i>
				{{ $stakeholder->filePoza->original_file_name }}
			</a>
		@endif
	</div>
</div>

<div class="form-group">
	<div class="checkbox col-md-10 col-md-offset-2">
		<label>
			<input  type="checkbox"
					value="1"
					name="published"
					@if($stakeholder->published)
						checked="checked"
					@endif
			/>Publica
		</label>
	</div>
</div>

<!-- Connected stakeholders autocomplete -->
<div class="form-group">
	<label for="stakeholder-autocomplete" class="control-label">Stakeholderi cu care este conectat</label>
	<input
		id="stakeholder-autocomplete"
		source-url="{{ action('StakeholderController@queryList') }}/?name={name}"
		type="text"
		placeholder="Nume"
		class="form-control"
	/>
</div>

<!-- Connected stakeholders list -->
@include('admin.backend.stakeholders.connected-stakeholder')
<div class="panel panel-success">
	<div class="panel-heading">Stakeholderi conectati</div>
	<div class="list-group" id="connected-stakeholders-container">
		@foreach ($stakeholder->stakeholdersConnected as $stakeholder_connected)
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

<div class="form-group">
	<div class="checkbox col-md-10 col-md-offset-2">
		<label>
			<input  type="checkbox"
					value="1"
					name="published"
					@if($stakeholder->published)
						checked="checked"
					@endif
			/>Publica
		</label>
	</div>
</div>
