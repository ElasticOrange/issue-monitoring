<script type="text/template" id="connected-domain-template">
	<div class="list-group-item" domain-id="<%= id %>">
		<a class="badge" connected-domain-delete="<%= id %>">
			<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> sterge
		</a>
		<h4 class="list-group-item-heading"><%= name %></h4>
		<p class="list-group-item-text"></p>
		<input type="hidden" name="domains_connected[]" value="<%= id %>" />
	</div>
</script>
