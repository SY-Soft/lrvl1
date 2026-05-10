@extends('layouts.main')

@section('title', 'Новости')

@section('content')
    <div class="container">


        <div class="row my-4">
                <h1>Новости</h1>
        </div>
        <div id="indexNews">

                @foreach ($news as $new)
                <div class="indexNews-item">
                    <div class="indexNews-image"><img src="{{ image_style($new->image, 'square_center') }}"></div>
                    <div class="indexNews-inner">
                        <div class="indexNews-title">{{ $new->title }}</div>
                        <div class="indexNews-autor-date">
                            <div class="indexNews-autor">{{ $new->user->name }}</div>
                            <div class="indexNews-date">date</div>
                        </div>
                        {{ $new->excerpt }}
                        <div class="indexNews-more-details">more details</div>
                    </div>
                </div>
                @endforeach
            {{ $news->links('pagination::bootstrap-5') }}
        </div>
    </div>

@endsection
