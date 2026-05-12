<header class="main-header">

    {{-- DESKTOP NAVBAR --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3 d-none d-lg-block">
        <div class="container">

            <a class="navbar-brand fw-bold" href="/">
                lrvl1
            </a>

            <div class="d-flex align-items-center ms-auto">

                {{-- DESKTOP MENU --}}
                <ul class="navbar-nav me-4">

                    @include('components.menu')

                </ul>

                {{-- DESKTOP AUTH --}}
                <div class="text-white small text-end">
                @auth
                        <div>Привет, {{ auth()->user()->name }}</div>
                        <div class="text-secondary">{{ auth()->user()->getRoleName() }}</div>

                        <div>
                            <a class="text-decoration-none text-warning"
                               href="{{ route('logout') }}">
                                Выйти
                            </a>
                        </div>
                @else
                        <div>
                            <a class="text-decoration-none text-warning"
                               href="{{ route('login') }}">
                                Войти
                            </a>
                        </div>
                @endauth
            </div>

            </div>

        </div>
    </nav>

    {{-- MOBILE NAVBAR --}}
    <nav class="navbar navbar-dark bg-dark py-3 d-lg-none">
        <div class="container">

            <a class="navbar-brand fw-bold" href="/">
                lrvl1
            </a>

            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="offcanvas"
                data-bs-target="#mobileMenu"
            >
                <span class="navbar-toggler-icon"></span>
            </button>

        </div>
    </nav>

    {{-- MOBILE OFFCANVAS --}}
    <div class="offcanvas offcanvas-end text-bg-dark"
         tabindex="-1"
         id="mobileMenu">

        <div class="offcanvas-header">

            <h5 class="offcanvas-title">
                Меню
            </h5>

            <button
                type="button"
                class="btn-close btn-close-white"
                data-bs-dismiss="offcanvas">
            </button>

        </div>

        <div class="offcanvas-body">

            {{-- MOBILE AUTH --}}
            <div class="mb-4 border-bottom pb-3">
                @auth
                    <div>Привет, {{ auth()->user()->name }}</div>
                    <div class="text-secondary small">{{ auth()->user()->getRoleName() }}</div>

                    <div class="mt-2">
                        <a class="text-warning text-decoration-none"
                           href="{{ route('logout') }}">
                            Выйти
                        </a>
                    </div>
                @else
                    <div class="mt-2">
                        <a class="text-warning text-decoration-none"
                           href="{{ route('login') }}">
                            Войти
                        </a>
                    </div>
                @endauth
            </div>

            {{-- MOBILE MENU --}}
            <ul class="navbar-nav">

                @include('components.menu')
            </ul>

        </div>

    </div>

</header>
