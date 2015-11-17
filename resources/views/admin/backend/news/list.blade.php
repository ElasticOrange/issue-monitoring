@extends('admin.layouts.master')

@section('content')

	<div class="row">
		<div class="col-lg-12 text-left">
			<h1 class="page-header">Stiri si declaratii</h1>
		</div>
	</div>

	<div class="row">
		<div class="form-group">
			<div class="col-md-2">
				<a href="/backend/news/create"><button class="btn btn-primary form-control"><span class="glyphicon glyphicon-plus"></span> Adauga</button></a>
			</div>
		</div>
	</div>

	<br>

	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="dataTable_wrapper">
						<table class="table table-striped table-bordered table-hover" data-table="true">
							<thead>
								<tr role="row">
									<th  class="text-center" style="width: 20px;">Id</th>
									<th  class="text-center" style="width: 480px;">Titlu</th>
									<th  class="text-center" style="width: 80x;">Data</th>
									<th  class="text-center" style="width: 80x;">Sursa</th>
									<th  class="text-center" style="width: 40px;">Taguri</th>
									<th  class="text-center" style="width: 80px;">Actiuni</th>
								</tr>
							</thead>
							<tbody>
								@foreach($news as $n)
									<tr class='gradeA odd' role="row">
										<td>{{ $n->id }}</td>
										<td>{{ $n->title }}</td>
										<td>{{ $n->date->format('d-m-Y') }}</td>
										<td>
											<a href="{{ $n->link }}" target="_blank">{{ $n->link }}</a>
										</td>
										<td>
											@foreach ($n->connectedTags as $tag)
												{{ $tag->name }}
											@endforeach
										</td>
										<td class="text-center">
											<a href="{{ action('NewsController@edit', [$n])}}" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span></a>
											<a href=" {{ action('NewsController@destroy', [$n]) }}" class="btn btn-danger delete-button"><span class="glyphicon glyphicon-trash"></span></a>
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
