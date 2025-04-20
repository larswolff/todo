<div>
    <form wire:submit="save" class="space-y-6">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Project Name</label>
            <input type="text" id="name" wire:model="name" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white shadow-sm" autofocus>
            @error('name') <span class="text-red-600 dark:text-red-400 text-sm">{{ $message }}</span> @enderror
        </div>
        
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
            <textarea id="description" wire:model="description" rows="4" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white shadow-sm"></textarea>
            @error('description') <span class="text-red-600 dark:text-red-400 text-sm">{{ $message }}</span> @enderror
        </div>
        
        <div>
            <label for="areaId" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Area (Optional)</label>
            <select id="areaId" wire:model="areaId" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white shadow-sm">
                <option value="">No Area</option>
                @foreach($areas as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
            @error('areaId') <span class="text-red-600 dark:text-red-400 text-sm">{{ $message }}</span> @enderror
        </div>
        
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
            <select id="status" wire:model="status" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white shadow-sm">
                @foreach($statuses as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
            @error('status') <span class="text-red-600 dark:text-red-400 text-sm">{{ $message }}</span> @enderror
        </div>
        
        <div class="flex items-center">
            <input type="checkbox" id="isSequential" wire:model="isSequential" class="rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            <label for="isSequential" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                Sequential Project (tasks must be completed in order)
            </label>
            @error('isSequential') <span class="text-red-600 dark:text-red-400 text-sm">{{ $message }}</span> @enderror
        </div>
        
        <div class="flex justify-end space-x-2">
            <a href="{{ route('projects.index') }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                Cancel
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                Create Project
            </button>
        </div>
    </form>
</div>