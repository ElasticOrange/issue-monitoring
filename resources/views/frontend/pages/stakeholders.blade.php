@extends('frontend.layout.master')

@section('content')

<div class="container white">
    @include('frontend.layout.header')
    <div class="row" style="margin-top: -20px;">
        <div class="col-md-8 col-md-offset-2">
            <h3>Stakeholderi</h3>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <ul>
                        @foreach($stakeholders as $stakeholder)
                            <li>
                                <a
                                    @if(\Auth::user() and ! empty($canSeeStakeholders))
                                        href="{{ action('HomeController@getStakeholderInfo', ['id' => $stakeholder->id, 'name' => Illuminate\Support\Str::slug($stakeholder->name)]) }}"
                                    @else
                                        href="{{ action('HomeController@getContact') }}"
                                    @endif
                                    title="{{ $stakeholder->name }}"
                                >
                                    {{ $stakeholder->name }}
                                </a>
                                <br>
                                @if($stakeholder->position)
                                    Pozitie si apartenenta: {{ strip_tags($stakeholder->position) }}
                                @endif
                            </li><br>
                        @endforeach
                    </ul>
                    {!! $stakeholders->render() !!}
                </div>
            </div>
        </div>
    </div>
    @include('frontend.layout.footer')
</div>

@endsection
