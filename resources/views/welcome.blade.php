<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>TODO - Organize Your Life</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased font-sans">
        <div class="bg-white text-black dark:bg-gray-950 dark:text-white">
            <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-blue-600 selection:text-white">
                <div class="relative w-full max-w-2xl px-6 lg:max-w-5xl">
                    <header class="flex justify-between items-center py-6">
                        <div class="flex justify-center">
                            <h1 class="text-3xl font-bold text-blue-600 dark:text-blue-500">TODO</h1>
                        </div>
                        @if (Route::has('login'))
                            <livewire:welcome.navigation />
                        @endif
                    </header>

                    <main class="mt-10">
                        <div class="text-center">
                            <h2 class="text-4xl font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-5xl md:text-6xl">
                                <span class="block">Organize Your Life</span>
                                <span class="block text-blue-600 dark:text-blue-500">With Our Simple TODO App</span>
                            </h2>
                            <p class="mt-6 max-w-lg mx-auto text-xl text-gray-600 dark:text-gray-300">
                                Stay organized, focused, and productive with our clean and simple TODO app.
                                Never forget a task again.
                            </p>
                            <div class="mt-10 flex justify-center">
                                @if (Route::has('login'))
                                    @auth
                                        <a href="{{ url('/dashboard') }}" class="rounded-md px-5 py-3 bg-blue-600 text-white font-semibold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                                            Go to Dashboard
                                        </a>
                                    @else
                                        <a href="{{ route('register') }}" class="rounded-md px-5 py-3 bg-blue-600 text-white font-semibold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2 dark:focus:ring-offset-gray-900 mr-4">
                                            Get Started
                                        </a>
                                        <a href="{{ route('login') }}" class="rounded-md px-5 py-3 bg-white text-blue-600 font-semibold ring-1 ring-blue-600 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-offset-gray-900">
                                            Sign In
                                        </a>
                                    @endauth
                                @endif
                            </div>
                        </div>

                        <div class="mt-20">
                            <div class="grid gap-8 md:grid-cols-3">
                                <div class="p-6 bg-white rounded-lg shadow-lg dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                                    <div class="w-12 h-12 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center mb-4">
                                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Simple Interface</h3>
                                    <p class="text-gray-700 dark:text-gray-300">A clean, intuitive interface that makes task management easy and straightforward.</p>
                                </div>

                                <div class="p-6 bg-white rounded-lg shadow-lg dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                                    <div class="w-12 h-12 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center mb-4">
                                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Stay Organized</h3>
                                    <p class="text-gray-700 dark:text-gray-300">Organize tasks by priority, due date, or create custom categories to fit your workflow.</p>
                                </div>

                                <div class="p-6 bg-white rounded-lg shadow-lg dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                                    <div class="w-12 h-12 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center mb-4">
                                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Boost Productivity</h3>
                                    <p class="text-gray-700 dark:text-gray-300">Track completed tasks, set reminders, and focus on what's most important to you.</p>
                                </div>
                            </div>
                        </div>
                    </main>

                    <footer class="py-8 text-center text-sm text-gray-500 dark:text-gray-400 mt-10">
                        <p>© {{ date('Y') }} TODO App. All rights reserved.</p>
                    </footer>
                </div>
            </div>
        </div>
    </body>
</html>