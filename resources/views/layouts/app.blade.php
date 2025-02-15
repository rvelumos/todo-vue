<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Todo') }}</title>
</head>
<body>

<nav>
    @guest
        <a href="{{ route('login') }}">{{ __('Login') }}</a>
        <a href="{{ route('register') }}">{{ __('Register') }}</a>
    @endguest

</nav>

<div class="wrapper">
    <main>
        @yield('content')
    </main>
</div>

</body>
</html>
