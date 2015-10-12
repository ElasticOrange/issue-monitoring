@extends('admin.layouts.master')

@section('content')
<div class="col-sm-12 text-center">
	<h1>Editeaza Document</h1>
	<br /><br /><br />
	<div class="row">
		<div class="col-md-12">
	        <form action="/backend/document/{{ $document->id }}" class="form-horizontal" method="POST" enctype="multipart/form-data" role="form">
				<input name="_method" type="hidden" value="PUT">
				@include('admin.backend.documents.form')
	        </form>
	    </div>
	</div>
</div>
@endsection
