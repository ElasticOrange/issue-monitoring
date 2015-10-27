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
    <script type="text/template" id="section_template">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#section_ro<%= sectionid%>" data-toggle="tab">RO</a></li>
            <li><a href="#section_en<%= sectionid%>" data-toggle="tab">EN</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="section_ro<%= sectionid%>">
                <div class="form-group">
                    <label class="col-md-3">Titlu</label>
                    <input type="text" name="title[ro]" class="form-control"></input>
                    <label class="col-md-3">Descriere</label>
                    <textarea name="description[ro]" class="form-control" rows="3"></textarea>
                </div>
            </div>
            <div class="tab-pane" id="section_en<%= sectionid%>">
                <div class="form-group">
                    <label class="col-md-3">Title</label>
                    <input type="text" name="title[en]" class="form-control">
                    <label class="col-md-3">Description</label>
                    <textarea name="description[en]" class="form-control" rows="3"></textarea>
                </div>
            </div>
            <button type="button" class="btn btn-danger delete_section">Sterge Sectiune</button>
        </div>
        <hr>
    </script>
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

<script>

var compiled = _.template($('#section_template').html());


$('.add_section').on('click', function(){

    var template_populated= compiled({ 'sectionid':_.random(100000, 1000000)});

    $('.sections').append(template_populated);
});

</script>



