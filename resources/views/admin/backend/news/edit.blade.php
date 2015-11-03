@extends('admin.layouts.master')

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="col-sm-6">
			<h1>Creaza Stire/Declaratie</h1>
		</div>
	</div>
</div>

<hr>

<div class="row">
	<div class="col-md-12">
		<form class="form-horizontal" method="POST" action="/backend/news">
			<input name="_method" type="hidden" value="PUT"/>
			@include('admin.backend.news.form')
			<div class="form-group">
				<div class="col-sm-4" style="margin-top:25px;">
					<button class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span> Salveaza schimbari</button>
					<a href="{{ action('NewsController@index') }}"><button type="button" class="btn btn-info"><span class="glyphicon glyphicon-th-list"></span> Inapoi la lista</button></a>
				</div>
				<div class="col-sm-2 col-sm-offset-6" style="margin-top:25px;">
				<a href="{{ action("NewsController@destroy", [$stakeholder]) }}" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Sterge</a>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection