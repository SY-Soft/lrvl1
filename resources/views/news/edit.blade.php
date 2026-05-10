@extends('layouts.main')

@section('title', 'Редактировать новость')

@section('content')

    <div class="container">

        <h1>Редактировать "{{ $news->title }}"</h1>

        <div class="row">

            <div class="col-md-6 offset-md-3">

                <form action="{{ route('news.update', $news) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @include('news.form', ['new' => $news])


                    <div class="form-group my-2 text-right">
                        <button class="btn btn-success">Обновить</button>
                    </div>
                </form>

                <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

                <script>
                    ClassicEditor
                        .create(document.querySelector('#editor'))
                        .catch(error => console.error(error));
                </script>

            </div>

        </div>

    </div>

@endsection
