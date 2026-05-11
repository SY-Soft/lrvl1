console.log('news.js');
let deleteNewsId = null;

$(document).on('click', '.delete-news', function () {

    deleteNewsId = $(this).data('id');

    $('#deleteNewsTitle').text($(this).data('title'));
/*
*/
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));

    $('#confirmDelete').data('id2del', deleteNewsId);
    console.log($(this).data('id'));
    modal.show();
});

$(document).on('click', '.publish_news', function () {

    const btn = $(this);
    const NewsId = btn.data('id');
    const newState = btn.data('set');   // 1 = опубликовать, 0 = снять

    $.ajax({
        url: `/admin/news/${NewsId}/publish`,
        method: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {

            const row = btn.closest('tr'); // или .news-row, если используешь div

            // Меняем иконку и data-атрибуты
            if (response.published) {
                btn.removeClass('bi-square text-primary')
                    .addClass('bi-check-square-fill text-success')
                    .attr('title', 'Снять с публикации')
                    .data('set', 0);
            } else {
                btn.removeClass('bi-check-square-fill text-success')
                    .addClass('bi-square text-primary')
                    .attr('title', 'Опубликовать')
                    .data('set', 1);
            }

            // Красивая анимация строки
            row.addClass('table-success');
            setTimeout(() => {
                row.removeClass('table-success');
            }, 800);
        },
        error: function (xhr) {
            alert('Ошибка: ' + (xhr.responseJSON?.message || 'Не удалось изменить статус'));
        }
    });
});

$(document).on('click', '#confirmDelete', function () {
    $.ajax({
        url: '/admin/news/' + deleteNewsId,
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            _method: 'DELETE'
        },
        success: function () {

            location.reload();

        }
    });

});


