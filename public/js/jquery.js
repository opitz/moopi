$( document ).ready(function() {
    console.log( "jQuery is ready!" );

    toggle_description();

    $('#testbutton').click(function(){
        alert("A testbutton was clicked.");
    });

    $('#import_data').click(function(){
        $('#waiting').show();
    });


    $('table').tablesorter();

    $('input:checkbox').click(function(){
        if ($('input:checkbox:checked').length) {
            $('#delete-selected-commits').removeClass('disabled');
        } else {
            $('#delete-selected-commits').addClass('disabled');
        }
    })

    $('.top-menu').each(function() {
        if ($(this).html().indexOf($('#title').html()) > -1) {
            $(this).css('font-weight', 'bold');
        }
    })

});

function filter() {
    $filter = $('#filter').val();
    $counter = 0;

    $('.plugin').each(function(){
        if ($(this).text().indexOf($filter) == -1) {
            $(this).hide();
        } else {
            $(this).show();
            $counter++;
        }
    })
    $all = $('.plugin').length
    if ($counter == $all) {
        $text = $counter;
    } else {
        $text = $counter + " of " + $all;
    }

    $('#plugins_number').html($text);
}

function toggle_description() {
    $('#toggle_description').on('click', function() {
        if ($('#toggle_description').hasClass('hide_description')) {
            $('#toggle_description').addClass('show_description');
            $('#toggle_description').removeClass('hide_description');
            $('.col_description').hide();
            $('#toggle_description').html('Show Description');
        } else {
            $('#toggle_description').addClass('hide_description');
            $('#toggle_description').removeClass('show_description');
            $('.col_description').show();
            $('#toggle_description').html('Hide Description');
        }
    });

}