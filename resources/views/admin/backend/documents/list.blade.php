@extends('admin.layouts.master')

@section('content')
<div class="row">
	<div class="col-lg-12 text-left">
		<h1 class="page-header">Documente</h1>
	</div>
</div>

<div class="form-group">
	<a href="{{ action('DocumentController@create') }}" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Adauga Document</a>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="dataTable_wrapper">
					<table class="table table-striped table-bordered table-hover" data-table="true">
						<thead>
							<tr role="row">
								<th style="width: 200px;">Titlu</th>
								<th style="width: 80px;">Document</th>
								<th style="width: 80px;">Link</th>
								<th style="width: 120px;">Data</th>
								<th style="width: 182px;">Actiuni</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($documents as $item)
								<tr class="gradeA odd" role="row">
									<td>{{ $item->title }}</td>
									<td class="text-center">
										@if($item->file)
											<a href="{{ action('UploadedFileController@downloadFile', [$item->file->file_name]) }}" target="_blank" title="{{ $item->file->original_file_name }}">
												<i class="fa fa-file-pdf-o fa-lg"></i>
											</a>
										@endif
									</td>
									<td class="text-center">
										@if($item->public_code)
											<a href="{{ action('DocumentController@show', [$item->public_code]) }}" target="_blank" title="{{ action('DocumentController@show', [$item->public_code]) }}">
												<i class="fa fa-external-link fa-lg"></i>
											</a>
										@endif
									</td>
									<td class="center">{{ $item->init_at->format('d-m-Y') }}</td>
									<td class="text-center">
										<a href="{{ action('DocumentController@edit', [$item]) }}" title="Edit" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span></a>
										<a href="{{ action('DocumentController@destroy', [$item]) }}" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
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
	<script type="text/javascript" src="/js/documents.js"></script>
@endsection
