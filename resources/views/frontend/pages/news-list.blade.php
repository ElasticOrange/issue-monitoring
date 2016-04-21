@extends('frontend.layout.master')

@section('content')

    <div class="container white">
        @include('frontend.layout.header')
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h4>
                    Știri / declarații in care este menționat: <br><b>{{ $stakeholder->name }}</b>
                </h4>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @foreach($news as $n)
                    <ul>
                        <li>
                            {{ $n->date->format('d-m-Y') }}
                            <a href="{{ $n->link }}" target="_blank">
                                <b>{{ $n->title }}</b>
                            </a><br>
                            <span class="news-ellipsis">
                                {{ strip_tags($n->description) }}
                            </span>
                            <a href="{{ action('HomeController@getNewsInfo', ['id' => $n->id, 'name' => Illuminate\Support\Str::slug($n->title)])  }}" target="_blank">
                                Detalii
                            </a>
                        </li>
                    </ul>
                @endforeach
                {!! $news->render() !!}
            </div>
        </div>
        @include('frontend.layout.footer')
    </div>

@endsection
