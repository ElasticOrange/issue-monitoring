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
					<table class="table table-striped table-bordered table-hover" id="dataTables-example">
						<thead>
							<tr role="row">
								<th style="width: 80px;">Id</th>
								<th style="width: 900px;">Content</th>
								<th style="width: 80px;">Document</th>
								<th style="width: 80px;">Link</th>
								<th style="width: 120px;">Data</th>
								<th style="width: 182px;">Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($document as $key=>$item)
								<tr class="gradeA odd" role="row">
									<td class="sorting_1">{{ $key + 1 }}</td>
									<td>{{ $item->description }}</td>
									<td class="text-center">
										@if(!empty($item->file_name))
											<a href="/document/{{ $item->file_name }}" target="_blank">
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
									<td class="center">{{ $item->init_at->format('d-m-Y') }}</td>
									<td>
										<a href="/backend/document/{{ $item->id }}/edit" class="btn btn-primary" style="width: 81px;">Edit</a>
										<form method="POST" action="/backend/document/{{ $item->id }}" style="display: inline-block;">
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
		</div>
	</div>
</div>

<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
                responsive: true
        });
    });
</script>
@endsection