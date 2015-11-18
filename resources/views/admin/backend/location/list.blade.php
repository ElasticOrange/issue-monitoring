@extends('admin.layouts.master')

@section('content')
	<div class="row">
		<div class="col-lg-12 text-left">
			<h1 class="page-header">Locatii procedurale</h1>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-6">
							<input
								id="location-autocomplete"
								source-url="{{ action('LocationController@queryLocation') }}/?name={name}"
								type="text"
								placeholder="Cauta locatie"
								class="form-control"
							/>
						</div>
					</div>
					<br />

					<div class="row">
						<div class="col-lg-6">
							<button type="submit" class="btn btn-primary" id="addLocation" data-toggle="modal" data-modal="true" data-target="#myModal">
								<span class="glyphicon glyphicon-plus"></span> Adauga
							</button>
							<button type="submit" title="Edit" id="editLocation" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> Editeaza</button>
							<button id="deleteLocation" title="Delete" confirm="Stergi locatia selectata?" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Sterge</button>

							<!-- Modal -->
							<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
									</div>
								</div>
							</div>
						</div>
					</div>
					<br/>
					<div class="row">
						<div class="col-lg-3">
							<div id="locationTree"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('js')
	<script type="text/javascript" src="/js/locations.js"></script>
@endsection
