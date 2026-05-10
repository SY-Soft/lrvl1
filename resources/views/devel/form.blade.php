@extends('layouts.main')

@section('title', 'Devel')

@section('content')

    <div class="container">

        <h1>Devel</h1>

        <div class="row">

            <div class="col-md-6 offset-md-3">

                <h1>Devel tools</h1>

                @if(session('msg'))
                    <div class="alert alert-success">
                        {{ session('msg') }}
                    </div>
                @endif


                <form method="POST" action="{{ route('devel.go') }}">

                    @csrf

                    <div class="mb-3">
                        <label>Сколько сгенерировать</label>

                        <input type="number"
                               name="count"
                               value="100"
                               class="form-control"
                               style="width:150px;">
                    </div>

                    <button name="action" value="gen_users"
                            class="btn btn-primary">
                        Generate users
                    </button>

                    <button name="action" value="truncate_users"
                            class="btn btn-danger">
                        Delete all except #1
                    </button>
                    <br>
                    <button name="action" value="gen_news"
                            class="btn btn-primary">
                        Generate news
                    </button>

                    <button name="action" value="truncate_news"
                            class="btn btn-danger">
                        Delete all news
                    </button>

                </form>
            </div>

        </div>

    </div>

@endsection
