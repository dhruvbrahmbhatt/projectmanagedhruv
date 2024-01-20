<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900&display=swap" rel="stylesheet" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />

    <title>PMS</title>
</head>

<body class="bg-gray-100">
    <nav class="mb-9 p-6 bg-white flex justify-between">
        <ul class="flex item-center">
            <li class="p-3">
                <a href="{{ route('home') }}">Home</a>
            </li>
            <li class="p-3">
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="p-3">
                <a href="{{ route('tasks') }}">Tasks</a>
            </li>
        </ul>
        <ul class="flex item-center">
            @auth
                <li class="p-3">
                    <a href="">{{ auth()->user()->name }}</a>
                </li>
                <li class="p-3">
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                </li>
                @endauth @guest
                <li class="p-3">
                    <a href="{{ route('login') }}">Login</a>
                </li>
                <li class="p-3">
                    <a href="{{ route('register') }}">Register</a>
                </li>
            @endguest
        </ul>
    </nav>
    @yield('content')
    @stack('scripts')
</body>
<script src="{{ asset('js/app.js') }}"></script>

</html>
