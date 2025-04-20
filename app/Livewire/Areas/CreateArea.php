<?php

namespace App\Livewire\Areas;

use Illuminate\View\View;
use Livewire\Component;

class CreateArea extends Component
{
    public string $name = '';
    public string $description = '';
    
    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ];
    }
    
    public function render(): View
    {
        return view('livewire.areas.create-area');
    }
    
    public function save()
    {
        $this->validate();
        
        $area = auth()->user()->createArea([
            'name' => $this->name,
            'description' => $this->description,
        ]);
        
        $this->reset(['name', 'description']);
        
        $this->dispatch('area-created', ['id' => $area->id]);
        $this->dispatch('close-modal');
    }
}