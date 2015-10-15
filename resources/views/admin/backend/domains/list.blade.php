@extends('admin.layouts.master')

@section('content')
<div class="row">
	<div class="col-lg-12 text-center">
		<h1 class="page-header">Domenii</h1>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-6">
						<input type="search" class="form-control" placeholder="Search here">
					</div>
					<div class="col-lg-1 col-lg-offset-4">
						<a href="/backend/domain//edit" class="btn btn-primary" style="width: 81px;">Edit</a>
					</div>
					<div class="col-lg-1">
						<form method="POST" action="/backend/domain/" style="display: inline-block;">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input name="_method" type="hidden" value="DELETE">
							<input class="btn btn-danger" data-confirm="true" type="submit" value="Delete" style="width: 81px;">
						</form>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-4">
						<div id="domaintree"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection