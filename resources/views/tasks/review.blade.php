<x-app-layout>
    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <div class="mb-6">
                <h1 class="text-2xl font-semibold">Review</h1>
                <p class="text-gray-500 dark:text-gray-400">Review your tasks and projects</p>
            </div>
            
            <div class="space-y-8">
                <!-- Overdue Tasks -->
                <div>
                    <h2 class="text-xl font-semibold mb-4 text-red-600 dark:text-red-400">Overdue Tasks</h2>
                    <livewire:tasks.task-list :dueDate="'overdue'" />
                </div>
                
                <!-- Due Today Tasks -->
                <div>
                    <h2 class="text-xl font-semibold mb-4 text-blue-600 dark:text-blue-400">Due Today</h2>
                    <livewire:tasks.task-list :dueDate="'today'" />
                </div>
                
                <!-- Next Tasks -->
                <div>
                    <h2 class="text-xl font-semibold mb-4">Next Tasks</h2>
                    <livewire:tasks.task-list :statusFilter="App\Enums\TaskStatus::NEXT->value" />
                </div>
                
                <!-- Waiting Tasks -->
                <div>
                    <h2 class="text-xl font-semibold mb-4">Waiting For</h2>
                    <livewire:tasks.task-list :statusFilter="App\Enums\TaskStatus::WAITING->value" />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>