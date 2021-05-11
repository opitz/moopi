<!doctype html>
<head>
    <title>MooSIS - Moodle Submodule Information System</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/js/jquery.tablesorter.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="/app.js"></script>
    <script src="/js/jquery.js"></script>
    <link href="/app.css" rel="stylesheet">
</head>
<body>
    <div id="wrapper">
        <div id="header">
            <div id="titlebar">
                <div id="header-title"><img id="logo" src="/logo.png">MooSIS - Moodle Submodule Information System</div>
            </div>
            <div id="top-menu" class="container">
                <a class="top-menu button btn-sm btn-outline" href="/collections">Collections</a>
                <a class="top-menu button btn-sm" href="/plugins">Plugins</a>
                <a class="top-menu button btn-sm" href="/commits">Commits</a>
                <a class="top-menu button btn-sm" href="/branches">Branches</a>
            </div>
        </div>
    </div>

    <div id="waiting" class="hiding">
        <img id="tapping" src="/tapping.gif">
        <p>
            Please wait while we import the data.
        </p>
    </div>

    <hr>

    @yield('content')
    <hr>
    <div id="footer-version">MooSIS v.0.9.2 / (c) 2021 QMUL</div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>

</body>
