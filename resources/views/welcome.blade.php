<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Todo App | Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50 dark:bg-gray-900">
        <div class="min-h-screen flex flex-col items-center justify-center p-6">
            <div class="w-full max-w-md">
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-8">
                    <div class="flex justify-center mb-8">
                        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">
                            Todo App
                        </h1>
                    </div>

                    <div class="space-y-4">
                        @if (Route::has('login'))
                            <div class="flex flex-col space-y-4">
                                @auth
                                    <a 
                                        href="{{ url('/dashboard') }}"
                                        class="w-full px-4 py-2 text-center font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 transition duration-150"
                                    >
                                        Go to Dashboard
                                    </a>
                                @else
                                    <a 
                                        href="{{ route('login') }}"
                                        class="w-full px-4 py-2 text-center font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 transition duration-150"
                                    >
                                        Log in
                                    </a>

                                    @if (Route::has('register'))
                                        <a 
                                            href="{{ route('register') }}"
                                            class="w-full px-4 py-2 text-center font-medium text-indigo-600 bg-white border border-indigo-600 rounded-md hover:bg-gray-50 transition duration-150"
                                        >
                                            Register
                                        </a>
                                    @endif
                                @endauth
                            </div>
                        @endif
                    </div>
                </div>

                <div class="mt-8 text-center text-gray-600 dark:text-gray-400">
                    <p>Simple Todo App built with Laravel Breeze</p>
                </div>
            </div>
        </div>
    </body>
</html>