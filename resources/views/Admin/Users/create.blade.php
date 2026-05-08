<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creazione Utente</title>
</head>
<body>
    <h1>Carica nuovo utente</h1>

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

    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf

        <div>
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div>
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required minlength="8">
        </div>

        <div>
            <label for="role">Ruolo</label>
            <select id="role" name="role" required>
                <option value="">Seleziona un ruolo</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->name }}" @selected(old('role') === $role->name)>
                        {{ ucfirst($role->name) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="id_campaign">Campagna</label>
            <select id="id_campaign" name="id_campaign">
                <option value="">Nessuna campagna</option>
                @foreach ($campaigns as $campaign)
                    <option value="{{ $campaign->id }}" @selected((string) old('id_campaign') === (string) $campaign->id)>
                        {{ $campaign->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label>
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', true))>
                Utente attivo
            </label>
        </div>

        <button type="submit">Crea utente</button>
    </form>
</body>
</html>