@extends('admin.layouts.master')

@section('content')
<div class="col-sm-12 text-center">
	<h1>Editeaza Document</h1>
	<br /><br /><br />
	<div class="row">
		<div class="col-md-12">
			<form action="/backend/document/{{ $document->id }}"
				class="form-horizontal"
				method="POST"
				enctype="multipart/form-data"
				data-ajax="true"
				success-message="Document salvat cu succes"
				error-message="Eroare"
				success-url="/backend/document"
				>
				<input name="_method" type="hidden" value="PUT">
				@include('admin.backend.documents.form')

				<div class="form-group">
					<label class="col-md-3 control-label">Link public</label>
					<div class="col-md-7 control-label" style="text-align: left">
						<a href="{{ action('DocumentController@show', [$document->public_code]) }}" target="_blank">{{ action('DocumentController@show', [$document->public_code]) }}</a>
					</div>
				</div>

				<div class="form-actions">
					<div class="row">
						<div class="col-md-offset-3 col-md-7">
								<input type="submit" value="Salveaza" class="btn btn-primary btn-lg btn-block" />
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

@endsection
@section('js')
	<script type="text/javascript" src="/js/documents.js"></script>
@endsection
