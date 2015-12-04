<script type="text/template" id="connected-document-template">
	<tr id="document-<%= id %>">
		<th><%= title%></th>
		<td><%= fisier%></td>
		<td><%= date%></td>
		<td></td>
		<td>
			<span class="glyphicon glyphicon-pencil" style="margin-right: 5px;"></span>
			<a class="badge" connected-document-delete="document-<%= id %>">
				<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
			</a>
		</td>
		<input type="hidden"  name="location[<%= location_id%>][flow_steps][<%= id%>][document_id][]" value />
	</tr>
</script>
