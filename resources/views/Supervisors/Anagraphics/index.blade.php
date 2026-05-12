<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Seleziona anagrafica da modificare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-800 antialiased">
    @php($anagraphicsList = $anagraphics ?? null)
    @include('components.navbar')
    <main class="mx-auto max-w-7xl px-6 py-10">
        <section class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
            <h1 class="text-2xl font-bold text-slate-900">Modifica anagrafica</h1>
            <p class="mt-1 text-sm text-slate-600">Seleziona un'anagrafica per aprire la pagina di modifica dedicata.</p>

            <div class="mt-8 overflow-x-auto rounded-xl border border-slate-200">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-100 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">
                        <tr>
                            <th class="px-4 py-3">Nome</th>
                            <th class="px-4 py-3">Contatti</th>
                            <th class="px-4 py-3">Campagna</th>
                            <th class="px-4 py-3">Data inserimento</th>
                            <th class="px-4 py-3">Azione</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse (($anagraphicsList ?? collect()) as $anagraphic)
                            <tr class="align-top">
                                <td class="px-4 py-3 font-medium text-slate-900">{{ $anagraphic->name }} {{ $anagraphic->surname }}</td>
                                <td class="px-4 py-3 text-slate-600">
                                    <div>{{ $anagraphic->phone }}</div>
                                    <div>{{ $anagraphic->mail ?: '—' }}</div>
                                </td>
                                <td class="px-4 py-3 text-slate-600">{{ $anagraphic->campaign?->name ?? '—' }}</td>
                                <td class="px-4 py-3 text-slate-600">{{ $anagraphic->created_at?->format('d/m/Y H:i') }}</td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('supervisors.anagraphics.edit', $anagraphic) }}" class="inline-flex items-center rounded-lg bg-slate-900 px-3 py-2 text-xs font-semibold text-white hover:bg-slate-700">
                                        Modifica
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-slate-500">Nessuna anagrafica disponibile.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                @if ($anagraphicsList && method_exists($anagraphicsList, 'links'))
                    {{ $anagraphicsList->links() }}
                @endif
            </div>
        </section>
    </main>
</body>
</html>