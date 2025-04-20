<?php

namespace App\Livewire\Tags;

use Illuminate\View\View;
use Livewire\Component;

class CreateTag extends Component
{
    public string $name = '';
    public bool $inMenu = false;
    
    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'inMenu' => 'boolean',
        ];
    }
    
    public function render(): View
    {
        return view('livewire.tags.create-tag');
    }
    
    public function save()
    {
        $this->validate();
        
        $tag = auth()->user()->createTag([
            'name' => $this->name,
            'in_menu' => $this->inMenu,
        ]);
        
        $this->reset(['name', 'inMenu']);
        
        $this->dispatch('tag-created', ['id' => $tag->id]);
        $this->dispatch('close-modal');
    }
}