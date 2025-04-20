@props(['active'])

<div x-cloak :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}" 
    class="md:translate-x-0 transform bg-white dark:bg-gray-800 h-full w-64 fixed top-0 left-0 overflow-y-auto transition-transform duration-300 ease-in-out shadow-md z-30">
    
    <!-- Logo and Close button -->
    <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
        <div class="text-2xl font-bold text-blue-600 dark:text-blue-500">{{ config('app.name', 'TODO') }}</div>
        <button @click="sidebarOpen = false" class="md:hidden rounded-md p-2 text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    
    <!-- Navigation Menu -->
    <nav class="mt-4 px-2 space-y-1">
        @php
            $navItems = [
                ['name' => 'inbox', 'label' => 'Inbox', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />'],
                ['name' => 'today', 'label' => 'Today', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />'],
                ['name' => 'next', 'label' => 'Next', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />'],
                ['name' => 'projects', 'label' => 'Projects', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />'],
                ['name' => 'areas', 'label' => 'Areas', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />'],
                ['name' => 'tags', 'label' => 'Tags', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />'],
                ['name' => 'review', 'label' => 'Review', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />'],
                ['name' => 'waiting', 'label' => 'Waiting', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />'],
                ['name' => 'upcoming', 'label' => 'Upcoming', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />'],
                ['name' => 'someday', 'label' => 'Someday', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />']
            ];
        @endphp

        @foreach ($navItems as $item)
            @php
                $isActive = str_starts_with($active, $item['name']);
            @endphp
            <a href="#" 
                class="{{ $isActive ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-600 dark:bg-gray-700 dark:text-blue-400 dark:border-blue-500' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white' }} group flex items-center px-3 py-2 text-sm font-medium rounded-md">
                <svg class="mr-3 h-5 w-5 {{ $isActive ? 'text-blue-600 dark:text-blue-400' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    {!! $item['icon'] !!}
                </svg>
                {{ $item['label'] }}
            </a>
        @endforeach

        <!-- Divider -->
        <div class="border-t border-gray-200 dark:border-gray-700 my-2"></div>

        <!-- Menu Tags -->
        @if (Auth::check())
            @php
                $menuTags = Auth::user()->getMenuTags();
            @endphp
            @foreach ($menuTags as $tag)
                @php
                    $tagRoute = 'tags.' . $tag->id;
                    $isActive = $active === $tagRoute;
                @endphp
                <a href="#" 
                    class="{{ $isActive ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-600 dark:bg-gray-700 dark:text-blue-400 dark:border-blue-500' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white' }} group flex items-center px-3 py-2 text-sm font-medium rounded-md">
                    <svg class="mr-3 h-5 w-5 {{ $isActive ? 'text-blue-600 dark:text-blue-400' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    {{ $tag->name }}
                </a>
            @endforeach
        @endif
    </nav>

    <!-- User Profile Section -->
    <div class="mt-auto p-4 border-t border-gray-200 dark:border-gray-700">
        @if (Auth::check())
            <div class="flex items-center">
                <div class="rounded-full h-10 w-10 bg-blue-600 flex items-center justify-center text-white">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ Auth::user()->name }}</p>
                    <a href="{{ route('profile') }}" class="text-xs font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                        View profile
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Sidebar Backdrop -->
<div x-cloak 
    x-show="sidebarOpen"
    @click="sidebarOpen = false"
    class="md:hidden fixed inset-0 bg-gray-600 bg-opacity-50 z-20 transition-opacity"></div>