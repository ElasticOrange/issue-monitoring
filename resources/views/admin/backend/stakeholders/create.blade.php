@extends('admin.layouts.master')

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="col-sm-6">
			<h1>Adauga Stakeholder</h1>
		</div>
	</div>
</div>

<hr>

<div class="row">
	<div class="col-md-12">
		<form 	class="form-horizontal"
				method="POST"
				action="{{ action("StakeholderController@store") }}"
				enctype="multipart/form-data"
				data-ajax="true"
				success-message="Stakeholder adaugat"
				error-message="Eroare"
				success-url="{{action('StakeholderController@index')}}"
		>
			@include('admin.backend.stakeholders.form')
			<div class="form-group">
    			<div class="col-sm-4" style="margin-top:25px;">
			        <button class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span> Salveaza</button>
			        <a href="{{ action('StakeholderController@index') }}"<button class="btn btn-info"><span class="glyphicon glyphicon-th-list"></span> Inapoi la lista</button></a>
    			</div>
			</div>
		</form>
	</div>
</div>

@endsection


@section('js')
    <script type="text/javascript" src="/js/stakeholders.js"></script>
@endsection
