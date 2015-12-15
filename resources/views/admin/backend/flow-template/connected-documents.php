<script type="text/template" id="connected-document-template">
	<tr id="document-<%= id %>">
		<th><%= title%></th>
		<td>
			<a href="/file/<%= fileName%>" target="_blank">
				<i class="fa fa-file-pdf-o"></i>
				<%= file%>
			</a>
		</td>
		<td><%= date%></td>
		<td></td>
		<td>
			<a href="/backend/document/<%= docId%>/edit" target="_blank" title="Edit">
				<span class="glyphicon glyphicon-pencil" style="margin-right: 15px;"></span>
			</a>
			<a class="badge delete_document" connected-document-delete="document-<%= id %>">
				<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
			</a>
		</td>
		<input type="hidden"
			name="location[<%= location_id%>][flow_steps][<%= id%>][document_id][]"
			value="<%= docId%>"
		/>
	</tr>
</script>
