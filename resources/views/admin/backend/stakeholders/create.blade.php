@extends('admin.layouts.master')

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="col-sm-6">
			<h1>Creaza Stakeholder</h1>
		</div>
		<div class="col-sm-4 col-sm-offset-2" style="margin-top:25px;">
			<button class="btn btn-primary">Salveaza schimbari</button>
			<a href="/backend/stakeholders"<button class="btn btn-info">Inapoi la lista</button></a>
		</div>
	</div>
</div>

<hr>

<div class="row">
	<div class="col-md-12">
		<form class="form-horizontal" method="POST" action="/backend/stakeholder">
			@include('admin.backend.stakeholders.form')
			<div class="form-group">
    			<div class="col-sm-4" style="margin-top:25px;">
			        <button class="btn btn-primary">Salveaza schimbari</button>
			        <a href="/backend/stakeholders/"<button class="btn btn-info">Inapoi la lista</button></a>
    			</div>
			</div>
		</form>
	</div>
</div>

@endsection


@section('js')
    <script type="text/javascript" src="/js/stakeholders.js"></script>
@endsection
