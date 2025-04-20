<x-app-layout>
    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-semibold">{{ $project->name }}</h1>
                    @if($project->area)
                        <p class="text-gray-500 dark:text-gray-400">Area: {{ $project->area->name }}</p>
                    @endif
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('tasks.create', ['project_id' => $project->id]) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                        Add Task
                    </a>
                    <a href="{{ route('projects.edit', $project) }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        Edit
                    </a>
                </div>
            </div>
            
            @if($project->description)
                <div class="mb-6 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                    <h2 class="text-lg font-medium mb-2">Description</h2>
                    <p class="whitespace-pre-line">{{ $project->description }}</p>
                </div>
            @endif
            
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-4">Tasks</h2>
                <livewire:tasks.task-list :projectFilter="$project->id" />
            </div>
        </div>
    </div>
</x-app-layout>