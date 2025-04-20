<div>
    <!-- Filters -->
    <div class="mb-6 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
        <div class="flex flex-col md:flex-row md:items-end gap-4">
            <div class="flex-grow">
                <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Search</label>
                <input type="text" id="search" wire:model.live="search" placeholder="Search tags..." class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white shadow-sm">
            </div>
            
            <div class="flex items-center">
                <input type="checkbox" id="showOnlyMenuTags" wire:model.live="showOnlyMenuTags" class="rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                <label for="showOnlyMenuTags" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                    Show only menu tags
                </label>
            </div>
            
            <div>
                <button wire:click="clearFilters" class="px-4 py-2 text-blue-600 dark:text-blue-400 hover:underline text-sm">
                    Clear Filters
                </button>
            </div>
        </div>
    </div>
    
    <!-- Tags List -->
    @if($tags->count() > 0)
        <div class="overflow-hidden bg-white dark:bg-gray-700 shadow-sm sm:rounded-lg">
            <ul class="divide-y divide-gray-200 dark:divide-gray-600">
                @foreach($tags as $tag)
                    <li class="p-4 hover:bg-gray-50 dark:hover:bg-gray-600 transition">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <a href="{{ route('tags.show', $tag) }}" class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100 hover:bg-blue-200 dark:hover:bg-blue-700 transition">
                                    {{ $tag->name }}
                                </a>
                                <span class="ml-3 text-sm text-gray-500 dark:text-gray-400">
                                    @if($tag->in_menu)
                                        <span class="text-green-600 dark:text-green-400">In menu</span>
                                    @else
                                        <span>Not in menu</span>
                                    @endif
                                </span>
                            </div>
                            <div class="flex space-x-2">
                                <button wire:click="toggleMenuStatus({{ $tag->id }})" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300" title="{{ $tag->in_menu ? 'Remove from menu' : 'Add to menu' }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        @if($tag->in_menu)
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        @endif
                                    </svg>
                                </button>
                                
                                <a href="{{ route('tags.edit', $tag) }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                
                                <button wire:click="deleteTag({{ $tag->id }})" class="text-red-500 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300">
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
            {{ $tags->links() }}
        </div>
    @else
        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 text-center">
            <p class="text-gray-500 dark:text-gray-400 mb-4">No tags found matching your criteria.</p>
            <a href="{{ route('tags.create') }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                Create Your First Tag
            </a>
        </div>
    @endif
</div>