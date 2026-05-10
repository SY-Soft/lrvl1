@extends('layouts.main')

@section('title', 'Пользователи')

@section('content')
    @push('scripts')
        <script src="/js/users.js"></script>
    @endpush

    <div class="container">


        <div class="row my-4">
            <div class="col-4">
                <h1>Пользователи</h1>
            </div>
            <div class="col-8 text-right">
                @can('create', App\Models\User::class)
                    <a href="{{ route('user.create') }}" class="btn btn-primary">Создать</a>
                @else
                    <button class="btn btn-secondary" disabled>Создать</button>
                @endcan
            </div>
        </div>
        <div id="usersTable">

            @include('users.partials.table')

        </div>


    </div>

@endsection
