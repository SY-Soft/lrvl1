@extends('layouts.main')

@section('title', 'Новости')

@section('content')
    @push('scripts')
        <script src="/js/news.js"></script>
    @endpush
    <div class="container">


        <div class="row my-4">
            <div class="col-4">
                <h1>Новости</h1>
            </div>
            <div class="col-8 text-right">
                <? /* ?>
                <a href="{{ route('news.create') }}" class="btn btn-primary">Создать</a>
                <? */ ?>
                @can('create', App\Models\News::class)
                    <a href="{{ route('news.create') }}" class="btn btn-primary">Создать</a>
                @else
                    <button class="btn btn-secondary" disabled>Создать</button>
                @endcan
            </div>
        </div>
        <div id="adminNewsTable">

            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Автор</th>
                    <th scope="col">Заголовок</th>
                    <th scope="col">Тизер</th>
                    <th scope="col">Ссылка</th>
                    <th scope="col">...</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($news as $new)

                    <tr data-new-id="{{ $new->id }}">

                        <td class="text-center" style="width:40px">{{ $new->id }}</td>
                        <td>{{ $new->user->name }}</td>
                        <td>{{ $new->title }}</td>
                        <td>{{ $new->excerpt }}</td>
                        <td>
                            <a href="{{ route('news.show', $new->slug) }}" target="_blank">
                                {{ $new->title }}
                            </a>
                        </td>
                        <td>
                            @can('update', $new)
                                    <a href="/admin/news/{{ $new->id }}/edit"><i class="bi bi-pencil-square sy-user-op" role="button" title="Редактировать"></i></a>
                                @else
                                    <i class="bi bi-pencil-square sy-user-op text-secondary" role="button"></i>
                                @endcan
                                @can('delete', $new)
                                    <i class="bi bi-trash sy-user-op text-danger delete-news" title="Удалить"
                                       data-id="{{ $new->id }}"
                                       data-title="{{ $new->title }}" role="button"></i>
                                @else
                                    <i class="bi bi-trash sy-user-op text-secondary" role="button"></i>
                                @endcan
                        </td>

                    </tr>

                @endforeach
                </tbody>
            </table>
            {{ $news->links('pagination::bootstrap-5') }}
            <div class="modal fade" id="deleteModal">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title">Удаление новости</h5>
                        </div>

                        <div class="modal-body">
                            Удалить новость <b id="deleteNewsTitle"></b> ?
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                            <button class="btn btn-danger" id="confirmDelete" data-id2del="0">Удалить</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
