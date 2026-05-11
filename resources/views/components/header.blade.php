<header class="main-header">
    <div class="container">
        <div class="row">
            <div class="col-2"><h1>lrvl1</h1></div>
            <div class="col-2">
                @auth
                    <p>
                        Привет, {{ auth()->user()->name }}
                    <br>
                        Вы {{ auth()->user()->getRoleName() }}
                    <br>
                        <a class="nav-link" href="{{ route('logout') }}">Выйти</a>
                    <p>

                @else
                    <p>
                        <a class="nav-link" href="{{ route('login') }}">войти</a>
                    </p>
                @endauth
            </div>
            <div class="col-8">
                @include('components.menu')

            </div>
        </div>


    </div>
</header>
