@extends('admin.layouts.master')

@section('content')
	<div class="row">
		<div class="col-lg-12 text-left">
			<h1 class="page-header">Templates</h1>
		</div>
	</div>

	<div class="form-group">
		<a href="{{ action('FlowTemplateController@create') }}" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Adauga template</a>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="dataTable_wrapper">
						<table class="table table-striped table-bordered table-hover" data-table="true">
							<thead>
								<tr role="row">
									<th class="text-center" style="width: 10%;">Id</th>
									<th class="text-center" style="width: 60%;">Nume</th>
									<th class="text-center" style="width: 30%;">Actiuni</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($flowTemplates as $flowTemplate)
									<tr class="gradeA odd" role="row">
										<td>{{ $flowTemplate->id }}</td>
										<td>{{ $flowTemplate->name }}</td>
										</td>
										<td class="text-center">
										<div class="row">
											<a href="{{ action('FlowTemplateController@edit', [$flowTemplate])}}" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span></a>
											<a href=" {{ action('FlowTemplateController@destroy', [$flowTemplate]) }}" class="btn btn-danger delete-button"><span class="glyphicon glyphicon-trash"></span></a>
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

@section('js')
	<script type="text/javascript" src="/js/flowTemplate.js"></script>
@endsection
