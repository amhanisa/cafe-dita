<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cafe DITA</title>

    @vite('resources/scss/app.scss')
    @vite('resources/scss/themes/dark/app-dark.scss')
    @vite('resources/js/app.js')
</head>

<body>
    <div id="app">
        <div class="active" id="sidebar">@include('layouts.sidebar')</div>
        <div id="main">
            <header class="mb-3">
                <a class="burger-btn d-block d-xl-none" href="#">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
            @yield('content')
        </div>
    </div>
</body>

</html>
