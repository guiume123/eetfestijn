@extends('layouts.app')
@section('title', 'Dashboard ' . $event->title)

@section('content')
    <a href="{{ route('events.show', $event) }}" class="text-amber-700 hover:underline">← terug naar event</a>

    <h1 class="text-3xl font-bold text-amber-900 mt-2 mb-2">Dashboard</h1>
    <p class="text-amber-700 mb-6">{{ $event->title }}</p>

    <div class="grid md:grid-cols-2 gap-4 mb-8">
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="font-bold text-amber-900 mb-3">📊 Totalen per gerecht (voor de kok)</h2>
            <ul class="space-y-1">
                @foreach ($dishTotals as $row)
                    <li class="flex justify-between">
                        <span>{{ $row['name'] }} <span class="text-xs text-gray-500">({{ $row['type'] }})</span></span>
                        <span class="font-bold">{{ $row['total'] }}×</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="font-bold text-amber-900 mb-3">👥 Reservaties</h2>
            <p class="text-3xl font-bold text-amber-900">{{ $reservations->total() }}</p>
            <p class="text-gray-600">inschrijvingen</p>
            <p class="text-3xl font-bold text-amber-900 mt-3">{{ $event->total_reserved_people }}</p>
            <p class="text-gray-600">personen totaal</p>
        </div>
    </div>

    <div class="mb-3 flex gap-2 text-sm">
        Sorteer:
        <a href="{{ route('reservations.index', ['event' => $event, 'sort' => 'created_at']) }}"
           class="{{ $sort === 'created_at' ? 'font-bold text-amber-900' : 'text-amber-700' }} hover:underline">recentste eerst</a>
        <a href="{{ route('reservations.index', ['event' => $event, 'sort' => 'name']) }}"
           class="{{ $sort === 'name' ? 'font-bold text-amber-900' : 'text-amber-700' }} hover:underline">naam</a>
        <a href="{{ route('reservations.index', ['event' => $event, 'sort' => 'number_of_people']) }}"
           class="{{ $sort === 'number_of_people' ? 'font-bold text-amber-900' : 'text-amber-700' }} hover:underline">grootste eerst</a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-amber-100 text-amber-900">
                <tr>
                    <th class="text-left px-4 py-2">Naam</th>
                    <th class="text-left px-4 py-2">Contact</th>
                    <th class="text-right px-4 py-2">Pers.</th>
                    <th class="text-right px-4 py-2">Totaal</th>
                    <th class="text-center px-4 py-2">Betaald</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reservations as $r)
                    <tr class="border-t border-amber-100">
                        <td class="px-4 py-3">
                            <div class="font-semibold">{{ $r->name }}</div>
                            <div class="text-xs text-gray-500">{{ $r->created_at->diffForHumans() }}</div>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <div>{{ $r->email }}</div>
                            <div class="text-gray-500">{{ $r->phone }}</div>
                        </td>
                        <td class="px-4 py-3 text-right font-mono">{{ $r->number_of_people }}</td>
                        <td class="px-4 py-3 text-right font-mono">{{ $r->total_price_euro }}</td>
                        <td class="px-4 py-3 text-center">
                            <form action="{{ route('reservations.mark-paid', $r) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-xs px-2 py-1 rounded
                                        {{ $r->is_paid ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-700 hover:bg-amber-100' }}">
                                    {{ $r->is_paid ? '✓ betaald' : 'markeer betaald' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-6 text-center text-gray-500">Geen reservaties.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $reservations->links() }}</div>
@endsection