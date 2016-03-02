<script type="text/template" id="external_link">
	<a href="{{ action('DocumentController@show', ['__publicCode__']) }}"
		target="_blank"
		title="{{ action('DocumentController@show', ['__publicCode__']) }}"
	>
		<i class="fa fa-external-link fa-lg"></i>
	</a>
</script>