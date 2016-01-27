@extends('admin.layouts.master')

@section('content')
<div class="row">
    <div class="col-lg-12 text-left">
        <h1 class="page-header">Rapoarte</h1>
    </div>
</div>

@foreach($reports as $report)
{{ $report }}
@endforeach
@stop