<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Caricamento anagrafiche</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-800 antialiased">
    @include('components.navbar')
    <main class="mx-auto max-w-4xl px-6 py-10">
        <section class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
            <h1 class="text-2xl font-bold text-slate-900">Caricamento anagrafiche</h1>
            <p class="mt-2 text-sm text-slate-600">Compila il form per inserire una nuova anagrafica nel sistema.</p>

            @if (session('status'))
                <div class="mt-6 rounded-lg border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-700">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mt-6 rounded-lg border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700">
                    <p class="font-semibold">Sono presenti errori nel form:</p>
                    <ul class="mt-2 list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('anagraphics.store') }}" class="mt-8 grid gap-5 md:grid-cols-2">
                @csrf

                <div>
                    <label for="name" class="mb-1 block text-sm font-medium text-slate-700">Nome *</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                </div>

                <div>
                    <label for="surname" class="mb-1 block text-sm font-medium text-slate-700">Cognome *</label>
                    <input id="surname" name="surname" type="text" value="{{ old('surname') }}" required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                </div>

                <div>
                    <label for="phone" class="mb-1 block text-sm font-medium text-slate-700">Telefono *</label>
                    <input id="phone" name="phone" type="text" value="{{ old('phone') }}" required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                </div>

                <div>
                    <label for="mail" class="mb-1 block text-sm font-medium text-slate-700">Email</label>
                    <input id="mail" name="mail" type="email" value="{{ old('mail') }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                </div>

                <div>
                    <label for="fiscalCode" class="mb-1 block text-sm font-medium text-slate-700">Codice fiscale</label>
                    <input id="fiscalCode" name="fiscalCode" type="text" value="{{ old('fiscalCode') }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                </div>

                <div>
                    <label for="identityDoc" class="mb-1 block text-sm font-medium text-slate-700">Documento identità</label>
                    <input id="identityDoc" name="identityDoc" type="text" value="{{ old('identityDoc') }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                </div>

                <div class="md:col-span-2">
                    <label for="address" class="mb-1 block text-sm font-medium text-slate-700">Indirizzo</label>
                    <input id="address" name="address" type="text" value="{{ old('address') }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                </div>

                <div>
                    <label for="POD" class="mb-1 block text-sm font-medium text-slate-700">POD</label>
                    <input id="POD" name="POD" type="text" value="{{ old('POD') }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                </div>

                <div>
                    <label for="PDR" class="mb-1 block text-sm font-medium text-slate-700">PDR</label>
                    <input id="PDR" name="PDR" type="text" value="{{ old('PDR') }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                </div>

                <div>
                    <label for="RID" class="mb-1 block text-sm font-medium text-slate-700">RID</label>
                    <input id="RID" name="RID" type="text" value="{{ old('RID') }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                </div>

                <div>
                    <label for="id_campaign" class="mb-1 block text-sm font-medium text-slate-700">Campagna *</label>
                    <select id="id_campaign" name="id_campaign" required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                        <option value="">Seleziona campagna</option>
                        @foreach ($campaigns as $campaign)
                            <option value="{{ $campaign->id }}" @selected((string) old('id_campaign') === (string) $campaign->id)>
                                {{ $campaign->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="lightOffer" class="mb-1 block text-sm font-medium text-slate-700">Offerta luce</label>
                    <input id="lightOffer" name="lightOffer" type="text" value="{{ old('lightOffer') }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                </div>

                <div>
                    <label for="gasOffer" class="mb-1 block text-sm font-medium text-slate-700">Offerta gas</label>
                    <input id="gasOffer" name="gasOffer" type="text" value="{{ old('gasOffer') }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                </div>

                <div class="flex items-center gap-2">
                    <input id="telco" name="telco" type="checkbox" value="1" @checked(old('telco')) class="h-4 w-4 rounded border-slate-300 text-slate-900">
                    <label for="telco" class="text-sm font-medium text-slate-700">Cliente telco</label>
                </div>

                <div class="md:col-span-2">
                    <label for="note" class="mb-1 block text-sm font-medium text-slate-700">Note</label>
                    <textarea id="note" name="note" rows="3" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">{{ old('note') }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label for="boNote" class="mb-1 block text-sm font-medium text-slate-700">Note back-office</label>
                    <textarea id="boNote" name="boNote" rows="3" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">{{ old('boNote') }}</textarea>
                </div>

                <div class="md:col-span-2 flex justify-end">
                    <button type="submit" class="rounded-lg bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-slate-700">
                        Salva anagrafica
                    </button>
                </div>
            </form>
        </section>
    </main>
</body>
</html>