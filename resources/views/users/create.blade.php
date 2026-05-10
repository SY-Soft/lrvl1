@extends('layouts.main')

@section('title', 'Новый пользователь')

@section('content')

    <div class="container">

        <h1>Новый пользователь</h1>

        <div class="row">

            <div class="col-md-6 offset-md-3">

                <form action="{{ route('user.store') }}" method="post">
                    @csrf


                    @include('users.form')

                    <div class="form-group my-2 text-right">
                        <button class="btn btn-success">Создать</button>
                    </div>
                </form>

            </div>

        </div>

    </div>

@endsection
