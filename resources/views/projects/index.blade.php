<x-app-layout>
    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold">Projects</h1>
                <a href="{{ route('projects.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                    New Project
                </a>
            </div>
            
            <livewire:projects.project-list />
        </div>
    </div>
</x-app-layout>