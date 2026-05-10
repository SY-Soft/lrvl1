
<table class="table table-striped table-hover">
    <thead>
    <tr>
        <th scope="col" class="text-center" >#</th>
        <th scope="col">Имя</th>
        <th scope="col">E-mail</th>
        <th scope="col">...</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($users as $user)

        @include('users.partials.user_row', ['user'=>$user])


    @endforeach
    </tbody>
</table>

{{ $users->links('pagination::bootstrap-5') }}
<div class="modal fade" id="deleteModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Удаление пользователя</h5>
            </div>

            <div class="modal-body">
                Удалить пользователя <b id="deleteUserName"></b> ?
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                <button class="btn btn-danger" id="confirmDelete" data-id2del="0">Удалить</button>
            </div>

        </div>
    </div>
</div>
