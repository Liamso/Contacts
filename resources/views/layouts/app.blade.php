<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app" class="min-h-screen bg-gray-100">
        <nav class="bg-gray-200 border-b-2 border-gray-300">
            <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
                <div class="relative flex items-center justify-between h-16">
                @auth
                    <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">

                        <button class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-expanded="false">
                            <span class="sr-only" onclick="toggleMobile()">Open main menu</span>

                            <svg onclick="toggleMobile()" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>

                            <svg onclick="toggleMobile()" class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                @endauth
                <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="flex-shrink-0 flex items-center text-gray-700 font-bold">
                        Contacts
                    </div>
                    @auth
                        <div class="hidden sm:block sm:ml-6">
                            <div class="flex space-x-4 ml-12">
                                <a href="/contacts" class="@if (Route::is('contacts.index')) bg-gray-700 text-white @else text-gray-700 hover:bg-gray-700 hover:text-white @endif  px-3 py-2 rounded-md text-sm font-medium">Contacts</a>
                            </div>
                        </div>
                    @endauth
                </div>
                <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0 text-gray-700">
                    @auth
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" >
                            @csrf
                            <button href="/logout" class="block px-4 py-2 text-sm hover:bg-gray-700 hover:text-white rounded-md" role="menuitem">Sign out</button>
                        </form>
                    @else
                        <a href="/login" class="block px-4 py-2 text-sm hover:bg-gray-700 hover:text-white rounded-md" role="menuitem">Log In</a>
                    @endauth
                </div>
            </div>

            <div class="hidden" id="mobileNav">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    @auth
                        <a href="/contacts" class="@if (Route::is('contacts.index')) bg-gray-700 text-white @else text-gray-700 hover:bg-gray-700 hover:text-white @endif block px-3 py-2 rounded-md text-base font-medium">Contacts</a>
                    @endauth
                </div>
            </div>
        </nav>

        <main class="py-4 flex items-center flex-col">
            @if(session('success')) 
                <div id="notification" onclick="dismissNotification()" class="bg-green-500 py-2 w-10/12 flex justify-center text-white rounded-md mb-3 transition transition-opacity duration-500 cursor-pointer" >
                    {{ session('success') }}
                </div>
            @endif
            <div class="flex justify-center w-10/12">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
