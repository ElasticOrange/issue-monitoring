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
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
							+ Adauga
						</button>
						<!-- Modal -->
						<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<form action="/backend/domain" method="post" data-form="true">
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
						<div id="jqxTree"></div>
						<input type="button" style="margin: 10px;" id="jqxbutton" value="Get item" />
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('js')
<script type="text/javascript">
	$(document).ready(function () {
		var tree = $('#jqxTree');
		var source = null;
		$.ajax({
			async: false,
			url: "/getTree",
			success: function (data, status, xhr) {
				source = (data);
			}
		});

		var dataAdapter = new $.jqx.dataAdapter(source);
		dataAdapter.dataBind();
		var records = dataAdapter.getRecordsHierarchy('id', 'parent_id', 'items', [{ name: 'name', map: 'label' }]);
		console.log(records);
		tree.jqxTree({ source: records });
//		tree.jqxTree({ source: source,  height: 300, width: 200 });
	});

</script>
@endsection