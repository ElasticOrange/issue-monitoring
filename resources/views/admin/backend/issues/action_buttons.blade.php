<script id="action_buttons" type="text/template">
	<div class="row">
		<a href="{{ action($controller.'@edit', ['__id__']) }}" class="btn btn-primary">
			<span class="glyphicon glyphicon-pencil"></span>
		</a>
		<a href="{{ action($controller.'@destroy', ['__id__']) }}" class="btn btn-danger delete-button">
			<span class="glyphicon glyphicon-trash"></span>
		</a>
	</div>
</script>