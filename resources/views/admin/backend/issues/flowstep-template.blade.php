<script type="text/template" id="flowstep_template">
	<div class="connectedSortable" style="margin-top: 15px;" id="step-<%= id%>">gigi kent
		<input placeholder="Stadiu procedural" name="name"/>
		<input placeholder="Durata estimata" name="estimated_duration"/>
		<input placeholder="Inceput la" name="start_date"/>
		<input placeholder="Finalizat la" name="end_date"/>

		<button type="button" class="btn btn-danger delete_step" delete-id="step-<%= id%>"><span class="glyphicon glyphicon-trash"></span></button>
		<hr>
	</div>
</script>
