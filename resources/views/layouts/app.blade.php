<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Todo') }}</title>
    @vite(['resources/js/app.js'])
</head>
<body>

<nav>
    @guest
        <a href="{{ route('login') }}">{{ __('Login') }}</a>
        <a href="{{ route('register') }}">{{ __('Register') }}</a>
    @endguest

</nav>

<main>
    @yield('content')
</main>

</body>
</html>
