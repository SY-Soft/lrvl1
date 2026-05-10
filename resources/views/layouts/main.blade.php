<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title')</title>

    <? /* <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" rel="stylesheet"> */ ?>
    <? /*
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    */ ?>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    @stack('scripts')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="/css/main.css" rel="stylesheet">
    <script src="/js/main.js"></script>


</head>

<body>

@include('components.header')

<main class="main-content">

    <div class="container">
        @if ($errors->any())

            <div class="row">

                <div class="col-md-12">
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>

            </div>
        @endif

        <div class="row">
<?php if(1==2) { ?>
            <div class="col-md-12">
                @yield('content')
            </div>
<?php } else { ?>
            @if(request()->routeIs('home'))
                <div class="col-md-8">
                    @yield('content')
                </div>
                <div class="col-md-4">
                    @include('news.latestnews.sidebar')
                </div>
            @else
                <div class="col-md-12">
                    @yield('content')
                </div>
            @endif
<?php } ?>
        </div>

    </div>

</main>

@include('components.footer')
<div id="globalLoader" class="sy-loader d-none">

    <div class="spinner-border text-light"></div>

</div>
</body>


</html>
