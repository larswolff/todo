<x-app-layout>
    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <div class="mb-6">
                <h1 class="text-2xl font-semibold">Edit Project</h1>
                <p class="text-gray-500 dark:text-gray-400">Update the details for {{ $project->name }}</p>
            </div>
            
            <livewire:projects.edit-project :project="$project" />
        </div>
    </div>
</x-app-layout>