<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
</head>
<body>
<header>
    <div class="row">
        @section('header')
        @show
    </div>
</header>
<main>
    <div class="row">
        @section('main')
        @show
    </div>
</main>
<footer>
    <div class="row">
        @section('footer')
        @show
    </div>
</footer>
</body>
</html>
