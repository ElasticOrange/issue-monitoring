<script id="download_file" type="text/template">
	<a href="{{ action('UploadedFileController@downloadFile', ['__fileName__']) }}"
		target="_blank" 
		title="__originalFileName__">
		<i class="fa fa-file-pdf-o fa-lg"></i>
	</a>
</script>