<div>
    <!-- Filters -->
    <div class="mb-6 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Search</label>
                <input type="text" id="search" wire:model.live="search" placeholder="Search tasks..." class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white shadow-sm">
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
                <label for="projectFilter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Project</label>
                <select id="projectFilter" wire:model.live="projectFilter" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white shadow-sm">
                    <option value="">All Projects</option>
                    @foreach($projects as $id => $name)
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
    
    <!-- Tasks List -->
    @if($tasks->count() > 0)
        <div class="overflow-hidden bg-white dark:bg-gray-700 shadow-sm sm:rounded-lg">
            <ul class="divide-y divide-gray-200 dark:divide-gray-600">
                @foreach($tasks as $task)
                    <li class="p-4 hover:bg-gray-50 dark:hover:bg-gray-600 transition">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="flex items-center">
                                    <button wire:click="markAsCompleted({{ $task->id }})" class="flex-shrink-0 mr-3 h-5 w-5 rounded border border-gray-300 dark:border-gray-600 @if($task->status->value === 'completed') bg-green-500 dark:bg-green-600 border-green-500 dark:border-green-600 @endif focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        @if($task->status->value === 'completed')
                                            <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        @endif
                                    </button>
                                    
                                    <a href="{{ route('tasks.show', $task) }}" class="font-medium text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition @if($task->status->value === 'completed') line-through text-gray-500 dark:text-gray-400 @endif">
                                        {{ $task->title }}
                                    </a>
                                    
                                    @if($task->due_date && $task->due_date < now() && $task->status->value !== 'completed')
                                        <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100">
                                            Overdue
                                        </span>
                                    @elseif($task->due_date && $task->due_date->isToday())
                                        <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">
                                            Today
                                        </span>
                                    @endif
                                </div>
                                
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Status: <span class="@if($task->status->value === 'completed') text-green-600 dark:text-green-400 @elseif($task->status->value === 'next') text-blue-600 dark:text-blue-400 @elseif($task->status->value === 'waiting') text-yellow-600 dark:text-yellow-400 @endif">
                                        {{ ucfirst($task->status->name) }}
                                    </span> | 
                                    @if($task->project)
                                        Project: <a href="{{ route('projects.show', $task->project) }}" class="text-blue-600 dark:text-blue-400 hover:underline">{{ $task->project->name }}</a> | 
                                    @endif
                                    @if($task->due_date)
                                        Due: {{ $task->due_date->format('M d, Y') }}
                                    @else
                                        No due date
                                    @endif
                                </p>
                                
                                @if($task->tags->count() > 0)
                                    <div class="mt-1 flex flex-wrap gap-1">
                                        @foreach($task->tags as $tag)
                                            <a href="{{ route('tags.show', $tag) }}" class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">
                                                {{ $tag->name }}
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <div class="flex space-x-2">
                                @if($task->status->value !== 'next')
                                    <button wire:click="markAsNext({{ $task->id }})" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300" title="Mark as Next">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                @endif
                                
                                <a href="{{ route('tasks.edit', $task) }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
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
            {{ $tasks->links() }}
        </div>
    @else
        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 text-center">
            <p class="text-gray-500 dark:text-gray-400 mb-4">No tasks found matching your criteria.</p>
            <a href="{{ route('tasks.create') }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                Create Your First Task
            </a>
        </div>
    @endif
</div>