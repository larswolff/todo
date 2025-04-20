<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    /**
     * Display a listing of projects.
     */
    public function index(): View
    {
        return view('projects.index', [
            'active' => 'projects',
        ]);
    }

    /**
     * Show the form for creating a new project.
     */
    public function create(): View
    {
        return view('projects.create', [
            'active' => 'projects',
        ]);
    }

    /**
     * Display the specified project.
     */
    public function show(Project $project): View
    {
        // Check if project belongs to the authenticated user
        if ($project->user_id !== auth()->id()) {
            abort(403);
        }
        
        return view('projects.show', [
            'project' => $project,
            'active' => 'projects',
        ]);
    }

    /**
     * Show the form for editing the specified project.
     */
    public function edit(Project $project): View
    {
        // Check if project belongs to the authenticated user
        if ($project->user_id !== auth()->id()) {
            abort(403);
        }
        
        return view('projects.edit', [
            'project' => $project,
            'active' => 'projects',
        ]);
    }
}