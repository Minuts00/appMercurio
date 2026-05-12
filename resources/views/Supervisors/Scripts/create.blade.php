<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carica script supervisore</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 2rem; }
        form { max-width: 760px; display: grid; gap: 1rem; }
        label { font-weight: 600; display: block; margin-bottom: .35rem; }
        select, textarea, button { width: 100%; padding: .7rem; font-size: 1rem; }
        .success { color: #0f5132; background: #d1e7dd; padding: .75rem; border-radius: 8px; }
        .error { color: #842029; background: #f8d7da; padding: .75rem; border-radius: 8px; }
    </style>
</head>
<body>
    @include('components.navbar')
    <h1>Carica script di ingresso o fine chiamata</h1>

    @if (session('status'))
        <p class="success">{{ session('status') }}</p>
    @endif

    @if ($errors->any())
        <div class="error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('supervisor.scripts.view.store') }}">
        @csrf

        <div>
            <label for="id_campaign">Campagna</label>
            <select name="id_campaign" id="id_campaign" required>
                <option value="">Seleziona campagna</option>
                @foreach ($campaigns as $campaign)
                    <option value="{{ $campaign->id }}" @selected(old('id_campaign') == $campaign->id)>{{ $campaign->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="id_category">Tipo script</label>
            <select name="id_category" id="id_category" required>
                <option value="">Seleziona tipo</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('id_category') == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="id_subcategory">Sottocategoria</label>
            <select name="id_subcategory" id="id_subcategory" required>
                <option value="">Seleziona sottocategoria</option>
            </select>
        </div>

        <div>
            <label for="responses">Contenuto script</label>
            <textarea name="responses" id="responses" maxlength="65000" required>{{ old('responses') }}</textarea>
        </div>

        <button type="submit">Salva script</button>
    </form>

    <script>
        const subcategoriesByCategory = @json($subcategoriesByCategory);
        const categorySelect = document.getElementById('id_category');
        const subcategorySelect = document.getElementById('id_subcategory');
        const oldSubcategoryId = '{{ old('id_subcategory') }}';

        function updateSubcategories() {
            const selectedCategoryId = categorySelect.value;
            const subcategories = subcategoriesByCategory[selectedCategoryId] || [];

            subcategorySelect.innerHTML = '<option value="">Seleziona sottocategoria</option>';

            if (subcategories.length === 0) {
                return;
            }

            subcategories.forEach(subcategory => {
                const option = document.createElement('option');
                option.value = subcategory.id;
                option.textContent = subcategory.name;
                if (String(subcategory.id) === oldSubcategoryId) {
                    option.selected = true;
                }
                subcategorySelect.appendChild(option);
            });
        }

        categorySelect.addEventListener('change', updateSubcategories);
        updateSubcategories();
    </script>
</body>
</html>