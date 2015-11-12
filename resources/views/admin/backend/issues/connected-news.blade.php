<script type="text/template" id="connected-news-template">
	<div class="list-group-item" news-id="<%= id %>">
		<a class="badge" connected-news-delete="<%= id %>">
			<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> sterge
		</a>
		<h4 class="list-group-item-heading"><%= name %></h4>
		<p class="list-group-item-text"></p>
		<input type="hidden" name="news_connected[]" value="<%= id %>" />
	</div>
</script>
