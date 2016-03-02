@extends('admin.layouts.master')

@section('content')
	@include('admin.backend.issues.action_buttons', ['controller' => 'DocumentController'])
	@include('admin.backend.documents.download-file', ['controller' => 'DocumentController'])
	@include('admin.backend.documents.external_link')
	<div class="row">
		<div class="col-lg-12 text-left">
			<h1 class="page-header">Documente</h1>
		</div>
	</div>

	<div class="form-group">
		<a href="{{ action('DocumentController@create') }}" class="btn btn-primary">
			<span class="glyphicon glyphicon-plus">
			</span> Adauga Document
		</a>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="dataTable_wrapper">
						<table class="table table-striped table-bordered table-hover" data-table="true" id="documents-table">
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('js')
	<script type="text/javascript" src="/js/documents.js"></script>
@endsection
