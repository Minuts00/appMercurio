<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestione categorie supervisore</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-800 antialiased">
    @include('components.navbar')
<main class="mx-auto max-w-4xl px-6 py-10">
    <h1 class="text-2xl font-bold text-slate-900">Gestione categorie e sottocategorie</h1>
    <p class="mt-2 text-sm text-slate-600">Area dedicata ai supervisori per aggiungere nuove categorie e sottocategorie.</p>

    <section class="mt-8 grid gap-6 md:grid-cols-2">
        <article class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900">Nuova categoria</h2>
            <form class="mt-4 space-y-4" method="POST" action="{{ route('supervisors.categories.store') }}">
                @csrf
                <div>
                    <label for="category-name" class="mb-1 block text-sm font-medium text-slate-700">Nome categoria</label>
                    <input id="category-name" name="name" type="text" required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-slate-500 focus:outline-none" placeholder="Es. Assistenza clienti">
                </div>
                <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700">Aggiungi categoria</button>
            </form>
        </article>

        <article class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900">Nuova sottocategoria</h2>
            <form class="mt-4 space-y-4" method="POST" action="{{ route('supervisors.subcategories.store') }}">
                @csrf
                <div>
                    <label for="subcategory-name" class="mb-1 block text-sm font-medium text-slate-700">Nome sottocategoria</label>
                    <input id="subcategory-name" name="name" type="text" required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-slate-500 focus:outline-none" placeholder="Es. Reclami">
                </div>
                <div>
                    <label for="id_category" class="mb-1 block text-sm font-medium text-slate-700">Categoria di riferimento</label>
                    <select id="id_category" name="id_category" required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-slate-500 focus:outline-none">
                        <option value="">Seleziona una categoria</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700">Aggiungi sottocategoria</button>
            </form>
        </article>
@if (session('success'))
    <script>
        alert(@json(session('success')));
    </script>
@endif
    </section>
</main>
</body>
</html>
