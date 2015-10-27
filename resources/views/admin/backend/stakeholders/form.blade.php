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
            <option>persoana</option>
            <option>organizatie</option>
        </select>
    </div>
</div>

<ul class="nav nav-tabs">
    <li class="active"><a href="#ro" data-toggle="tab">RO</a></li>
    <li><a href="#en" data-toggle="tab">EN</a></li>
</ul>

<div class="tab-content">
    <div class="tab-pane active" id="ro">

        <div class="form-group">
            <label class="col-md-3">Contact</label>
            <textarea name="contact[ro]" class="form-control" rows="3">{{ $stakeholder->translateOrNew('ro')->contact }}</textarea>
        </div>

        <div class="form-group">
            <label class="col-md-3">Profil</label>
            <textarea name="profile[ro]" class="form-control" rows="3">{{ $stakeholder->translateOrNew('ro')->profile }}</textarea>
        </div>

        <div class="form-group">
            <label class="col-md-3">Pozitie si apartenenta</label>
            <textarea name="position[ro]" class="form-control" rows="3">{{ $stakeholder->translateOrNew('ro')->position }}</textarea>
        </div>

    </div>

    <div class="tab-pane" id="en">

        <div class="form-group">
            <label class="col-md-3">Contact</label>
            <textarea name="contact[en]" class="form-control" rows="3">{{ $stakeholder->translateOrNew('en')->contact }}</textarea>
        </div>

        <div class="form-group">
            <label class="col-md-3">Profile</label>
            <textarea name="profile[en]" class="form-control" rows="3">{{ $stakeholder->translateOrNew('en')->profile }}</textarea>
        </div>

        <div class="form-group">
            <label class="col-md-3">Position and affiliation</label>
            <textarea name="position[en]" class="form-control" rows="3">{{ $stakeholder->translateOrNew('en')->profile }}</textarea>
        </div>

    </div>
</div>

<hr>

<div class="sections">
    @include('admin.backend.stakeholders.section')
</div>


<button type="button" class="btn btn-default add_section">Adauga sectiune</button>

<div class="form-group">
    <label class="col-md-2 control-label">Site/blog</label>
    <div class="col-md-8">
        <input type="text" name="site" class="form-control" value="{{ $stakeholder->site }}"></input>
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">CV</label>
    <div class="col-md-8">
        <input type="file" name="file"/>
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">Poza</label>
    <div class="col-md-8">
        <input type="file" name="file"/>
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">Link public</label>
    <div class="col-md-8">
        <input type="text" name="public_code" class="form-control" value="{{ $stakeholder->public_code }}"></input>
    </div>
</div>

<div class="checkbox col-md-8 col-md-offset-1">
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

@section('js')
    <script type="text/javascript" src="/js/stakeholder-sections.js"></script>
@endsection




