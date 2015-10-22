<input type="hidden" id="hiddtoken" name="_token" value="{{ csrf_token() }}">
<input type="hidden" data-parent="true" name="parent_id" value="0">
<div class="form-group">
    <label class="col-md-3 control-label">Nume domeniu</label>
    <div class="col-md-7">
        <input type="text" id="content" name="name[ro]" nume-ro="true" class="form-control"></input>
    </div>
</div>
<br /><br />
<div class="form-group">
    <label class="col-md-3 control-label">Domain name</label>
    <div class="col-md-7">
        <input type="text" id="encontent" name="name[en]" nume-en="true" class="form-control"></input>
    </div>
</div>
<br /><br />