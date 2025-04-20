<?php

namespace App\Livewire\Tasks;

use App\Enums\TaskStatus;
use App\Models\Task;
use Illuminate\View\View;
use Livewire\Component;

class EditTask extends Component
{
    public Task $task;
    
    public string $title = '';
    public string $description = '';
    public ?int $projectId = null;
    public ?string $dueDate = null;
    public string $status = '';
    public array $selectedTags = [];
    
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
    
    public function mount(Task $task)
    {
        $this->task = $task;
        $this->title = $task->title;
        $this->description = $task->description ?? '';
        $this->projectId = $task->project_id;
        $this->dueDate = $task->due_date?->format('Y-m-d');
        $this->status = $task->status->value;
        $this->selectedTags = $task->tags->pluck('id')->toArray();
    }
    
    public function render(): View
    {
        $projects = auth()->user()->projects->pluck('name', 'id');
        
        $statuses = [
            TaskStatus::READY->value => 'Ready',
            TaskStatus::NEXT->value => 'Next',
            TaskStatus::WAITING->value => 'Waiting',
            TaskStatus::SOMEDAY->value => 'Someday',
            TaskStatus::COMPLETED->value => 'Completed',
        ];
        
        $tags = auth()->user()->tags->pluck('name', 'id');
        
        return view('livewire.tasks.edit-task', [
            'projects' => $projects,
            'statuses' => $statuses,
            'tags' => $tags,
        ]);
    }
    
    public function save()
    {
        $this->validate();
        
        $this->task->update([
            'title' => $this->title,
            'description' => $this->description,
            'project_id' => $this->projectId,
            'due_date' => $this->dueDate,
            'status' => $this->status,
        ]);
        
        $this->task->tags()->sync($this->selectedTags);
        
        $this->dispatch('task-updated');
        $this->dispatch('close-modal');
    }
}