@extends('admin.layouts.master')

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="col-sm-6">
			<h1>Adauga Initiativa</h1>
		</div>
	</div>
</div>

<hr>

<div class="row">
	<div class="col-md-12">
		<form 	class="form-horizontal"
				method="POST"
				action="{{ action('IssueController@store', [$issue]) }}"
				enctype="multipart/form-data"
				data-ajax="true"
				success-message="Initiativa adaugata"
				error-message="Eroare"
				success-url="{{action('IssueController@index')}}"
		>
			@include('admin.backend.issues.form')
			<div class="form-group">
				<div class="col-sm-4" style="margin-top:25px;">
					<button class="btn btn-primary" save-button="true"><span class="glyphicon glyphicon-floppy-disk"></span> Salveaza</button>
					<a href="{{ action('IssueController@index') }}"<button class="btn btn-info"><span class="glyphicon glyphicon-th-list"></span> Inapoi la lista</button></a>
				</div>
			</div>
		</form>
	</div>
</div>

@endsection

@section('js')
	<script type="text/javascript" src="/js/issues.js"></script>
@endsection
