@extends('layouts.app')
@section('title', 'Inschrijven')

@section('content')
    <div class="bg-white rounded-lg shadow p-8 max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold text-amber-900 mb-2">Inschrijven</h1>
        <p class="text-amber-700 mb-6">{{ $event->title }} · {{ $event->event_date->format('d-m-Y') }}</p>

        <form action="{{ route('reservations.store', $event) }}" method="POST" class="space-y-4">
            @csrf

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-semibold mb-1">Naam</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           class="w-full border border-amber-300 rounded px-3 py-2" required>
                    @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block font-semibold mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="w-full border border-amber-300 rounded px-3 py-2" required>
                    @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-semibold mb-1">Telefoon</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="+32 4xx xx xx xx"
                           class="w-full border border-amber-300 rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block font-semibold mb-1">Aantal personen</label>
                    <input type="number" name="number_of_people" value="{{ old('number_of_people', 1) }}" min="1" max="20"
                           class="w-full border border-amber-300 rounded px-3 py-2" required>
                </div>
            </div>

            <div>
                <label class="block font-semibold mb-1">Opmerkingen (allergieën, ...)</label>
                <textarea name="notes" rows="2"
                          class="w-full border border-amber-300 rounded px-3 py-2">{{ old('notes') }}</textarea>
            </div>

            <h2 class="text-xl font-bold text-amber-900 pt-4">Kies je gerechten</h2>
            @error('dishes') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror

            <div class="space-y-2">
                @foreach ($event->dishes as $dish)
                    <div class="flex items-center justify-between border-b border-amber-100 py-2">
                        <div>
                            <span class="font-semibold">{{ $dish->name }}</span>
                            <span class="text-sm text-gray-500">({{ $dish->type }})</span>
                            <span class="ml-2 font-mono text-sm">€ {{ $dish->price_euro }}</span>
                        </div>
                        <input type="number" name="dishes[{{ $dish->id }}]" min="0" value="0"
                               class="w-20 border border-amber-300 rounded px-2 py-1 text-right">
                    </div>
                @endforeach
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit" class="bg-amber-900 text-amber-50 px-6 py-3 rounded font-semibold hover:bg-amber-800">
                    Inschrijving bevestigen
                </button>
                <a href="{{ route('events.show', $event) }}" class="px-6 py-3 text-gray-600 hover:text-gray-900">Annuleren</a>
            </div>
        </form>
    </div>
@endsection