@extends('layouts.main')

@section('title', 'Вход')

@section('content')

    <div class="container">

        <h1>Вход</h1>

        <div class="row">

            <div class="col-md-6 offset-md-3">

                <form action="{{ route('login.auth') }}" method="post">
                    @csrf


                    <div class="form-group my-2">
                        <label>E-mail</label>
                        <input type="email" name="email"
                               class="form-control" placeholder="E-mail">
                        @error('email')
                        <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group my-2">
                        <label>Пароль</label>
                        <input type="password" name="password" class="form-control" placeholder="Пароль">
                        @error('password')
                        <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group my-2 text-right">
                    <button class="btn btn-success">Войти</button>
                    </div>

                </form>

            </div>

        </div>

    </div>

@endsection
