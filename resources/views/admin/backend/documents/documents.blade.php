@extends('admin.layouts.master')

@section('content')
<div class="row">
	<div class="col-lg-12 text-center">
		<h1 class="page-header">Tables</h1>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<!-- <div class="panel-heading">
				DataTables Advanced Tables
			</div> -->
			<div class="panel-body">
			<div class="dataTable_wrapper">
				<div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
					<div class="row">
						<div class="col-sm-6">
							<div class="dataTables_length" id="dataTables-example_length">
							<label>
								Show
								<select name="dataTables-example_length" aria-controls="dataTables-example" class="form-control input-sm">
									<option value="10">10</option>
									<option value="25">25</option>
									<option value="50">50</option>
									<option value="100">100</option>
								</select>
								entries
							</label>
							</div>
						</div>
						<div class="col-sm-6">
							<div id="dataTables-example_filter" class="dataTables_filter">
								<label>
									Search:
									<input type="search" class="form-control input-sm" placeholder="" aria-controls="dataTables-example">
								</label>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<table class="table table-striped table-bordered table-hover dataTable no-footer" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info">
								<thead>
									<tr role="row">
										<th class="sorting_desc" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 80px;">Id</th>
										<th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 900px;">Content</th>
										<th tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending" style="width: 80px;">Document</th>
										<th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending" style="width: 80px;">Link</th>
										<th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" style="width: 120px;">Data</th>
										<th tabindex="0" rowspan="1" colspan="1" style="width: 182px;">Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($document as $item)
										<tr class="gradeA odd" role="row">
											<td class="sorting_1">{{ $item->id }}</td>
											<td>{{ $item->proposalid }}</td>
											<td class="text-center">
												@if(!empty($item->filespath))
													<a href="/get/document/{{ $item->filespath }}" target="_blank">
														<i class="fa fa-file-pdf-o"></i>
													</a>
												@endif
											</td>
											<td class="text-center">
												@if(!empty($item->link))
													<a href="http://{{ $item->link }}" target="_blank">
														<i class="fa fa-external-link"></i>
													</a>
												@endif
											</td>
											<td class="center">{{ $item->initat }}</td>
											<td>
												<a href="/backend/document/{{ $item->id }}/edit">
													<button type="button" class="btn btn-warning" style="width: 81px;">Edit</button>
												</a>
												<form method="POST" action="/backend/document/{{ $item->id }}">
													<input type="hidden" name="_token" value="{{ csrf_token() }}">
													<input name="_method" type="hidden" value="DELETE">
													<input class="btn btn-danger" data-confirm="true" type="submit" value="Delete" style="width: 81px;">
												</form>
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="dataTables_info" id="dataTables-example_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div>
						</div>
						<div class="col-sm-6">
							<div class="dataTables_paginate paging_simple_numbers" id="dataTables-example_paginate">
								<ul class="pagination">
									<li class="paginate_button previous disabled" aria-controls="dataTables-example" tabindex="0" id="dataTables-example_previous">
										<a href="#">Previous</a>
									</li>
									<li class="paginate_button active" aria-controls="dataTables-example" tabindex="0">
										<a href="#">1</a>
									</li>
									<li class="paginate_button " aria-controls="dataTables-example" tabindex="0">
										<a href="#">2</a>
									</li>
									<li class="paginate_button " aria-controls="dataTables-example" tabindex="0">
										<a href="#">3</a>
									</li>
									<li class="paginate_button " aria-controls="dataTables-example" tabindex="0">
										<a href="#">4</a>
									</li>
									<li class="paginate_button " aria-controls="dataTables-example" tabindex="0">
										<a href="#">5</a>
									</li>
									<li class="paginate_button " aria-controls="dataTables-example" tabindex="0">
										<a href="#">6</a>
									</li>
									<li class="paginate_button next" aria-controls="dataTables-example" tabindex="0" id="dataTables-example_next">
									<a href="#">Next</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('js')
<script src="/js/deleteDocument.js"></script>
@endsection