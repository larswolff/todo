<x-app-layout>
    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <h1 class="text-2xl font-semibold mb-4">Dashboard</h1>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Dashboard Stats -->
                <div class="bg-blue-50 dark:bg-gray-700 p-4 rounded-lg shadow-sm border border-blue-100 dark:border-gray-600">
                    <h3 class="text-lg font-medium mb-2">Tasks Due Today</h3>
                    <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">0</p>
                </div>
                
                <div class="bg-blue-50 dark:bg-gray-700 p-4 rounded-lg shadow-sm border border-blue-100 dark:border-gray-600">
                    <h3 class="text-lg font-medium mb-2">Overdue Tasks</h3>
                    <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">0</p>
                </div>
                
                <div class="bg-blue-50 dark:bg-gray-700 p-4 rounded-lg shadow-sm border border-blue-100 dark:border-gray-600">
                    <h3 class="text-lg font-medium mb-2">Next Tasks</h3>
                    <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">0</p>
                </div>
            </div>
            
            <div class="mt-8">
                <h2 class="text-xl font-semibold mb-4">Recent Projects</h2>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 text-center">
                    <p class="text-gray-500 dark:text-gray-400">You don't have any projects yet.</p>
                    <button class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                        Create Project
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>