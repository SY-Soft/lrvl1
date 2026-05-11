<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <div class="navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">Главная</a>
                </li>
                @can('viewAny', \App\Models\User::class)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('users.index') }}">Пользователи</a>
                    </li>
                @endcan
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('news.index') }}">Новости</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('news.admin_index') }}">admin news</a>
                </li>
                @can('devel-access')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('devel.index') }}">devel</a>
                    </li>
                @endcan


            </ul>
        </div>
    </div>
</nav>
<button class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarSupportedContent">

    <span class="navbar-toggler-icon"></span>
</button>
