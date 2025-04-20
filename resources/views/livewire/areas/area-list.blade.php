<div>
    <!-- Search -->
    <div class="mb-6 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
        <div class="flex items-center">
            <div class="flex-grow">
                <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Search</label>
                <input type="text" id="search" wire:model.live="search" placeholder="Search areas..." class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white shadow-sm">
            </div>
            <div class="ml-4 self-end">
                <button wire:click="clearSearch" class="px-4 py-2 text-blue-600 dark:text-blue-400 hover:underline">
                    Clear
                </button>
            </div>
        </div>
    </div>
    
    <!-- Areas List -->
    @if($areas->count() > 0)
        <div class="overflow-hidden bg-white dark:bg-gray-700 shadow-sm sm:rounded-lg">
            <ul class="divide-y divide-gray-200 dark:divide-gray-600">
                @foreach($areas as $area)
                    <li class="p-4 hover:bg-gray-50 dark:hover:bg-gray-600 transition">
                        <div class="flex items-center justify-between">
                            <div>
                                <a href="{{ route('areas.show', $area) }}" class="font-medium text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition">
                                    {{ $area->name }}
                                </a>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $area->projects->count() }} projects
                                </p>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('areas.edit', $area) }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <button wire:click="deleteArea({{ $area->id }})" class="text-red-500 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        
        <div class="mt-4">
            {{ $areas->links() }}
        </div>
    @else
        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 text-center">
            <p class="text-gray-500 dark:text-gray-400 mb-4">No areas found matching your criteria.</p>
            <a href="{{ route('areas.create') }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                Create Your First Area
            </a>
        </div>
    @endif
    
    @if (session()->has('error'))
        <div class="mt-4 p-4 bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100 rounded-lg">
            {{ session('error') }}
        </div>
    @endif
</div>