@extends('admin.layouts.master')

@section('content')

	<div class="row">
		<div class="col-lg-12 text-left">
			<h1 class="page-header">Stakeholderi</h1>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-10">
			<div class="input-group">
				<input type="text" class="form-control" placeholder="Search for...">
				<span class="input-group-btn">
					<button class="btn btn-default" type="button">Go!</button>
				</span>
			</div>
		</div>
		<div class="col-lg-2">
			<a href="/backend/stakeholders/create"<button class="btn btn-default form-control"><span class="glyphicon glyphicon-plus"></span> Adauga</button></a>
		</div>
	</div>

	<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="dataTable_wrapper">
					<table class="table table-striped table-bordered table-hover" id="dataTables-example">
						<thead>
							<tr role="row">
								<th  class="text-center" style="width: 180px;">Nume</th>
								<th  class="text-center" style="width: 180x;">Contact</th>
								<th  class="text-center" style="width: 180x;">Organizatie</th>
								<th  class="text-center" style="width: 120px;">Foto</th>
								<th  class="text-center" style="width: 180px;"></th>
								<th  class="text-center" style="width: 200px;">Actiuni</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($stakeholders as $stakeholder=>$item)
								<tr class="gradeA odd" role="row">
									<td>{{ $item->name }}</td>
									<td>{{ $item->contact }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection