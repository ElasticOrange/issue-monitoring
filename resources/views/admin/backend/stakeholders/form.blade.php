<div class="form-group">
	<label class="col-md-2 control-label">Nume</label>
	<div class="col-md-8">
		<input type="text" id="name" name="name" class="form-control"></input>
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
            <textarea id="encontent" name="contact[ro]" class="form-control" rows="3"></textarea>
        </div>

        <div class="form-group">
            <label class="col-md-3">Profil</label>
            <textarea id="encontent" name="profile[ro]" class="form-control" rows="3"></textarea>
        </div>

        <div class="form-group">
            <label class="col-md-3">Pozitie si apartenenta</label>
            <textarea id="encontent" name="position[ro]" class="form-control" rows="3"></textarea>
        </div>

    </div>

    <div class="tab-pane" id="en">

        <div class="form-group">
            <label class="col-md-3">Contact</label>
            <textarea id="encontent" name="contact[en]" class="form-control" rows="3"></textarea>
        </div>

        <div class="form-group">
            <label class="col-md-3">Profile</label>
            <textarea id="encontent" name="profile[en]" class="form-control" rows="3"></textarea>
        </div>

        <div class="form-group">
            <label class="col-md-3">Position and affiliation</label>
            <textarea id="encontent" name="position[en]" class="form-control" rows="3"></textarea>
        </div>

    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">Site/blog</label>
    <div class="col-md-8">
        <input type="text" id="name" name="site" class="form-control"></input>
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">CV</label>
    <div class="col-md-8">
        <input type="file" id="file" name="file"/>
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">Poza</label>
    <div class="col-md-8">
        <input type="file" id="file" name="file"/>
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">Link public</label>
    <div class="col-md-8">
        <input type="text" id="name" name="download_code" class="form-control"></input>
    </div>
</div>

<div class="checkbox col-md-8 col-md-offset-1">
    <input type="hidden" value="0" />
    <label>
        <input type="checkbox" value="1" name="publised"/>Publica
    </label>
</div>

<div class="row">
    <div class="col-sm-4" style="margin-top:25px;">
        <button class="btn btn-primary">Salveaza schimbari</button>
        <a href="/backend/stakeholders/"<button class="btn btn-info">Inapoi la lista</button></a>
    </div>
    <div class="col-sm-2 col-sm-offset-6" style="margin-top:25px;">
        <button type="button" class="btn btn-danger"><span class="glyphicon glyphicon-erase"> Sterge</button>
    </div>


