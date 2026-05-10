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

$(document).on('click', '#confirmDelete', function () {

    console.log(deleteNewsId);
    console.log($('meta[name="csrf-token"]').attr('content'));

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


