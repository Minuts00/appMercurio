<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Anagrafiche</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-800 antialiased">
    @include('components.navbar')
    <main class="mx-auto max-w-7xl px-6 py-10">
        <section class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
            <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">Dashboard anagrafiche</h1>
                    <p class="mt-1 text-sm text-slate-600">Elenco completo delle anagrafiche raccolte nel sistema.</p>
                </div>
                <a href="{{ route('anagraphics.upload-form') }}" class="inline-flex items-center rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700">
                    Nuova anagrafica
                </a>
            </div>

            <div class="mt-8 overflow-x-auto rounded-xl border border-slate-200">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-100 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">
                        <tr>
                            <th class="px-4 py-3">Nome</th>
                            <th class="px-4 py-3">Contatti</th>
                            <th class="px-4 py-3">Campagna</th>
                            <th class="px-4 py-3">Codice fiscale</th>
                            <th class="px-4 py-3">Telco</th>
                            <th class="px-4 py-3">Data inserimento</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse ($anagraphics as $anagraphic)
                            <tr class="align-top">
                                <td class="px-4 py-3 font-medium text-slate-900">
                                    {{ $anagraphic->name }} {{ $anagraphic->surname }}
                                </td>
                                <td class="px-4 py-3 text-slate-600">
                                    <div>{{ $anagraphic->phone }}</div>
                                    <div>{{ $anagraphic->mail ?: '—' }}</div>
                                </td>
                                <td class="px-4 py-3 text-slate-600">{{ $anagraphic->campaign?->name ?? '—' }}</td>
                                <td class="px-4 py-3 text-slate-600">{{ $anagraphic->fiscalCode ?: '—' }}</td>
                                <td class="px-4 py-3 text-slate-600">{{ $anagraphic->telco ? 'Sì' : 'No' }}</td>
                                <td class="px-4 py-3 text-slate-600">{{ $anagraphic->created_at?->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-slate-500">Nessuna anagrafica disponibile.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $anagraphics->links() }}
            </div>
            <div class="mt-12">
                <h2 class="text-xl font-bold text-slate-900">Utenti registrati</h2>
                <p class="mt-1 text-sm text-slate-600">Raccolta completa degli utenti presenti in piattaforma.</p>
            </div>

            <div class="mt-6 overflow-x-auto rounded-xl border border-slate-200">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-100 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">
                        <tr>
                            <th class="px-4 py-3">Email</th>
                            <th class="px-4 py-3">Ruolo</th>
                            <th class="px-4 py-3">Campagna</th>
                            <th class="px-4 py-3">Stato</th>
                            <th class="px-4 py-3">Azione</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse ($users as $user)
                            <tr class="align-top">
                                <td class="px-4 py-3 font-medium text-slate-900">{{ $user->email }}</td>
                                <td class="px-4 py-3 text-slate-600">{{ $user->roles->pluck('name')->implode(', ') ?: '—' }}</td>
                                <td class="px-4 py-3 text-slate-600">{{ $user->campaign?->name ?? '—' }}</td>
                                <td class="px-4 py-3 text-slate-600">{{ $user->is_active ? 'Attivo' : 'Non attivo' }}</td>
                                <td class="px-4 py-3 text-slate-600">
                                    @if ($user->is_active)
                                        <form method="POST" action="{{ route('admin.users.disable', $user) }}" onsubmit="return confirm('Confermi la disabilitazione dell\'utente?');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="inline-flex items-center rounded-lg bg-red-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-red-500">
                                                Disabilita utente
                                            </button>
                                        </form>
                                    @else
                                        <span class="inline-flex items-center rounded-lg bg-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-700">
                                            Utente disabilitato
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-slate-500">Nessun utente registrato.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>