@extends('frontend.layout.master')

@section('content')

    <div class="container white">
        @include('frontend.layout.header')
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h4>
                    @if($stakeholder->name)
                    Stakeholderi conectați: <br><b>{{ $stakeholder->name }}</b>
                    @endif
                    @if($stakeholder->org_name)
                    Stakeholderi conectați: <br><b>{{ $stakeholder->org_name }}</b>
                    @endif
                </h4>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @foreach($stakeholders as $s)
                    <ul>
                        <li>
                            <a
                                @if(\Auth::user()->can_see_stakeholders == true)
                                    href="{{ action('HomeController@getStakeholderInfo', ['id' => $s->id, 'name' => Illuminate\Support\Str::slug($s->name)]) }}"
                                @else
                                    href="{{ action('HomeController@getContact') }}"
                                @endif
                                title="{{ $s->name }}"
                            >
                                {{ $s->name }}
                            </a>
                            <br>
                            @if($s->position)
                                Pozitie si apartenenta: {{ strip_tags($s->position) }}
                            @endif
                        </li><br>
                    </ul>
                @endforeach
                {!! $stakeholders->render() !!}
            </div>
        </div>
        @include('frontend.layout.footer')
    </div>

@endsection
