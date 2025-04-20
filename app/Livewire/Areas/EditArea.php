<?php

namespace App\Livewire\Areas;

use App\Models\Area;
use Illuminate\View\View;
use Livewire\Component;

class EditArea extends Component
{
    public Area $area;
    
    public string $name = '';
    public string $description = '';
    
    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ];
    }
    
    public function mount(Area $area)
    {
        $this->area = $area;
        $this->name = $area->name;
        $this->description = $area->description ?? '';
    }
    
    public function render(): View
    {
        return view('livewire.areas.edit-area');
    }
    
    public function save()
    {
        $this->validate();
        
        $this->area->update([
            'name' => $this->name,
            'description' => $this->description,
        ]);
        
        $this->dispatch('area-updated');
        $this->dispatch('close-modal');
    }
}