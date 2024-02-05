<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <link
            href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900&display=swap"
            rel="stylesheet"
        />
        <link
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
            rel="stylesheet"
        />
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
                    <button
                        id="dropdownDefaultButton"
                        data-dropdown-toggle="dropdown"
                        type="button"
                    >
                        <i class="fa fa-bell"></i>
                        <span
                            class="badge badge-light badge-xs"
                            >{{auth()->user()->unreadNotifications->count()}}</span
                        >
                    </button>
                    <!-- Dropdown menu -->
                    @if(auth()->user()->unreadNotifications->count())
                    <ul
                        id="dropdown"
                        class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 p-1"
                        aria-labelledby="dropdownDefaultButton"
                    >
                        @if (auth()->user()->unreadNotifications)
                        <li class="d-flex justify-content-end mx-1 my-2">
                            <a
                                href="{{ route('markAsRead') }}"
                                class="btn btn-success btn-sm"
                                >Mark All as Read</a
                            >
                        </li>
                        @endif @foreach (auth()->user()->unreadNotifications as
                        $notification)
                        <a href="#"
                            ><li class="p-1">
                                {{$notification->data['data']}}
                            </li></a
                        >
                        @endforeach @foreach (auth()->user()->readNotifications
                        as $notification)
                        <a href="#" class="text-secondary"
                            ><li class="p-1 text-secondary">
                                {{$notification->data['data']}}
                            </li></a
                        >
                        @endforeach
                    </ul>
                    @else
                    <ul
                        id="dropdown"
                        class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 p-1"
                        aria-labelledby="dropdownDefaultButton"
                    >
                        No Notification
                    </ul>
                    @endif
                </li>
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
        @yield('content') @stack('scripts')
    </body>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>

    <!-- <script src="node_modules/flowbite/dist/flowbite.min.js"></script> -->
</html>
