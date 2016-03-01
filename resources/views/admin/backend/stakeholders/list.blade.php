@extends('admin.layouts.master')

@section('content')
	@include('admin.backend.issues.action_buttons', ['controller' => 'StakeholderController'])
	<div class="row">
		<div class="col-lg-12 text-left">
			<h1 class="page-header">Stakeholderi</h1>
		</div>
	</div>

	<div class="form-group">
		<a href="/backend/stakeholder/create" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Adauga stakeholder</a>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="dataTable_wrapper">
						<table class="table table-striped table-bordered table-hover" data-table="true" id="stakeholders-table">
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('js')
	<script type="text/javascript" src="/js/stakeholders.js"></script>
@endsection
