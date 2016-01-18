@extends('admin.layouts.master')

@section('content')
    @if($alert->alertable_type == 'Issue\News')
        {{ $alert->alertable->title }}
    @elseif($alert->alertable_type == 'Issue\Issue')
        {{ $alert->alertable->name }}
    @elseif($alert->alertable_type == 'Issue\FlowStep')
        {{ $alert->alertable->flow_name }}
    @elseif($alert->alertable_type == 'Issue\Report')
        Report surprize
    @endif
@endsection