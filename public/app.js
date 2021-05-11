//require('./bootstrap');

function filter_path() {
    // Declare variables
    var input, filter, ul, li, a, i, txtValue;
    input = document.getElementById('filter');
    filter = input.value;

    var counter = document.getElementsByClassName("install_path").length;

    // Loop through all install paths
    // hide those where the plugin install path do not match the filter query
    // and show those where the filter query matches
    var showing = 0;
    for (i = 0; i < counter; i++) {
        var pathelement = document.getElementsByClassName("install_path")[i];
        var path = pathelement.getElementsByTagName("a")[0].innerHTML;
        if (path.indexOf(filter) == -1) {
            pathelement.parentNode.style.display = "none";
        } else {
            pathelement.parentNode.style.display = "table-row";
            showing++;
        }
    }
    document.getElementById('plugins_number').innerHTML = showing;

}

function filter_commit_path() {
    // Declare variables
    var input, filter, ul, li, a, i, txtValue;
    input = document.getElementById('filter');
    filter = input.value;

    var counter = document.getElementsByClassName("install_path").length;

    // Loop through all install paths
    // hide those where the plugin install path do not match the filter query
    // and show those where the filter query matches
    var showing = 0;
    for (i = 0; i < counter; i++) {
        var pathelement = document.getElementsByClassName("install_path")[i];
        var path = pathelement.innerHTML;
        if (path.indexOf(filter) == -1) {
            pathelement.parentNode.style.display = "none";
        } else {
            pathelement.parentNode.style.display = "table-row";
            showing++;
        }
    }
    document.getElementById('commits_number').innerHTML = showing;

}
