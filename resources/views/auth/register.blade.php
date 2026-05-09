<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrazione Admin</title>
</head>
<body>
    <h1>Registrazione primo utente (Admin)</h1>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('register.store') }}">
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
            <label for="password_confirmation">Conferma password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required minlength="8">
        </div>

        <button type="submit">Crea admin</button>
    </form>
</body>
</html>