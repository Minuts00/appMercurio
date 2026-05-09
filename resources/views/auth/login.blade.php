<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - {{ config('app.name', 'Mercurio') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-800 antialiased">
    <main class="mx-auto flex min-h-screen w-full max-w-md items-center px-6">
        <section class="w-full rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
            <h1 class="text-2xl font-bold text-slate-900">Accedi</h1>
            <p class="mt-2 text-sm text-slate-600">Inserisci le tue credenziali per accedere all'area riservata.</p>

            @if ($errors->any())
                <div class="mt-4 rounded-md border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                    Credenziali non valide. Riprova.
                </div>
            @endif

            <form method="POST" action="{{ route('login.attempt') }}" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label for="email" class="mb-1 block text-sm font-medium text-slate-700">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none ring-slate-900/10 placeholder:text-slate-400 focus:border-slate-900 focus:ring" placeholder="nome@azienda.it">
                </div>

                <div>
                    <label for="password" class="mb-1 block text-sm font-medium text-slate-700">Password</label>
                    <input id="password" name="password" type="password" required
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none ring-slate-900/10 placeholder:text-slate-400 focus:border-slate-900 focus:ring" placeholder="••••••••">
                </div>

                <div class="flex items-center justify-between text-sm">
                    <label class="inline-flex items-center gap-2 text-slate-600">
                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-slate-900 focus:ring-slate-900">
                        Ricordami
                    </label>
                </div>

                <button type="submit" class="w-full rounded-lg bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-700">
                    Entra
                </button>
            </form>
        </section>
    </main>
</body>
</html>