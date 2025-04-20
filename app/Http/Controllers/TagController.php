<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TagController extends Controller
{
    /**
     * Display a listing of tags.
     */
    public function index(): View
    {
        return view('tags.index', [
            'active' => 'tags',
        ]);
    }

    /**
     * Show the form for creating a new tag.
     */
    public function create(): View
    {
        return view('tags.create', [
            'active' => 'tags',
        ]);
    }

    /**
     * Display the specified tag and related items.
     */
    public function show(Tag $tag): View
    {
        // Check if tag belongs to the authenticated user
        if ($tag->user_id !== auth()->id()) {
            abort(403);
        }
        
        return view('tags.show', [
            'tag' => $tag,
            'active' => 'tags.' . $tag->id,
        ]);
    }

    /**
     * Show the form for editing the specified tag.
     */
    public function edit(Tag $tag): View
    {
        // Check if tag belongs to the authenticated user
        if ($tag->user_id !== auth()->id()) {
            abort(403);
        }
        
        return view('tags.edit', [
            'tag' => $tag,
            'active' => 'tags',
        ]);
    }
}