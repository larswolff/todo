<?php

namespace App\Livewire\Dashboard;

use App\Enums\ProjectStatus;
use App\Enums\TaskStatus;
use Illuminate\View\View;
use Livewire\Component;

class DashboardStats extends Component
{
    public function render(): View
    {
        $user = auth()->user();
        
        $stats = [
            'overdue_tasks' => $user->getOverdueTasks()->count(),
            'due_today' => $user->getTasksDueToday()->count(),
            'next_tasks' => $user->getNextTasks()->count(),
            'waiting_tasks' => $user->getWaitingTasks()->count(),
            'active_projects' => $user->projects()->where('status', ProjectStatus::READY->value)->count(),
            'completed_this_week' => $user->tasks()
                ->where('status', TaskStatus::COMPLETED->value)
                ->whereBetween('completed_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->count(),
        ];
        
        $recentProjects = $user->projects()
            ->where('status', ProjectStatus::READY->value)
            ->latest()
            ->take(5)
            ->get();
            
        return view('livewire.dashboard.dashboard-stats', [
            'stats' => $stats,
            'recentProjects' => $recentProjects,
        ]);
    }
}