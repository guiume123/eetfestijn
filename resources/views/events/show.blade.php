@extends('layouts.app')
@section('title', $event->title)

@section('content')
    <div class="bg-white rounded-lg shadow p-8">
        <h1 class="text-3xl font-bold text-amber-900">{{ $event->title }}</h1>
        <p class="text-lg text-amber-700 mt-2">📍 {{ $event->location }}</p>
        <p class="text-gray-600 mt-1">🗓️ {{ $event->event_date->format('l d F Y · H:i') }}</p>
        <p class="text-sm text-gray-500 mt-1">
            Inschrijven kan tot {{ $event->registration_deadline->format('d-m-Y') }}
            ({{ $event->registration_deadline->diffForHumans() }})
        </p>

        @if ($event->description)
            <p class="mt-4 text-gray-700">{{ $event->description }}</p>
        @endif

        <h2 class="text-2xl font-bold text-amber-900 mt-8">Menu</h2>
        <ul class="mt-3 space-y-2">
            @foreach ($event->dishes as $dish)
                <li class="flex justify-between border-b border-amber-100 py-2">
                    <span>
                        <span class="font-semibold">{{ $dish->name }}</span>
                        <span class="text-sm text-gray-500">({{ $dish->type }})</span>
                    </span>
                    <span class="font-mono">€ {{ $dish->price_euro }}</span>
                </li>
            @endforeach
        </ul>

        <div class="mt-8 flex gap-3 flex-wrap">
            @if ($event->registration_open)
                <a href="{{ route('reservations.create', $event) }}"
                   class="bg-amber-900 text-amber-50 px-6 py-3 rounded font-semibold hover:bg-amber-800">
                    Inschrijven →
                </a>
            @endif
            <a href="{{ route('reservations.index', $event) }}"
               class="bg-white border border-amber-900 text-amber-900 px-6 py-3 rounded font-semibold hover:bg-amber-50">
                Dashboard
            </a>
            <a href="{{ route('events.edit', $event) }}"
               class="bg-white border border-gray-400 text-gray-700 px-6 py-3 rounded hover:bg-gray-50">
                Bewerken
            </a>
            <form action="{{ route('events.destroy', $event) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Zeker verwijderen?')"
                        class="bg-red-100 text-red-700 px-6 py-3 rounded hover:bg-red-200">
                    Verwijderen
                </button>
            </form>
        </div>
    </div>
@endsection