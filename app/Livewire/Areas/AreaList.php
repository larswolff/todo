<?php

namespace App\Livewire\Areas;

use App\Models\Area;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class AreaList extends Component
{
    use WithPagination;

    public string $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    protected $listeners = [
        'area-created' => '$refresh',
        'area-updated' => '$refresh',
    ];

    public function render(): View
    {
        $areas = auth()->user()->areas()
            ->when($this->search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%');
            })
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.areas.area-list', [
            'areas' => $areas,
        ]);
    }

    public function clearSearch()
    {
        $this->reset(['search']);
    }

    public function deleteArea($areaId)
    {
        $area = Area::findOrFail($areaId);
        
        // Check if area has any projects
        if ($area->projects()->count() > 0) {
            session()->flash('error', 'Cannot delete area with associated projects.');
            return;
        }
        
        $area->delete();
        $this->dispatch('area-deleted');
    }
}