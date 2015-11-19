<script type="text/template" id="location_template">
	<div class="location" id="location-<%= id%>" style="background-color: #ddd">
		<div class="form-group">
			<label class="control-label col-sm-2">Locatie:</label>
			<div class="col-sm-4">
				<input class="form-control"
					name="location[<%= id%>][name]"
					source-url="{{ action('IssueController@queryLocation') }}/?name={name}"
					location-name="true"
					/>
			</div>
		</div>

		<button type="button" class="btn btn-danger delete_location" delete-id="location-<%= id%>"><span class="glyphicon glyphicon-trash"></span> Sterge locatie</button>
		<hr>
	</div>
</script>
