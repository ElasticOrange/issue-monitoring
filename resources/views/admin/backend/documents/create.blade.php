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
				  success-url="{{action('DocumentController@index')}}"
			>
				@include('admin.backend.documents.form')
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
