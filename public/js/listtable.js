$( document ).ready(function() {
    console.log( "jQuery in listtable is ready!" );

    $('#testbutton').click(function(){
        alert("A testbutton was clicked.");
    });

});

function filter1() {
    $filter = $('#filter').val();
    $counter = 0;
    $('.install_path').each(function() {
        if ($(this).text().indexOf($filter) == -1) {
            $(this).closest('.plugin').hide();
        } else {
            $(this).closest('.plugin').show();
            $counter++;
        }
    })
    $('#plugins_number').html($counter);
}

function filter() {
    $filter = $('#filter').val();
    $counter = 0;

    $('.plugin').each(function(){
        if ($(this).text().indexOf($filter) == -1) {
            $(this).hide();
        } else {
            $(this).show();
            console.log($(this).text());
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
