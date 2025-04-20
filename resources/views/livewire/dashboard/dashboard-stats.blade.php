<div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <!-- Dashboard Stats -->
        <div class="bg-blue-50 dark:bg-gray-700 p-4 rounded-lg shadow-sm border border-blue-100 dark:border-gray-600">
            <h3 class="text-lg font-medium mb-2">Tasks Due Today</h3>
            <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $stats['due_today'] }}</p>
        </div>
        
        <div class="bg-blue-50 dark:bg-gray-700 p-4 rounded-lg shadow-sm border border-blue-100 dark:border-gray-600">
            <h3 class="text-lg font-medium mb-2">Overdue Tasks</h3>
            <p class="text-3xl font-bold text-red-600 dark:text-red-400">{{ $stats['overdue_tasks'] }}</p>
        </div>
        
        <div class="bg-blue-50 dark:bg-gray-700 p-4 rounded-lg shadow-sm border border-blue-100 dark:border-gray-600">
            <h3 class="text-lg font-medium mb-2">Next Tasks</h3>
            <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $stats['next_tasks'] }}</p>
        </div>
        
        <div class="bg-blue-50 dark:bg-gray-700 p-4 rounded-lg shadow-sm border border-blue-100 dark:border-gray-600">
            <h3 class="text-lg font-medium mb-2">Waiting For</h3>
            <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $stats['waiting_tasks'] }}</p>
        </div>
        
        <div class="bg-blue-50 dark:bg-gray-700 p-4 rounded-lg shadow-sm border border-blue-100 dark:border-gray-600">
            <h3 class="text-lg font-medium mb-2">Active Projects</h3>
            <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $stats['active_projects'] }}</p>
        </div>
        
        <div class="bg-blue-50 dark:bg-gray-700 p-4 rounded-lg shadow-sm border border-blue-100 dark:border-gray-600">
            <h3 class="text-lg font-medium mb-2">Completed This Week</h3>
            <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $stats['completed_this_week'] }}</p>
        </div>
    </div>
    
    <div class="mt-8">
        <h2 class="text-xl font-semibold mb-4">Recent Projects</h2>
        @if($recentProjects->count() > 0)
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-700">
                <ul class="divide-y divide-gray-200 dark:divide-gray-600">
                    @foreach($recentProjects as $project)
                        <li class="p-4 hover:bg-gray-50 dark:hover:bg-gray-600 transition">
                            <a href="{{ route('projects.show', $project) }}" class="flex items-center justify-between">
                                <div>
                                    <h3 class="font-medium text-gray-900 dark:text-white">{{ $project->name }}</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $project->tasks_count ?? 0 }} tasks | 
                                        @if($project->area)
                                            Area: {{ $project->area->name }}
                                        @else
                                            No area
                                        @endif
                                    </p>
                                </div>
                                <span class="text-gray-400 dark:text-gray-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @else
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 text-center">
                <p class="text-gray-500 dark:text-gray-400">You don't have any projects yet.</p>
                <a href="{{ route('projects.create') }}" class="inline-block mt-4 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                    Create Project
                </a>
            </div>
        @endif
    </div>
</div>