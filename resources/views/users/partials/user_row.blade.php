<tr data-user-id="{{ $user->id }}">

    <td class="text-center" style="width:40px">{{ $user->id }}</td>

    <td>
        {{ $user->name }} ({{ $user->getRoleName() }})
    </td>

    <td>{{ $user->email }}</td>

    <td class="text-nowrap">
        @can('devel-access')
            <a href="/devel/login/{{ $user->id }}" title="Авторизоваться как {{ $user->name }}"><i class="bi bi-box-arrow-in-right sy-user-op text-primary"></i></a>
        @endcan

        @can('promote', $user)
            <i class="bi bi-person-fill-up sy-user-op role-up text-success"
               data-id="{{ $user->id }}"
               role="button"
               title="Повысить"></i>
        @else
            <i class="bi bi-person-fill-up sy-user-op text-secondary"></i>
        @endcan
        @can('demote', $user)
            <i class="bi bi-person-fill-down sy-user-op role-down text-danger"
               data-id="{{ $user->id }}"
               role="button"
               title="Понизить"></i>
        @else
            <i class="bi bi-person-fill-down sy-user-op text-secondary"></i>
        @endcan
            @can('update', $user)
                <a href="/user/{{ $user->id }}/edit"><i class="bi bi-person-fill-gear sy-user-op" role="button" title="Редактировать"></i></a>
            @else
                <i class="bi bi-person-fill-gear sy-user-op text-secondary" role="button"></i>
            @endcan
            @can('delete', $user)
                <i class="bi bi-person-fill-slash sy-user-op text-danger delete-user" title="Удалить"
                   data-id="{{ $user->id }}"
                   data-name="{{ $user->name }}" role="button"></i>
            @else
                <i class="bi bi-person-fill-slash sy-user-op text-secondary" role="button"></i>
            @endcan

    </td>

</tr>
