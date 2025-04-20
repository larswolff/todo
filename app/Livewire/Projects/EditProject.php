<?php

namespace App\Livewire\Projects;

use App\Enums\ProjectStatus;
use App\Models\Project;
use Illuminate\View\View;
use Livewire\Component;

class EditProject extends Component
{
    public Project $project;
    
    public string $name = '';
    public string $description = '';
    public ?int $areaId = null;
    public bool $isSequential = false;
    public string $status = '';
    
    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'areaId' => 'nullable|exists:areas,id',
            'isSequential' => 'boolean',
            'status' => 'required|string',
        ];
    }
    
    public function mount(Project $project)
    {
        $this->project = $project;
        $this->name = $project->name;
        $this->description = $project->description ?? '';
        $this->areaId = $project->area_id;
        $this->isSequential = $project->is_sequential;
        $this->status = $project->status->value;
    }
    
    public function render(): View
    {
        $areas = auth()->user()->areas->pluck('name', 'id');
        
        $statuses = [
            ProjectStatus::READY->value => 'Ready',
            ProjectStatus::SOMEDAY->value => 'Someday',
            ProjectStatus::COMPLETED->value => 'Completed',
            ProjectStatus::CANCELLED->value => 'Cancelled',
            ProjectStatus::INACTIVE->value => 'Inactive',
        ];
        
        return view('livewire.projects.edit-project', [
            'areas' => $areas,
            'statuses' => $statuses,
        ]);
    }
    
    public function save()
    {
        $this->validate();
        
        $this->project->update([
            'name' => $this->name,
            'description' => $this->description,
            'area_id' => $this->areaId,
            'is_sequential' => $this->isSequential,
            'status' => $this->status,
        ]);
        
        $this->dispatch('project-updated');
        $this->dispatch('close-modal');
    }
}