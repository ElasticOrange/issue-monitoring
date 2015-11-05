<script type="text/template" id="section_template">
	<div class="section" id="section<%= sectionid%>">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#section_ro<%= sectionid%>" data-toggle="tab">RO</a></li>
			<li><a href="#section_en<%= sectionid%>" data-toggle="tab">EN</a></li>
		</ul>

		<div class="tab-content">
			<br/>
			<div class="tab-pane active" id="section_ro<%= sectionid%>">
				<div class="form-group">
					<label class="col-md-2 control-label">Titlu</label>
					<div class="col-md-8">
						<input type="text" name="section[<%- id%>][title][ro]" class="form-control"></input>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Descriere</label>
					<div class="col-md-8">
						<textarea name="section[<%- id%>][description][ro]" class="form-control" rows="3"></textarea>
					</div>
				</div>
			</div>
			<div class="tab-pane" id="section_en<%= sectionid%>">
				<div class="form-group">
					<label class="col-md-2 control-label">Title</label>
					<div class="col-md-8">
						<input type="text" name="section[<%- id%>][title][en]" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Description</label>
					<div class="col-md-8">
						<textarea name="section[<%- id%>][description][en]" class="form-control" rows="3"></textarea>
					</div>
				</div>
			</div>
			<button type="button" class="btn btn-danger delete_section" id="<%= sectionid%>"><span class="glyphicon glyphicon-trash"></span> Sterge Sectiune</button>
		</div>
		<hr>
	</div>
</script>
