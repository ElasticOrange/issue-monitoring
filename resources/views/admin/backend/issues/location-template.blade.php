<script type="text/template" id="location_template">
	<div class="location panel panel-default" id="location-<%= id%>">
		<div class="form-group panel-heading" style="margin: 0px;">
			<label class="control-label col-sm-2">Locatie:</label>
			<div class="col-sm-4">
				<input class="form-control"
					name="location[<%= id%>][name]"
					save-id-to="location-id-location-<%= id%>"
					source-url="{{ action('IssueController@queryLocation') }}/?name={name}"
					location-name="true"
				/>
				<input type="hidden"
					id="location-id-location-<%= id%>"
					name="location[<%= id%>][location_id]"
					value=""
				/>
			</div>
			<div class="col-sm-2">
				<button type="button" class="btn btn-danger delete_location" delete-id="location-<%= id%>">
					<span class="glyphicon glyphicon-trash"></span> Sterge locatie
				</button>
			</div>
            <div class="col-sm-1 col-sm-offset-3" style="cursor: pointer; cursor: hand;">
                <span class="glyphicon glyphicon-move location-handle" style="padding: 10px; right: -40px;"></span>
            </div>
		</div><br/>

		<div id="flow-container-<%= id%>" class="panel panel-primary step connectedSortable ui-sortable" style="min-height: 90px;">
		</div><br/>

		<button type="button"
			class="btn btn-primary add_flowstep"
			location-id="<%= id%>"
            style="margin-bottom: 20px;"
            >
			<span class="glyphicon glyphicon-plus"></span> Adauga pas
		</button>
	</div>
</script>
