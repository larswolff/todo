<x-app-layout>
    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-semibold">{{ $area->name }}</h1>
                </div>
                <a href="{{ route('areas.edit', $area) }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                    Edit Area
                </a>
            </div>
            
            @if($area->description)
                <div class="mb-6 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                    <h2 class="text-lg font-medium mb-2">Description</h2>
                    <p class="whitespace-pre-line">{{ $area->description }}</p>
                </div>
            @endif
            
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-4">Projects in this Area</h2>
                <livewire:projects.project-list :areaFilter="$area->id" />
            </div>
        </div>
    </div>
</x-app-layout>