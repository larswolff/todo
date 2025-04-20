<?php

namespace App\Livewire\Tags;

use App\Models\Tag;
use Illuminate\View\View;
use Livewire\Component;

class EditTag extends Component
{
    public Tag $tag;
    
    public string $name = '';
    public bool $inMenu = false;
    
    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'inMenu' => 'boolean',
        ];
    }
    
    public function mount(Tag $tag)
    {
        $this->tag = $tag;
        $this->name = $tag->name;
        $this->inMenu = $tag->in_menu;
    }
    
    public function render(): View
    {
        return view('livewire.tags.edit-tag');
    }
    
    public function save()
    {
        $this->validate();
        
        $this->tag->update([
            'name' => $this->name,
            'in_menu' => $this->inMenu,
        ]);
        
        $this->dispatch('tag-updated');
        $this->dispatch('close-modal');
    }
}