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
        <nav class="bg-white border-gray-200 dark:bg-gray-900">
            <div
                class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4"
            >
                <a href="https://flowbite.com/"
                    class="flex items-center space-x-3 rtl:space-x-reverse">
                    <span
                        class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white"
                        >PMS</span
                    >
                </a>
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
                            @endif @foreach (auth()->user()->unreadNotifications as $notification) 
                            <a href="#"
                                ><li class="p-1">
                                    {{$notification->data['data']}}
                                </li></a
                            >
                            @endforeach 
                            @foreach(auth()->user()->readNotifications as $notification)
                            <a href="#" class="text-secondary">
                                <li class="p-1 text-secondary">
                                    {{$notification->data['data']}}
                                </li>
                            </a>
                            @endforeach
                        </ul>
                <button
                    data-collapse-toggle="navbar-default"
                    type="button"
                    class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                    aria-controls="navbar-default"
                    aria-expanded="false"
                >
                    <span class="sr-only">Open main menu</span>
                    <svg
                        class="w-5 h-5"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 17 14"
                    >
                        <path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M1 1h15M1 7h15M1 13h15"
                        />
                    </svg>
                </button>
                <div class="hidden w-full md:block md:w-auto" id="navbar-default">
                <ul
                    class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700"
                >
                    <li class="p-3">
                        <a href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="p-3">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="p-3">
                        <a href="{{ route('tasks') }}">Tasks</a>
                    </li>
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
                </div>
            </div>
        </nav>
        @yield('content') @stack('scripts')
    </body>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>

    <!-- <script src="node_modules/flowbite/dist/flowbite.min.js"></script> -->
</html>
