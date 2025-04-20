<?php

namespace App\Livewire\Projects;

use App\Enums\ProjectStatus;
use App\Models\Project;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class ProjectList extends Component
{
    use WithPagination;

    public string $statusFilter = '';
    public string $search = '';
    public ?int $areaFilter = null;

    protected $queryString = [
        'statusFilter' => ['except' => ''],
        'search' => ['except' => ''],
        'areaFilter' => ['except' => null],
    ];

    public function render(): View
    {
        $projects = auth()->user()->projects()
            ->when($this->statusFilter, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($this->search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%');
            })
            ->when($this->areaFilter, function ($query, $areaId) {
                return $query->where('area_id', $areaId);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        $areas = auth()->user()->areas->pluck('name', 'id');
        
        $statuses = collect([
            'ready' => ProjectStatus::READY->value,
            'someday' => ProjectStatus::SOMEDAY->value,
            'completed' => ProjectStatus::COMPLETED->value,
            'cancelled' => ProjectStatus::CANCELLED->value,
            'inactive' => ProjectStatus::INACTIVE->value,
        ]);

        return view('livewire.projects.project-list', [
            'projects' => $projects,
            'areas' => $areas,
            'statuses' => $statuses,
        ]);
    }

    public function clearFilters()
    {
        $this->reset(['statusFilter', 'search', 'areaFilter']);
    }

    public function markAsCompleted($projectId)
    {
        $project = Project::findOrFail($projectId);
        $project->markAsCompleted();
        $this->dispatch('project-updated');
    }

    public function markAsReady($projectId)
    {
        $project = Project::findOrFail($projectId);
        $project->status = ProjectStatus::READY;
        $project->save();
        $this->dispatch('project-updated');
    }

    public function markAsSomeday($projectId)
    {
        $project = Project::findOrFail($projectId);
        $project->status = ProjectStatus::SOMEDAY;
        $project->save();
        $this->dispatch('project-updated');
    }
}