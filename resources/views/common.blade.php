<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/normalize.css')}}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
</head>
<body class="common">
<div class="navbar">
    <div class="logo-component">
        <img class="logo" src="{{asset('icons/logo.svg')}}" alt="logo">
        <div class="app-name">
            <span>Statistic Collector</span>
        </div>
    </div>
    @yield('article-action')
</div>
<div class="content">
    @yield('content')
</div>
</body>
</html>
