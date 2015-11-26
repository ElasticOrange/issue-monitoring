<script type="text/template" id="flowstep_template">
	<div class="step connectedSortable" style="margin-top: 15px;" id="step-<%= id%>">
		<!-- <input placeholder="Stadiu procedural" name="step[<%= location_id%>][flow_items][<%= id%>][flow_name]"/> -->
		<input placeholder="Stadiu procedural" name="step[<%= id%>][flow_name]"/>
		<input type="number" placeholder="Durata estimata" name="step[<%= id%>][estimated_duration]"/>

		<input type="text" startdate-widget="true" placeholder="Inceput la" />
		<input type="hidden" startdate-result="true" name="step[<%= id%>][start_date]" />

		<input type="text" enddate-widget="true" placeholder="Finalizat la" />
		<input type="hidden" enddate-result="true" name="step[<%= id%>][end_date]" />

		<input type="hidden" location-step="true" name="step[<%= id%>][location_step_id]"/>

		<button type="button" class="btn btn-danger delete_step" delete-id="step-<%= id%>"><span class="glyphicon glyphicon-trash"></span></button>
		<hr>
	</div>
</script>
