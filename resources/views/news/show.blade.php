@extends('layouts.main')

@section('title', 'Новость: '.$news->title)

@section('content')

    <div class="container">

        <h1>{{ $news->title }}</h1>

        <div class="row">
            @if(!$news->published)
                <div class="col-12 text-center bg-danger bg-opacity-50 p-2 fs-3">Не опубликовано</div>
                <div class="col-12 bg-warning bg-opacity-10 p-3">
                    @else
                        <div class="col-12">
                            @endif
                            <div class="body-full">

                            @if($news->image)
                                <a href="{{ asset('storage/'.$news->image) }}" data-fancybox="gallery"
                                   class="fancybox-zoom main-image">
                                    <img src="{{ image_style($news->image, 'square_center') }}">
                                </a>
                            @else
                                <img src="{{ image_style('', 'square_center') }}" class="main-image">
                            @endif


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
