@extends('admin.layouts.master')

@section('content')
<div class="col-sm-12 text-center">
	<h1>Creaza Document</h1>
	<br /><br /><br />
	<div class="row">
		<div class="col-md-12">
	        <form action="/backend/document"
				  class="form-horizontal"
				  method="POST"
				  enctype="multipart/form-data"
				  data-ajax="true"
				  success-message="Document adaugat"
				  error-message="Eroare"
				  success-url="/backend/document/{id}/edit"
			>
				@include('admin.backend.documents.form')
			</form>
		</div>
	</div>
</div>

@endsection
@section('js')
	<script type="text/javascript" src="/js/documents.js"></script>
@endsection
