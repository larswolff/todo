<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    /**
     * Display a listing of tasks.
     */
    public function index(): View
    {
        return view('tasks.index', [
            'active' => 'tasks',
        ]);
    }

    /**
     * Show the form for creating a new task.
     */
    public function create(Request $request): View
    {
        $projectId = $request->query('project_id');
        
        return view('tasks.create', [
            'projectId' => $projectId,
            'active' => 'tasks',
        ]);
    }

    /**
     * Display the specified task.
     */
    public function show(Task $task): View
    {
        // Check if task belongs to the authenticated user
        if ($task->user_id !== auth()->id()) {
            abort(403);
        }
        
        return view('tasks.show', [
            'task' => $task,
            'active' => 'tasks',
        ]);
    }

    /**
     * Show the form for editing the specified task.
     */
    public function edit(Task $task): View
    {
        // Check if task belongs to the authenticated user
        if ($task->user_id !== auth()->id()) {
            abort(403);
        }
        
        return view('tasks.edit', [
            'task' => $task,
            'active' => 'tasks',
        ]);
    }
    
    /**
     * Display the inbox view (all uncategorized tasks).
     */
    public function inbox(): View
    {
        return view('tasks.inbox', [
            'active' => 'inbox',
        ]);
    }
    
    /**
     * Display tasks due today.
     */
    public function today(): View
    {
        return view('tasks.today', [
            'active' => 'today',
        ]);
    }
    
    /**
     * Display next tasks.
     */
    public function next(): View
    {
        return view('tasks.next', [
            'active' => 'next',
        ]);
    }
    
    /**
     * Display waiting tasks.
     */
    public function waiting(): View
    {
        return view('tasks.waiting', [
            'active' => 'waiting',
        ]);
    }
    
    /**
     * Display someday tasks.
     */
    public function someday(): View
    {
        return view('tasks.someday', [
            'active' => 'someday',
        ]);
    }
    
    /**
     * Display upcoming tasks.
     */
    public function upcoming(): View
    {
        return view('tasks.upcoming', [
            'active' => 'upcoming',
        ]);
    }
    
    /**
     * Display the review page.
     */
    public function review(): View
    {
        return view('tasks.review', [
            'active' => 'review',
        ]);
    }
}