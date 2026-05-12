@extends('layouts.app')
@section('title', 'Alle eetfestijnen')

@section('content')
    <h1 class="text-3xl font-bold text-amber-900 mb-6">Eetfestijnen</h1>

    <div class="flex gap-2 mb-6">
        <a href="{{ route('events.index', ['filter' => 'upcoming']) }}"
           class="px-4 py-2 rounded {{ $filter === 'upcoming' ? 'bg-amber-900 text-amber-50' : 'bg-white text-amber-900 border border-amber-300' }}">
            Komende
        </a>
        <a href="{{ route('events.index', ['filter' => 'past']) }}"
           class="px-4 py-2 rounded {{ $filter === 'past' ? 'bg-amber-900 text-amber-50' : 'bg-white text-amber-900 border border-amber-300' }}">
            Voorbije
        </a>
        <a href="{{ route('events.index', ['filter' => 'all']) }}"
           class="px-4 py-2 rounded {{ $filter === 'all' ? 'bg-amber-900 text-amber-50' : 'bg-white text-amber-900 border border-amber-300' }}">
            Alle
        </a>
    </div>

    <div class="grid md:grid-cols-2 gap-4">
        @forelse ($events as $event)
            <a href="{{ route('events.show', $event) }}" class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                <h2 class="text-xl font-bold text-amber-900">{{ $event->title }}</h2>
                <p class="text-amber-700">📍 {{ $event->location }}</p>
                <p class="text-sm text-gray-600 mt-2">
                    🗓️ {{ $event->event_date->format('d-m-Y H:i') }}
                    ({{ $event->event_date->diffForHumans() }})
                </p>
                <p class="text-sm text-gray-600 mt-1">
                    👥 {{ $event->reservations_count }} reservaties
                </p>
                @if ($event->registration_open)
                    <span class="inline-block mt-3 bg-green-100 text-green-800 text-xs px-2 py-1 rounded">Inschrijven open</span>
                @else
                    <span class="inline-block mt-3 bg-gray-200 text-gray-700 text-xs px-2 py-1 rounded">Gesloten</span>
                @endif
            </a>
        @empty
            <p class="text-gray-600">Geen events gevonden.</p>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $events->links() }}
    </div>
@endsection