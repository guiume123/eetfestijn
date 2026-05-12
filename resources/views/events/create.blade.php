@extends('layouts.app')
@section('title', 'Nieuw event')

@section('content')
    <div class="bg-white rounded-lg shadow p-8 max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold text-amber-900 mb-6">Nieuw eetfestijn</h1>

        <form action="{{ route('events.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block font-semibold mb-1">Titel</label>
                <input type="text" name="title" value="{{ old('title') }}"
                       class="w-full border border-amber-300 rounded px-3 py-2 @error('title') border-red-500 @enderror" required>
                @error('title') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block font-semibold mb-1">Locatie</label>
                <input type="text" name="location" value="{{ old('location') }}"
                       class="w-full border border-amber-300 rounded px-3 py-2 @error('location') border-red-500 @enderror" required>
                @error('location') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block font-semibold mb-1">Beschrijving</label>
                <textarea name="description" rows="3"
                          class="w-full border border-amber-300 rounded px-3 py-2">{{ old('description') }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-semibold mb-1">Datum event</label>
                    <input type="datetime-local" name="event_date" value="{{ old('event_date') }}"
                           class="w-full border border-amber-300 rounded px-3 py-2 @error('event_date') border-red-500 @enderror" required>
                    @error('event_date') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block font-semibold mb-1">Inschrijfdeadline</label>
                    <input type="datetime-local" name="registration_deadline" value="{{ old('registration_deadline') }}"
                           class="w-full border border-amber-300 rounded px-3 py-2 @error('registration_deadline') border-red-500 @enderror" required>
                    @error('registration_deadline') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit" class="bg-amber-900 text-amber-50 px-6 py-3 rounded font-semibold hover:bg-amber-800">
                    Aanmaken
                </button>
                <a href="{{ route('events.index') }}" class="px-6 py-3 text-gray-600 hover:text-gray-900">Annuleren</a>
            </div>
        </form>
    </div>
@endsection