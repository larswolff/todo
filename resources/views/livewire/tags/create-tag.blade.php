<div>
    <form wire:submit="save" class="space-y-6">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tag Name</label>
            <input type="text" id="name" wire:model="name" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white shadow-sm" autofocus>
            @error('name') <span class="text-red-600 dark:text-red-400 text-sm">{{ $message }}</span> @enderror
        </div>
        
        <div class="flex items-center">
            <input type="checkbox" id="inMenu" wire:model="inMenu" class="rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            <label for="inMenu" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                Show in menu
            </label>
            @error('inMenu') <span class="text-red-600 dark:text-red-400 text-sm">{{ $message }}</span> @enderror
        </div>
        
        <div class="flex justify-end space-x-2">
            <a href="{{ route('tags.index') }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                Cancel
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                Create Tag
            </button>
        </div>
    </form>
</div>