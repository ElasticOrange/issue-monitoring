<script type="text/template" id="delete-button">
	<a href="{{ action($controller.'@destroy', ['__id__']) }}"
		class="btn btn-danger delete-button"
	>
		<span class="glyphicon glyphicon-trash"></span>
	</a>
</script>