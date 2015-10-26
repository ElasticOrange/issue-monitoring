@extends('admin.layouts.master')

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="col-sm-6">
			<h1>Modifica Stakeholder</h1>
		</div>
		<div class="col-sm-4 col-sm-offset-2" style="margin-top:25px;">
			<button class="btn btn-primary">Salveaza schimbari</button>
			<a href="{{ action('StakeholderController@index') }}"><button class="btn btn-info">Inapoi la lista</button></a>
		</div>
	</div>
</div>

<hr>

<div class="row">
	<div class="col-md-12">
		<form class="form-horizontal" method="POST" action="/backend/stakeholder/{{ $stakeholder->id }}">
			<input type="hidden" name="_method" value="PUT"/>
			@include('admin.backend.stakeholders.form')
			<div class="form-group">
    			<div class="col-sm-4" style="margin-top:25px;">
			        <button class="btn btn-primary">Salveaza schimbari</button>
			        <a href="{{ action('StakeholderController@index') }}"><button type="button" class="btn btn-info">Inapoi la lista</button></a>
    			</div>
    			<div class="col-sm-2 col-sm-offset-6" style="margin-top:25px;">
		            <a href="{{ action("StakeholderController@destroy", [$stakeholder]) }}" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Sterge</a>
    			</div>
			</div>
		</form>
	</div>
</div>

@endsection
