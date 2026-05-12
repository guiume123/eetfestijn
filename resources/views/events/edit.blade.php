@extends('layouts.app')
@section('title', 'Event bewerken')

@section('content')
    <div class="bg-white rounded-lg shadow p-8 max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold text-amber-900 mb-6">Event bewerken</h1>

        <form action="{{ route('events.update', $event) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-semibold mb-1">Titel</label>
                <input type="text" name="title" value="{{ old('title', $event->title) }}"
                       class="w-full border border-amber-300 rounded px-3 py-2" required>
                @error('title') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block font-semibold mb-1">Locatie</label>
                <input type="text" name="location" value="{{ old('location', $event->location) }}"
                       class="w-full border border-amber-300 rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block font-semibold mb-1">Beschrijving</label>
                <textarea name="description" rows="3"
                          class="w-full border border-amber-300 rounded px-3 py-2">{{ old('description', $event->description) }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-semibold mb-1">Datum event</label>
                    <input type="datetime-local" name="event_date"
                           value="{{ old('event_date', $event->event_date->format('Y-m-d\TH:i')) }}"
                           class="w-full border border-amber-300 rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block font-semibold mb-1">Inschrijfdeadline</label>
                    <input type="datetime-local" name="registration_deadline"
                           value="{{ old('registration_deadline', $event->registration_deadline->format('Y-m-d\TH:i')) }}"
                           class="w-full border border-amber-300 rounded px-3 py-2" required>
                </div>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit" class="bg-amber-900 text-amber-50 px-6 py-3 rounded font-semibold hover:bg-amber-800">
                    Opslaan
                </button>
                <a href="{{ route('events.show', $event) }}" class="px-6 py-3 text-gray-600 hover:text-gray-900">Annuleren</a>
            </div>
        </form>
    </div>
@endsection