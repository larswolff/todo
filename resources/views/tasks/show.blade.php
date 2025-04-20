<x-app-layout>
    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-semibold">{{ $task->title }}</h1>
                    @if($task->project)
                        <p class="text-gray-500 dark:text-gray-400">Project: <a href="{{ route('projects.show', $task->project) }}" class="text-blue-600 dark:text-blue-400 hover:underline">{{ $task->project->name }}</a></p>
                    @endif
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('tasks.edit', $task) }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        Edit
                    </a>
                    <button onclick="document.getElementById('complete-task-form').submit()" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">
                        Mark Complete
                    </button>
                    <form id="complete-task-form" action="#" method="POST" class="hidden">
                        @csrf
                        @method('PATCH')
                    </form>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                    <h3 class="text-lg font-medium mb-2">Status</h3>
                    <p class="font-semibold @if($task->status->value === 'completed') text-green-600 dark:text-green-400 @elseif($task->status->value === 'waiting') text-yellow-600 dark:text-yellow-400 @else text-blue-600 dark:text-blue-400 @endif">
                        {{ ucfirst($task->status->name) }}
                    </p>
                </div>
                
                @if($task->due_date)
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <h3 class="text-lg font-medium mb-2">Due Date</h3>
                        <p class="font-semibold @if($task->due_date < now() && $task->status->value !== 'completed') text-red-600 dark:text-red-400 @else text-gray-700 dark:text-gray-300 @endif">
                            {{ $task->due_date->format('M d, Y') }}
                        </p>
                    </div>
                @endif
                
                @if($task->tags->count() > 0)
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <h3 class="text-lg font-medium mb-2">Tags</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($task->tags as $tag)
                                <a href="{{ route('tags.show', $tag) }}" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">
                                    {{ $tag->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            
            @if($task->description)
                <div class="mb-6 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                    <h2 class="text-lg font-medium mb-2">Description</h2>
                    <p class="whitespace-pre-line">{{ $task->description }}</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>