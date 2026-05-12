<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    // Admin dashboard: alle reservaties voor een event
    public function index(Request $request, Event $event)
    {
        $sort = $request->query('sort', 'created_at');
        $allowedSorts = ['name', 'created_at', 'number_of_people'];
        if (! in_array($sort, $allowedSorts, true)) {
            $sort = 'created_at';
        }

        $reservations = $event->reservations()
            ->with('dishes')
            ->orderBy($sort, $sort === 'created_at' ? 'desc' : 'asc')
            ->paginate(15)
            ->withQueryString();

        // Totalen per gerecht voor de kok
        $dishTotals = $event->dishes()->get()->map(function ($dish) {
            $total = \DB::table('dish_reservation')
                ->where('dish_id', $dish->id)
                ->sum('quantity');
            return [
                'name' => $dish->name,
                'type' => $dish->type,
                'total' => $total,
            ];
        });

        return view('reservations.index', compact('event', 'reservations', 'sort', 'dishTotals'));
    }

    public function create(Event $event)
    {
        if (! $event->registration_open) {
            return redirect()->route('events.show', $event)
                ->with('status', 'Inschrijvingen zijn gesloten.');
        }

        $event->load('dishes');
        return view('reservations.create', compact('event'));
    }

    public function store(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:30',
            'number_of_people' => 'required|integer|min:1|max:20',
            'notes' => 'nullable|string',
            'dishes' => 'required|array|min:1',
            'dishes.*' => 'integer|min:0',
        ]);

        $reservation = $event->reservations()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'number_of_people' => $validated['number_of_people'],
            'notes' => $validated['notes'] ?? null,
        ]);

        foreach ($validated['dishes'] as $dishId => $quantity) {
            if ($quantity > 0) {
                $reservation->dishes()->attach($dishId, ['quantity' => $quantity]);
            }
        }

        return redirect()->route('events.show', $event)
            ->with('status', 'Inschrijving gelukt! We zien je graag op ' . $event->event_date->format('d-m-Y') . '.');
    }

    public function markPaid(Reservation $reservation)
    {
        $reservation->update([
            'paid_at' => $reservation->paid_at ? null : now(),
        ]);

        return back();
    }
}