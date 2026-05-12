<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Eetfestijn') · Eetfestijn</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-amber-50 min-h-screen">
    <header class="bg-amber-900 text-amber-50 shadow-lg">
        <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
            <a href="{{ route('events.index') }}" class="text-2xl font-bold">🍽️ Eetfestijn</a>
            <nav class="flex gap-4">
                <a href="{{ route('events.index') }}" class="hover:underline">Events</a>
                <a href="{{ route('events.create') }}" class="bg-amber-50 text-amber-900 px-3 py-1 rounded font-semibold hover:bg-amber-100">+ Nieuw event</a>
            </nav>
        </div>
    </header>

    @if (session('status'))
        <div class="max-w-6xl mx-auto mt-4 px-4">
            <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded">
                {{ session('status') }}
            </div>
        </div>
    @endif

    <main class="max-w-6xl mx-auto px-4 py-8">
        @yield('content')
    </main>

    <footer class="text-center text-amber-700 text-sm py-6">
        Eetfestijn · Belgisch verenigingsleven, één bord per keer.
    </footer>
</body>
</html>