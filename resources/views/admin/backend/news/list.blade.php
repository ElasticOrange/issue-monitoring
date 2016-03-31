@extends('admin.layouts.master')

@section('content')
	@include('admin.backend.issues.action_buttons', ['controller' => 'NewsController'])
	@include('admin.backend.news.external_link')

	<div class="row">
		<div class="col-lg-12 text-left">
			<h1 class="page-header">Stiri si declaratii</h1>
		</div>
	</div>

	<div class="row">
		<div class="form-group">
			<div class="col-md-2">
				<a href="/backend/news/create"><button class="btn btn-primary form-control"><span class="glyphicon glyphicon-plus"></span> Adauga</button></a>
			</div>
		</div>
	</div>

	<br>

	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="dataTable_wrapper">
						<table class="table table-striped table-bordered table-hover" data-table="true" id="news-table">
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('js')
	<script type="text/javascript" src="/js/news.js"></script>
@endsection