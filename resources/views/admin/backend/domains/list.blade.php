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
						<br />
					</div>
					<div class="col-lg-6">
						<button type="submit" class="btn btn-primary" id="addDomain" data-toggle="modal" data-modal="true" data-target="#myModal">
							<span class="glyphicon glyphicon-plus"></span> Adauga
						</button>
						<button type="submit" title="Edit" id="editDomain" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> Editeaza</button>
						<button id="deleteDomain" title="Delete" confirm="Stergi domeniul selectat?" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Sterge</button>

						<!-- Modal -->
						<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6">
						<div id="domainTree"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('js')
    <script type="text/javascript" src="/js/domains.js"></script>
@endsection
