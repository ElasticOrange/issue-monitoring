@extends('admin.layouts.master')

@section('content')

	<div class="row">
		<div class="col-lg-12 text-left">
			<h1 class="page-header">Stiri si decalratii</h1>
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
				<a href="/backend/news/create"><button class="btn btn-default form-control"><span class="glyphicon glyphicon-plus"></span> Adauga</button></a>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="dataTable_wrapper">
						<table class="table table-striped table-bordered table-hover dataTables-example">
							<thead>
								<tr role="row">
									<th  class="text-center" style="width: 180px;">Titlu</th>
									<th  class="text-center" style="width: 180x;">Data</th>
									<th  class="text-center" style="width: 180x;">Sursa</th>
									<th  class="text-center" style="width: 120px;">Taguri</th>
									<th  class="text-center" style="width: 200px;">Actiuni</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
