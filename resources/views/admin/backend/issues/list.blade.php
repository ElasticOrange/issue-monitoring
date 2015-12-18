@extends('admin.layouts.master')

@section('content')
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
						<table class="table table-striped table-bordered table-hover" data-table="true">
							<thead>
								<tr role="row">
									<th class="text-center" style="width: 5%;">Id</th>
									<th class="text-center" style="width: 10%;">Domeniu - subdomeniu</th>
									<th class="text-center" style="width: 10%;">Categorie</th>
									<th class="text-center" style="width: 10%;">Tip</th>
									<th class="text-center" style="width: 50%;">Nume</th>
									<th class="text-center" style="width: 5%;">Status</th>
									<th class="text-center" style="width: 5%;">Publicat</th>
									<th class="text-center" style="width: 5%;">Actiuni</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($issues as $issue)
									<tr class="gradeA odd" role="row">
										<td>{{ $issue->id }}</td>
										<td>
											@foreach ($issue->connectedDomains as $domain)
												{{ $domain->name }}
											@endforeach
										</td>
										<td></td>
										<td></td>
										<td>{{ $issue->name }}</td>
										<td>{!! $issue->status !!}</td>
										<td class="text-center">
											<input  type="checkbox"
													name="published"
													data-id="{{ $issue->id }}"
													data-action="publish-issue"
													update-url="{{ action("IssueController@setPublished",[$issue]) }}"
													@if($issue->published) checked="checked" @endif
											/>
										</td>
										<td class="text-center">
										<div class="row">
											<a href="{{ action('IssueController@edit', [$issue])}}" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span></a>
											<a href=" {{ action('IssueController@destroy', [$issue]) }}" class="btn btn-danger delete-button"><span class="glyphicon glyphicon-trash"></span></a>
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
	<script type="text/javascript" src="/js/issues.js"></script>
@endsection
