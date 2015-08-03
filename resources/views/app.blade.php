<!DOCTYPE html>
<html>
    <head>
        <title>Music Tracker</title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/app.css">
    </head>
    <body>
        <div class="container">

            <div class="page-header">
                <h1>Music Tracker</h1>
            </div>

            @section('tabs')
            @show

            @yield('content')

        </div>
    </body>
</html>
