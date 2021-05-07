<!doctype html>
<head>
    <title>MooSIS - Moodle Submodule Information System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="/blog.js"></script>
    <link href="/app.css" rel="stylesheet">
</head>
<body>
    <div id="wrapper">
        <div id="header">
            <div id="titlebar">
                <div id="header-title"><img id="logo" src="/logo.png">MooSIS - Moodle Submodule Information System</div>
            </div>
            <div id="top-menu" class="container">
                <a class="button btn-sm" href="/collections">Collections</a>
                <a class="button btn-sm" href="/plugins">Plugins</a>
                <a class="button btn-sm" href="/commits">Commits</a>
                <a class="button btn-sm" href="/branches">Branches</a>
            </div>
        </div>
    </div>
    <hr>

    @yield('content')
    <hr>
    <div id="footer-version">MooSIS v.0.9 / (c) 2021 QMUL</div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>

    <script>
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
            @if(isset($collection))
                // Display the number of shown plugins
                var text2display = "Showing " + showing + " of {{ $collection->commits()->count() }}"
                document.getElementById('plugins_number').innerHTML = showing;
            @endif

        }

        function test() {
//            var counter = document.getElementsByTagName("td.install_path").length;
            var counter = document.getElementsByClassName("install_path").length;
            alert('check the plugin numbers now!');
            document.getElementById('plugins_number').innerHTML = 'huhu!';

        }
    </script>

</body>
