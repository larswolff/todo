<?php

namespace App\Livewire\Projects;

use App\Enums\ProjectStatus;
use Illuminate\View\View;
use Livewire\Component;

class CreateProject extends Component
{
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
    
    public function mount()
    {
        $this->status = ProjectStatus::READY->value;
    }
    
    public function render(): View
    {
        $areas = auth()->user()->areas->pluck('name', 'id');
        
        $statuses = [
            ProjectStatus::READY->value => 'Ready',
            ProjectStatus::SOMEDAY->value => 'Someday',
        ];
        
        return view('livewire.projects.create-project', [
            'areas' => $areas,
            'statuses' => $statuses,
        ]);
    }
    
    public function save()
    {
        $this->validate();
        
        $project = auth()->user()->createProject([
            'name' => $this->name,
            'description' => $this->description,
            'area_id' => $this->areaId,
            'is_sequential' => $this->isSequential,
            'status' => $this->status,
        ]);
        
        $this->reset(['name', 'description', 'areaId', 'isSequential']);
        $this->status = ProjectStatus::READY->value;
        
        $this->dispatch('project-created', ['id' => $project->id]);
        $this->dispatch('close-modal');
    }
}