<!DOCTYPE html>
<html>
<head>
    <title>Music - Conor Smith</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
</head>
<body style="padding-bottom: 60px;">
<div class="container">

    <div class="page-header">
        <h1>Music <small>to which <a href="http://conorsmith.ie">Conor Smith</a> listens</small></h1>
    </div>

    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <ul class="nav navbar-nav">
                <li>
                    <a href="/dashboard">Dashboard</a>
                </li>
                <li>
                    <a href="/admin/albums">Albums</a>
                </li>
            </ul>
            <ul class="nav navbar-nav pull-right">
                <li>
                    <a href="/">Public Site</a>
                </li>
            </ul>
        </div>
    </nav>

    @yield('content')

</div>
</body>
</html>
