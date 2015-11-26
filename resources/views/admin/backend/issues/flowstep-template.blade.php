<script type="text/template" id="flowstep_template">
	<div class="step connectedSortable" style="margin-top: 15px;" id="step-<%= id%>">
		<div class="accordion-toggle glyphicon glyphicon-menu-down" data-toggle="collapse" data-target="#collapse-<%= id%>" style="margin: 5px;"></div>
		<input placeholder="Stadiu procedural" name="step[<%= id%>][flow_name]"/>
		<input type="number" placeholder="Durata estimata" name="step[<%= id%>][estimated_duration]"/>

		<input type="text" startdate-widget="true" placeholder="Inceput la" />
		<input type="hidden" startdate-result="true" name="step[<%= id%>][start_date]" />

		<input type="text" enddate-widget="true" placeholder="Finalizat la" />
		<input type="hidden" enddate-result="true" name="step[<%= id%>][end_date]" />

		<input type="hidden" location-step="true" name="step[<%= id%>][location_step_id]"/>

		<button type="button" class="btn btn-danger delete_step" delete-id="step-<%= id%>"><span class="glyphicon glyphicon-trash"></span></button>
		<hr>
		<div class="accordion-body collapse" id="collapse-<%= id%>">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#flow-documente-<%= id%>" data-toggle="tab">Documente</a></li>
				<li><a href="#flow-observatii-<%= id%>" data-toggle="tab">Observatii</a></li>
			</ul>
			<div class="tab-content">
				<br/>
				<div class="tab-pane active" id="flow-documente-<%= id%>">
					<br/>
					gigel documente
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
								<textarea name="step[<%= id%>][observatii][ro]" class="form-control" style="resize: none;" rows="6" cols="20"></textarea>
							</div>
							<div class="col-md-4 col-md-offset-1">
								<textarea name="step[<%= id%>][observatii][en]" class="form-control" style="resize: none;" rows="6" cols="20"></textarea>
							</div>
						</div>
					</div><br/>
				</div>
			</div>
		</div>
	</div>
</script>
