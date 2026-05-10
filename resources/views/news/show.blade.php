@extends('layouts.main')

@section('title', 'Новость: '.$news->title)

@section('content')

    <div class="container">

        <h1>{{ $news->title }}</h1>

        <div class="row">

            <div class="col-12">

@if($news->image)
                    <a href="{{ asset('storage/'.$news->image) }}" data-fancybox="gallery" class="fancybox-zoom">
                        <img src="{{ image_style($news->image, 'square_center') }}">
                    </a>
@endif

<div>
    {!! $news->body !!}
</div>

<hr>

<small>
    Автор: {{ $news->user->name }} |
    Дата: {{ $news->created_at }}
</small>

            </div>

        </div>

    </div>

@endsection
