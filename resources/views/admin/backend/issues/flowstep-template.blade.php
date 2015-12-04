<script type="text/template" id="flowstep_template">
	<div class="step connectedSortable" style="margin-top: 15px;" id="location[<%= location_id%>][flow_steps]-<%= id%>">
		<div class="row">
			<div class="col-sm-1">
				<label></label>
			</div>
			<div class="col-sm-4">
				<label>Stadiu procedural</label>
			</div>
			<div class="col-sm-1">
				<label>Durata</label>
			</div>
			<div class="col-sm-2">
				<label>Inceput la</label>
			</div>
			<div class="col-sm-2">
				<label>Finalizat la</label>
			</div>
			<div class="col-sm-1">
				<label>Actiuni</label>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-1">
				<div class="accordion-toggle"
					data-toggle="collapse"
					data-target="#collapse-<%= id%>"
					style="margin-top: -10px;margin-left: 20px;padding: 20px 40px 20px 40px;">
					<span class="glyphicon glyphicon-menu-down"></span>
				</div>
			</div>
			<div class="col-sm-4">
				<input class="form-control" placeholder="Stadiu procedural" name="location[<%= location_id%>][flow_steps][<%= id%>][flow_name]"/>
			</div>
			<div class="col-sm-1">
				<input class="form-control" type="number" placeholder="Durata" name="location[<%= location_id%>][flow_steps][<%= id%>][estimated_duration]"/>
			</div>
			<div class="col-sm-2">
				<input class="form-control" type="text" id="startdate-widget-<%= id%>" placeholder="Inceput la" />
				<input type="hidden" id="startdate-result-<%= id%>" name="location[<%= location_id%>][flow_steps][<%= id%>][start_date]" />
			</div>
			<div class="col-sm-2">
				<input class="form-control" type="text" id="enddate-widget-<%= id%>" placeholder="Finalizat la" />
				<input type="hidden" id="enddate-result-<%= id%>" name="location[<%= location_id%>][flow_steps][<%= id%>][end_date]" />
			</div>
			<div class="col-sm-1">
				<input type="hidden" id="step-id-step-<%= id%>" name="location[<%= location_id%>][flow_steps][<%= id%>][location_step_id]"/>
				<button type="button" class="btn btn-danger delete_step" delete-id="location[<%= location_id%>][flow_steps]-<%= id%>">
					<span class="glyphicon glyphicon-trash"></span>
				</button>
			</div>
		</div>
		<div class="accordion-body collapse" id="collapse-<%= id%>">
		<hr>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#flow-documente-<%= id%>" data-toggle="tab">Documente</a>
				</li>
				<li>
					<a href="#flow-observatii-<%= id%>" data-toggle="tab">Observatii</a>
				</li>
			</ul>
			<div class="tab-content">
				<br/>
				<div class="tab-pane active" id="flow-documente-<%= id%>">
					<br/>
					<div class="row">
						<div class="col-lg-10 col-lg-offset-1">
							<input
								id="document-autocomplete"
								source-url="{{ action('IssueController@queryDocument') }}/?name={name}"
								type="text"
								placeholder="Cauta document"
								class="form-control"
							/>
						</div>
					</div>
					<br/>
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Titlu</th>
								<th style="width: 35%;">Fisier</th>
								<th style="width: 10%;">Data</th>
								<th style="width: 10%;">Nr Inregistrare</th>
								<th style="width: 5%;">Actiuni</th>
							</tr>
						</thead>
						<tbody id="autocomplete-document">
							<tr>
								<th>
									Niciun document adaugat
								</th>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="tab-pane" id="flow-observatii-<%= id%>">
					<br/>
					<div class="form-group">
						<div class="row">
							<label class="col-md-4 col-md-offset-1">Ro</label>
							<label class="col-md-4 col-md-offset-1">En</label>
						</div>
						<div class="row">
							<div class="col-md-4 col-md-offset-1">
								<textarea name="location[<%= location_id%>][flow_steps][<%= id%>][observatii][ro]"
									class="form-control"
									style="resize: none;"
									rows="6"
									cols="20"></textarea>
							</div>
							<div class="col-md-4 col-md-offset-1">
								<textarea name="location[<%= location_id%>][flow_steps][<%= id%>][observatii][en]"
									class="form-control"
									style="resize: none;"
									rows="6"
									cols="20"></textarea>
							</div>
						</div>
					</div><br/>
				</div>
			</div>
		</div>
	</div>
</script>
