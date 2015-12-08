<script type="text/template" id="location_template">
	<div class="location" id="location-<%= id%>">
		<div class="form-group">
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
		</div>

		<div id="flow-container-<%= id%>" class="step connectedSortable" style="min-height: 15px; border: 1px solid black; margin-bot: 5px;">
		</div><br/>

		<button type="button"
			class="btn btn-primary add_flowstep"
			location-id="<%= id%>">
			<span class="glyphicon glyphicon-plus"></span> Adauga pas
		</button>
		<hr>
	</div>
</script>
