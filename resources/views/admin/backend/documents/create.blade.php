@extends('admin.layouts.master')

@section('content')
<div class="col-sm-12 text-center">
	<h1>Creaza Document</h1>
	<br /><br /><br />
	<div class="row">
		<div class="col-md-12">
			<form action="/backend/document" class="form-horizontal" method="POST" enctype="multipart/form-data">
				@include('admin.backend.documents.form')
			</form>
			@if ($errors->any())
				<ul class="alert alert-danger">
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			@endif
		</div>
	</div>
</div>
@endsection
