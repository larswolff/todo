<nav class="flex">
    @auth
        <a
            href="{{ url('/dashboard') }}"
            class="rounded-md px-4 py-2 text-gray-700 bg-white ring-1 ring-gray-200 hover:bg-gray-50 transition focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2 dark:text-white dark:bg-gray-800 dark:ring-gray-700 dark:hover:bg-gray-700 dark:focus:ring-offset-gray-900"
        >
            Dashboard
        </a>
    @else
        <a
            href="{{ route('login') }}"
            class="rounded-md px-4 py-2 text-gray-700 bg-white ring-1 ring-gray-200 hover:bg-gray-50 transition focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2 dark:text-white dark:bg-gray-800 dark:ring-gray-700 dark:hover:bg-gray-700 dark:focus:ring-offset-gray-900 mr-3"
        >
            Sign In
        </a>

        @if (Route::has('register'))
            <a
                href="{{ route('register') }}"
                class="rounded-md px-4 py-2 bg-blue-600 text-white font-medium hover:bg-blue-700 transition focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2 dark:focus:ring-offset-gray-900"
            >
                Sign Up
            </a>
        @endif
    @endauth
</nav>