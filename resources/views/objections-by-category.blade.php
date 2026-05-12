<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Mercurio') }} - Obiezioni {{ ucfirst($categoryName) }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-800 antialiased">
    <x-navbar />

    <main class="mx-auto max-w-6xl px-6 py-12">
        <section class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Obiezioni</p>
            <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">
                {{ ucfirst($categoryName) }}
            </h1>

            @if($objections->isEmpty())
                <p class="mt-4 text-slate-600">Nessuna obiezione disponibile per questa categoria.</p>
            @else
                <div class="mt-6 space-y-4">
                    @foreach($objections as $objection)
                        <article class="rounded-xl border border-slate-200 bg-slate-50 p-5">
                            <div class="flex flex-wrap items-center gap-3 text-sm text-slate-600">
                                <span class="rounded-md bg-white px-2 py-1 border border-slate-200">Campagna: {{ $objection->campaign->name ?? 'N/A' }}</span>
                                <span class="rounded-md bg-white px-2 py-1 border border-slate-200">Sottocategoria: {{ $objection->subcategory->name ?? 'N/A' }}</span>
                            </div>
                            <p class="mt-3 whitespace-pre-line text-slate-800">{{ $objection->responses }}</p>
                        </article>
                    @endforeach
                </div>
            @endif
        </section>
    </main>
</body>
</html>