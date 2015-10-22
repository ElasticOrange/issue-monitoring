@extends('admin.layouts.master')

@section('content')

	<div class="row">
		<div class="col-lg-12 text-left">
			<h1 class="page-header">Stakeholderi</h1>
		</div>
	</div>

	<div class="row">
		<div class="form-group">
			<div class="col-lg-10">
				<div class="input-group">
					<input type="text" class="form-control" placeholder="Search for...">
					<span class="input-group-btn">
						<button class="btn btn-default" type="button">Go!</button>
					</span>
				</div>
			</div>
			<div class="col-lg-2">
				<a href="/backend/stakeholder/create"><button class="btn btn-default form-control"><span class="glyphicon glyphicon-plus"></span> Adauga</button></a>
			</div>
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
									<th  class="text-center" style="width: 180px;">Publicat</th>
									<th  class="text-center" style="width: 200px;">Actiuni</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($stakeholders as $stakeholder)
									<tr class="gradeA odd" role="row">
										<td>{{ $stakeholder->name }}</td>
										<td>{{ $stakeholder->contact }}</td>
										<td>{{ $stakeholder->type }}</td>
										<td></td>
										<td class="text-center"><input type="checkbox" name="published" data-id="{{ $stakeholder->id }}" data-action="publish-stakeholder"/></td>
										<td class="text-center">
										<div class="row">
											<a href="{{ action('StakeholderController@edit', [$stakeholder])}}" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span></a>
											<a href=" {{ action('StakeholderController@destroy', [$stakeholder]) }}" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
										</div>
										</td>
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
