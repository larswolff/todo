<x-app-layout>
    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <div class="mb-6">
                <h1 class="text-2xl font-semibold">Edit Tag</h1>
                <p class="text-gray-500 dark:text-gray-400">Update details for: {{ $tag->name }}</p>
            </div>
            
            <livewire:tags.edit-tag :tag="$tag" />
        </div>
    </div>
</x-app-layout>