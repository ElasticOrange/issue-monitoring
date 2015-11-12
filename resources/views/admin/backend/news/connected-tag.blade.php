<script type="text/template" id="connected-tag-template">
	<div class="list-group-item" tag-id="<%= id %>">
		<a class="badge" connected-tag-delete="<%= id %>">
			<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> sterge
		</a>
		<h4 class="list-group-item-heading"><%= name %></h4>
		<p class="list-group-item-text"></p>
		<input type="hidden" name="tags_connected[]" value="<%= id %>" />
	</div>
</script>
