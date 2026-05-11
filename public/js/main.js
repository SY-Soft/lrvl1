$(function(){
        $(document).on('click','.pagination a',function(e){

            e.preventDefault();

            let url = $(this).attr('href');

            if ($('#usersTable').length) {
                $('#usersTable').load(url + ' #usersTable > *');
            }

            if ($('#adminNewsTable').length) {
                $('#adminNewsTable').load(url + ' #adminNewsTable > *');
            }

            if ($('#indexNews').length) {
                $('#indexNews').load(url + ' #indexNews > *');
            }

        });

    $(document).ajaxStart(function(){ $('#globalLoader').removeClass('d-none'); });
    $(document).ajaxStop(function(){ $('#globalLoader').addClass('d-none'); });
    function showLoader() {
        $('#globalLoader').removeClass('d-none');
    }

    function hideLoader() {
        $('#globalLoader').addClass('d-none');
    }

    // $('body').on('click','.justify-content-between',function(e){ console.log('123'); })
    $('.justify-content-sm-between').on('click', function() {
        console.log('123');
    });

    //Ver#2
    $('.justify-content-sm-between').click(function() {
        console.log('456');
    });

    $(document).on('click','.justify-content-sm-between',function(e){

        console.log('789');

    });
});
