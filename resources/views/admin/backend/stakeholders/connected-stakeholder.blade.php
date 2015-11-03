<script type="text/template" id="connected-stakeholder-template">
	<div class="list-group-item" stakeholder-id="<%= id %>">
		<a class="badge" connected-stakeholder-delete="<%= id %>">
			<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> sterge
		</a>
		<h4 class="list-group-item-heading"><%= name %></h4>
		<p class="list-group-item-text"></p>
		<input type="hidden" name="connected-stakeholers[]" value="<%= id %>" />
	</div>
</script>
