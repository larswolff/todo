<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AreaController extends Controller
{
    /**
     * Display a listing of areas.
     */
    public function index(): View
    {
        return view('areas.index', [
            'active' => 'areas',
        ]);
    }

    /**
     * Show the form for creating a new area.
     */
    public function create(): View
    {
        return view('areas.create', [
            'active' => 'areas',
        ]);
    }

    /**
     * Display the specified area.
     */
    public function show(Area $area): View
    {
        // Check if area belongs to the authenticated user
        if ($area->user_id !== auth()->id()) {
            abort(403);
        }
        
        return view('areas.show', [
            'area' => $area,
            'active' => 'areas',
        ]);
    }

    /**
     * Show the form for editing the specified area.
     */
    public function edit(Area $area): View
    {
        // Check if area belongs to the authenticated user
        if ($area->user_id !== auth()->id()) {
            abort(403);
        }
        
        return view('areas.edit', [
            'area' => $area,
            'active' => 'areas',
        ]);
    }
}