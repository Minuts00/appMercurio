<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caricamento Campagne</title>
</head>
<body>
    @include('components.navbar')
    <h1>Caricamento campagne</h1>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('admin.campaigns.store') }}">
        @csrf

        <div>
            <label for="name">Nome campagna</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required maxlength="255">
        </div>

        <button type="submit">Carica campagna</button>
    </form>

    <h2>Campagne esistenti</h2>
    <ul>
        @forelse ($campaigns as $campaign)
            <li>{{ $campaign->name }}</li>
        @empty
            <li>Nessuna campagna presente.</li>
        @endforelse
    </ul>
</body>
</html>