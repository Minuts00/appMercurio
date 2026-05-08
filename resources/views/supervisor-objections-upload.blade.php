<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Caricamento gestione obiezioni cliente</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-800 antialiased">
    @include('components.navbar')
<main class="mx-auto max-w-3xl px-6 py-10">
    <section class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
        <h1 class="text-2xl font-bold text-slate-900">Caricamento gestione obiezioni cliente</h1>
        <p class="mt-2 text-sm text-slate-600">Compila i campi richiesti per salvare una nuova obiezione cliente.</p>

        <form id="objection-form" class="mt-8 space-y-5">
            @csrf

            <div>
                <label for="id_campaign" class="block text-sm font-medium text-slate-700">Campagna</label>
                <select id="id_campaign" name="id_campaign" required class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                    <option value="">Seleziona campagna</option>
                    @foreach ($campaigns as $campaign)
                        <option value="{{ $campaign->id }}">{{ $campaign->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="id_category" class="block text-sm font-medium text-slate-700">Categoria</label>
                <select id="id_category" name="id_category" required class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                    <option value="">Seleziona categoria</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="id_subcategory" class="block text-sm font-medium text-slate-700">Sottocategoria</label>
                <select id="id_subcategory" name="id_subcategory" required class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                    <option value="">Seleziona prima una categoria</option>
                </select>
            </div>

            <div>
                <label for="responses" class="block text-sm font-medium text-slate-700">Gestione obiezione</label>
                <textarea id="responses" name="responses" rows="6" required class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" placeholder="Inserisci la risposta da fornire al cliente"></textarea>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="rounded-lg bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-slate-700">Salva obiezione</button>
                <p id="form-feedback" class="text-sm"></p>
            </div>
        </form>
    </section>
</main>

<script>
    const categorySelect = document.getElementById('id_category');
    const subcategorySelect = document.getElementById('id_subcategory');
    const subcategoriesByCategory = @json($subcategoriesByCategory);

    categorySelect.addEventListener('change', () => {
        const categoryId = categorySelect.value;
        const subcategories = subcategoriesByCategory[categoryId] || [];

        subcategorySelect.innerHTML = '';

        if (subcategories.length === 0) {
            subcategorySelect.innerHTML = '<option value="">Nessuna sottocategoria disponibile</option>';
            return;
        }

        subcategorySelect.innerHTML = '<option value="">Seleziona sottocategoria</option>';

        subcategories.forEach((subcategory) => {
            const option = document.createElement('option');
            option.value = subcategory.id;
            option.textContent = subcategory.name;
            subcategorySelect.appendChild(option);
        });
    });

    document.getElementById('objection-form').addEventListener('submit', async (event) => {
        event.preventDefault();
        const feedback = document.getElementById('form-feedback');
        const formData = new FormData(event.target);

        feedback.textContent = 'Salvataggio in corso...';
        feedback.className = 'text-sm text-slate-500';

        const response = await fetch("{{ route('supervisor.objections.store') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': formData.get('_token'),
                'Accept': 'application/json',
            },
            body: formData,
        });

        if (response.ok) {
            event.target.reset();
            subcategorySelect.innerHTML = '<option value="">Seleziona prima una categoria</option>';
            feedback.textContent = 'Obiezione salvata con successo.';
            feedback.className = 'text-sm text-emerald-600';
            return;
        }

        const payload = await response.json();
        feedback.textContent = payload.message || 'Errore durante il salvataggio dell\'obiezione.';
        feedback.className = 'text-sm text-rose-600';
    });
</script>
</body>
</html>