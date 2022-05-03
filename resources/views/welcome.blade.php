<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">
    </link>
</head>

<body>

    <div id="app">

        <header>
            <banner-component></banner-component>
        </header>

        <main-component></main-component>

    </div>
    <script src="{{ secure_asset('js/app.js') }}"></script>
</body>

</html>
