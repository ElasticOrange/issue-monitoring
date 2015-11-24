<script type="text/template" id="flowstep_template">
	<div class="step connectedSortable" style="margin-top: 15px;" id="step-<%= id%>">
		<input placeholder="Stadiu procedural" name="location[<%= location_id%>][flow_items][<%= id%>][flow_name]"/>
		<input placeholder="Durata estimata" name="location[<%= location_id%>][flow_items][<%= id%>][estimated_duration]"/>
		<input placeholder="Inceput la" name="location[<%= location_id%>][flow_items][<%= id%>][start_date]"/>
		<input placeholder="Finalizat la" name="location[<%= location_id%>][flow_items][<%= id%>][end_date]"/>

		<button type="button" class="btn btn-danger delete_step" delete-id="step-<%= id%>"><span class="glyphicon glyphicon-trash"></span></button>
		<hr>
	</div>
</script>
