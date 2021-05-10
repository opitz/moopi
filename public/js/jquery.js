$( document ).ready(function() {
    console.log( "jQuery is ready!" );

    $("#testbutton").click(function(){
        alert("A testbutton was clicked.");
    });

    $('table').tablesorter();
});

