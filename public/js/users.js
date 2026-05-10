console.log('user.js');
let deleteUserId = null;

$(document).on('click', '.delete-user', function () {

    deleteUserId = $(this).data('id');

    $('#deleteUserName').text($(this).data('name'));
/*
*/
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));

    $('#confirmDelete').data('id2del', deleteUserId);
    console.log($(this).data('id'));
    modal.show();
});
$(document).on('click', '#confirmDelete', function () {

    console.log(deleteUserId);
    console.log($('meta[name="csrf-token"]').attr('content'));

    $.ajax({
        url: '/user/' + deleteUserId,
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

/*
$(document).on('click', '.role-up, .role-down', function () {

    const userId = $(this).data('id');
    const direction = $(this).hasClass('role-up') ? 'up' : 'down';

    $.ajax({
        url: '/user/' + userId + '/role',
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            direction: direction
        },
        success: function () {

            location.reload(); // пока тупо обновим

        }
    });

});
*/
$(document).on('click', '.role-up, .role-down', function () {

    const userId = $(this).data('id');
    const direction = $(this).hasClass('role-up') ? 'up' : 'down';

    const row = $('tr[data-user-id="'+userId+'"]');

    $.ajax({

        url: '/user/' + userId + '/role',

        type: 'POST',

        data: {

            _token: $('meta[name="csrf-token"]').attr('content'),
            direction: direction

        },

        success: function (html) {

            row.replaceWith(html);
            const newRow = $('tr[data-user-id="'+userId+'"]');

            newRow.addClass('row-updated');

            setTimeout(function () {
                newRow.removeClass('row-updated');
            }, 2000);

        }

    });

});
