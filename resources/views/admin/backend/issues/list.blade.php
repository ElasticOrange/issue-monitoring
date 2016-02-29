@extends('admin.layouts.master')

@section('content')
	@include('admin.backend.issues.action_buttons', ['controller' => 'IssueController'])

	<div class="row">
		<div class="col-lg-12 text-left">
			<h1 class="page-header">Initiative</h1>
		</div>
	</div>

	<div class="form-group">
		<a href="/backend/issue/create" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Adauga initiativa</a>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="dataTable_wrapper">
						<table class="table table-striped table-bordered table-hover" id="issues-table" data-table="true">
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('js')
	<script type="text/javascript" src="/js/issues.js"></script>
@endsection
