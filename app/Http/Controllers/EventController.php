<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'upcoming');
        $allowedFilters = ['upcoming', 'past', 'all'];
        if (! in_array($filter, $allowedFilters, true)) {
            $filter = 'upcoming';
        }

        $query = Event::query()->withCount('reservations');

        if ($filter === 'upcoming') {
            $query->where('event_date', '>=', now())->orderBy('event_date', 'asc');
        } elseif ($filter === 'past') {
            $query->where('event_date', '<', now())->orderBy('event_date', 'desc');
        } else {
            $query->orderBy('event_date', 'desc');
        }

        $events = $query->paginate(10)->withQueryString();

        return view('events.index', compact('events', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date|after:today',
            'registration_deadline' => 'required|date|before_or_equal:event_date',
        ]);

        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(5);

        Event::create($validated);

        return redirect()->route('events.index')->with('status', 'Eetfestijn aangemaakt!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $event->load('dishes');
        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date',
            'registration_deadline' => 'required|date|before_or_equal:event_date',
        ]);

        $event->update($validated);

        return redirect()->route('events.show', $event)->with('status', 'Aangepast!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('events.index')->with('status', 'Verwijderd!');
    }
}