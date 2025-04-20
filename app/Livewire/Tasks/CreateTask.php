<?php

namespace App\Livewire\Tasks;

use App\Enums\TaskStatus;
use Illuminate\View\View;
use Livewire\Component;

class CreateTask extends Component
{
    public string $title = '';
    public string $description = '';
    public ?int $projectId = null;
    public ?string $dueDate = null;
    public string $status = '';
    public array $selectedTags = [];

    public function mount(?int $projectId = null)
    {
        $this->projectId = $projectId;
        $this->status = TaskStatus::READY->value;
    }
    
    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'projectId' => 'nullable|exists:projects,id',
            'dueDate' => 'nullable|date',
            'status' => 'required|string',
            'selectedTags' => 'array',
        ];
    }
    
    public function render(): View
    {
        $projects = auth()->user()->projects->pluck('name', 'id');
        
        $statuses = [
            TaskStatus::READY->value => 'Ready',
            TaskStatus::NEXT->value => 'Next',
            TaskStatus::WAITING->value => 'Waiting',
            TaskStatus::SOMEDAY->value => 'Someday',
        ];
        
        $tags = auth()->user()->tags->pluck('name', 'id');
        
        return view('livewire.tasks.create-task', [
            'projects' => $projects,
            'statuses' => $statuses,
            'tags' => $tags,
        ]);
    }
    
    public function save()
    {
        $this->validate();
        
        $task = auth()->user()->createTask([
            'title' => $this->title,
            'description' => $this->description,
            'project_id' => $this->projectId,
            'due_date' => $this->dueDate,
            'status' => $this->status,
        ]);
        
        if (count($this->selectedTags) > 0) {
            $task->tags()->attach($this->selectedTags);
        }
        
        $this->reset(['title', 'description', 'dueDate', 'selectedTags']);
        
        $this->dispatch('task-created', ['id' => $task->id]);
        $this->dispatch('close-modal');
    }
}