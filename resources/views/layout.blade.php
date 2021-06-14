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
    <div id="header">
        <div id="titlebar">
            <div id="header-title"><a href="/"><img id="logo" src="/logo.png"></a>MooSIS - Moodle Submodule Information System</div>
        </div>
        @auth
            <div id="top-menu" class="container">
                <a class="top-menu button btn-sm btn-outline" href="/collections">Collections</a>
                <a class="top-menu button btn-sm" href="/plugins">Plugins</a>
                <a class="top-menu button btn-sm" href="/commits">Commits</a>
                <a class="top-menu button btn-sm" href="/branches">Branches</a>
            </div>
        @endauth
        <hr>
    </div>

    @if (Route::has('login'))
        <div id="login" class="">
            @auth
                <mod id="login-name">{{ Auth::user()->name }}</mod>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button id="logout-btn" class="btn btn-sm btn-secondary" type="submit">Log out</button>
                </form>

            @else
                <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Log in</a>
                <i style="color: white;"> or </i>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
                @endif
            @endauth
        </div>
    @endif


    <div id="waiting" class="hiding">
        <img id="tapping" src="/tapping.gif">
        <p>
            Please wait while we import the data.
        </p>
    </div>

    <div id="content-wrapper">
        @auth
            @yield('content')
        @else
            <div id="login1st">
                <div id="welcome-title"> Welcome to MooSIS.</div>
                <p>
                    Please log in first.
                </p>
            </div>
        @endauth
    </div>

    <hr>
    <div id="footer-version">MooSIS v.20210611 / (c) 2021 QMUL, M.Opitz</div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>

</body>
