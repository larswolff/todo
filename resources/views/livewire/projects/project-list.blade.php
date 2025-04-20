<div>
    <!-- Filters -->
    <div class="mb-6 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Search</label>
                <input type="text" id="search" wire:model.live="search" placeholder="Search projects..." class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white shadow-sm">
            </div>
            
            <div>
                <label for="statusFilter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                <select id="statusFilter" wire:model.live="statusFilter" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white shadow-sm">
                    <option value="">All Statuses</option>
                    @foreach($statuses as $label => $status)
                        <option value="{{ $status }}">{{ ucfirst($label) }}</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label for="areaFilter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Area</label>
                <select id="areaFilter" wire:model.live="areaFilter" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white shadow-sm">
                    <option value="">All Areas</option>
                    @foreach($areas as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="mt-4 text-right">
            <button wire:click="clearFilters" class="text-blue-600 dark:text-blue-400 hover:underline text-sm">
                Clear Filters
            </button>
        </div>
    </div>
    
    <!-- Projects List -->
    @if($projects->count() > 0)
        <div class="overflow-hidden bg-white dark:bg-gray-700 shadow-sm sm:rounded-lg">
            <ul class="divide-y divide-gray-200 dark:divide-gray-600">
                @foreach($projects as $project)
                    <li class="p-4 hover:bg-gray-50 dark:hover:bg-gray-600 transition">
                        <div class="flex items-center justify-between">
                            <div>
                                <a href="{{ route('projects.show', $project) }}" class="font-medium text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition">
                                    {{ $project->name }}
                                </a>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Status: <span class="@if($project->status->value === 'ready') text-green-600 dark:text-green-400 @elseif($project->status->value === 'completed') text-blue-600 dark:text-blue-400 @endif">
                                        {{ ucfirst($project->status->name) }}
                                    </span> | 
                                    @if($project->area)
                                        Area: {{ $project->area->name }} | 
                                    @endif
                                    {{ $project->tasks->count() }} tasks
                                </p>
                            </div>
                            <div class="flex space-x-2">
                                @if($project->status->value !== 'completed')
                                    <button wire:click="markAsCompleted({{ $project->id }})" class="text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </button>
                                @else
                                    <button wire:click="markAsReady({{ $project->id }})" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                                        </svg>
                                    </button>
                                @endif
                                
                                <a href="{{ route('projects.edit', $project) }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        
        <div class="mt-4">
            {{ $projects->links() }}
        </div>
    @else
        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 text-center">
            <p class="text-gray-500 dark:text-gray-400 mb-4">No projects found matching your criteria.</p>
            <a href="{{ route('projects.create') }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                Create Your First Project
            </a>
        </div>
    @endif
</div>