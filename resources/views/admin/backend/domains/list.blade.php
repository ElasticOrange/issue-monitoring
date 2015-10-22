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
						<button type="button" class="btn btn-primary" data-toggle="modal" data-modal="true" data-target="#myModal">
							+ Adauga
						</button>
						<!-- Modal -->
						<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<form
											action="/backend/domain"
											method="post"
											data-ajax="true"
											success-message="Template created successfuly"
											error-message="Error creating template"
											success-function="addDomainToTree"
											>
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											<h4 class="modal-title" id="myModalLabel">Adauga Domeniu</h4>
										</div>
										<div class="modal-body">
											@include('admin.backend.domains.form')
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal">Inchide</button>
											<button type="submit" data-adauga="true" class="btn btn-primary">+ Adauga</button>
											<button type="submit" data-edit="true" class="btn btn-primary hidden">Editeaza</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-1">
						<form method="POST" action="{{ action('DomainController@destroy') }}" style="display: inline-block;">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input name="_method" type="hidden" value="DELETE">
							<input class="btn btn-danger" data-confirm="true" type="submit" value="Delete" style="width: 81px;">
						</form>
					</div>
				</div>
				<br /><br />
				<div class="row">
					<div class="col-lg-4">
						<div id="domainTree"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('js')
	<script src="{{ elixir('js/custom.js') }}"></script>
@endsection
