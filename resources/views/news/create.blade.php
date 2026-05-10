@extends('layouts.main')

@section('title', 'Создать новость')

@section('content')

    <div class="container">

        <h1>Создать новость</h1>

        <div class="row">

            <div class="col-md-6 offset-md-3">

                <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @include('news.form')

                    <button type="submit" class="btn btn-primary">Создать</button>
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
