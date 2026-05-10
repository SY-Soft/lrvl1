@extends('layouts.main')

@section('title', 'Новый пользователь')

@section('content')

    <div class="container">

        <h1>Редактировать {{ $user->name }}</h1>

        <div class="row">

            <div class="col-md-6 offset-md-3">

                <form action="{{ route('user.update', $user) }}" method="post">
                    @csrf
                    @method('PUT')
                    @include('users.form', ['user' => $user])
                    <div class="form-group my-2 text-right">
                    <button class="btn btn-success">Обновить</button>
                    </div>
                </form>

            </div>

        </div>

    </div>

@endsection
