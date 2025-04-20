<?php

namespace App\Livewire\Tasks;

use App\Enums\TaskStatus;
use App\Models\Task;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class TaskList extends Component
{
    use WithPagination;

    public string $statusFilter = '';
    public string $search = '';
    public ?int $projectFilter = null;
    public ?string $dueDate = null;

    protected $queryString = [
        'statusFilter' => ['except' => ''],
        'search' => ['except' => ''],
        'projectFilter' => ['except' => null],
        'dueDate' => ['except' => null],
    ];

    protected $listeners = [
        'task-created' => '$refresh',
        'task-updated' => '$refresh',
    ];

    public function render(): View
    {
        $tasks = auth()->user()->tasks()
            ->when($this->statusFilter, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($this->search, function ($query, $search) {
                return $query->where('title', 'like', '%' . $search . '%');
            })
            ->when($this->projectFilter, function ($query, $projectId) {
                return $query->where('project_id', $projectId);
            })
            ->when($this->dueDate, function ($query, $dueDate) {
                if ($dueDate === 'today') {
                    return $query->whereDate('due_date', today());
                } elseif ($dueDate === 'overdue') {
                    return $query->whereDate('due_date', '<', today());
                } elseif ($dueDate === 'upcoming') {
                    return $query->whereDate('due_date', '>', today());
                }
                return $query;
            })
            ->orderBy('due_date')
            ->orderBy('created_at')
            ->paginate(10);
        
        $projects = auth()->user()->projects->pluck('name', 'id');
        
        $statuses = collect([
            'ready' => TaskStatus::READY->value,
            'next' => TaskStatus::NEXT->value,
            'waiting' => TaskStatus::WAITING->value,
            'someday' => TaskStatus::SOMEDAY->value,
            'completed' => TaskStatus::COMPLETED->value,
        ]);

        return view('livewire.tasks.task-list', [
            'tasks' => $tasks,
            'projects' => $projects,
            'statuses' => $statuses,
        ]);
    }

    public function clearFilters()
    {
        $this->reset(['statusFilter', 'search', 'projectFilter', 'dueDate']);
    }

    public function markAsCompleted($taskId)
    {
        $task = Task::findOrFail($taskId);
        $task->markAsCompleted();
        $this->dispatch('task-updated');
    }

    public function markAsReady($taskId)
    {
        $task = Task::findOrFail($taskId);
        $task->status = TaskStatus::READY;
        $task->save();
        $this->dispatch('task-updated');
    }

    public function markAsNext($taskId)
    {
        $task = Task::findOrFail($taskId);
        $task->status = TaskStatus::NEXT;
        $task->save();
        $this->dispatch('task-updated');
    }
}