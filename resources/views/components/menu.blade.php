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
@can('create', \App\Models\News::class)

<li class="nav-item">
    <a class="nav-link" href="{{ route('news.admin_index') }}">Управление новостями</a>
</li>
@endcan

@can('devel-access')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('devel.index') }}">devel</a>
    </li>
@endcan
