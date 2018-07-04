<!DOCTYPE html>
<html>
    <head>
        <title>Music - Conor Smith</title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/app.css">
    </head>
    <body style="padding-bottom: 60px;">
        <div class="container">

            <div class="page-header">
                <h1>Music <small>to which <a href="http://conorsmith.ie">Conor Smith</a> listens</small></h1>
            </div>

            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <ul class="nav navbar-nav">
                        <li class="{{ Route::currentRouteName() === 'home' ? 'active' : '' }}">
                            <a href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="{{ Route::currentRouteName() === 'albums' ? 'active' : '' }}">
                            <a href="{{ route('albums') }}">Albums</a>
                        </li>
                        <li class="{{ Route::currentRouteName() === 'artists' ? 'active' : '' }}">
                            <a href="{{ route('artists') }}">Artists</a>
                        </li>
                    </ul>
                </div>
            </nav>

            @yield('content')

        </div>
    </body>
</html>
