<x-app-layout>
    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-semibold">Tag: {{ $tag->name }}</h1>
                </div>
                <a href="{{ route('tags.edit', $tag) }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                    Edit Tag
                </a>
            </div>
            
            <div class="mb-6 flex items-center">
                <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">
                    {{ $tag->name }}
                </div>
                <div class="ml-4">
                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        @if($tag->in_menu)
                            Shown in menu
                        @else
                            Not shown in menu
                        @endif
                    </span>
                </div>
            </div>
            
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-4">Tasks with this Tag</h2>
                <livewire:tasks.task-list />
            </div>
            
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-4">Projects with this Tag</h2>
                <livewire:projects.project-list />
            </div>
        </div>
    </div>
</x-app-layout>