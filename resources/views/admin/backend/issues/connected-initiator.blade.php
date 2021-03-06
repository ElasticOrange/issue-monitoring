<script type="text/template" id="connected-initiator-template">
	<div class="list-group-item" initiator-id="<%= id %>">
		<a class="badge" connected-initiator-delete="<%= id %>">
			<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> sterge
		</a>
		<h4 class="list-group-item-heading"><%= name %></h4>
		<p class="list-group-item-text"></p>
		<input type="hidden" name="initiators_connected[]" value="<%= id %>" />
	</div>
</script>
