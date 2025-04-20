<?php

namespace App\Livewire\Tags;

use App\Models\Tag;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class TagList extends Component
{
    use WithPagination;

    public string $search = '';
    public bool $showOnlyMenuTags = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'showOnlyMenuTags' => ['except' => false],
    ];

    protected $listeners = [
        'tag-created' => '$refresh',
        'tag-updated' => '$refresh',
    ];

    public function render(): View
    {
        $tags = auth()->user()->tags()
            ->when($this->search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%');
            })
            ->when($this->showOnlyMenuTags, function ($query) {
                return $query->where('in_menu', true);
            })
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.tags.tag-list', [
            'tags' => $tags,
        ]);
    }

    public function clearFilters()
    {
        $this->reset(['search', 'showOnlyMenuTags']);
    }

    public function toggleMenuStatus($tagId)
    {
        $tag = Tag::findOrFail($tagId);
        $tag->update([
            'in_menu' => !$tag->in_menu,
        ]);
        $this->dispatch('tag-updated');
    }

    public function deleteTag($tagId)
    {
        $tag = Tag::findOrFail($tagId);
        
        // Detach the tag from all tasks and projects before deleting
        $tag->tasks()->detach();
        $tag->projects()->detach();
        
        $tag->delete();
        $this->dispatch('tag-deleted');
    }
}