<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Mercurio') }}</title>
     <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-50 text-slate-800 antialiased">
        <x-navbar />
     <main class="mx-auto max-w-6xl px-6 py-12">
        <section id="panoramica" class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Benvenuto</p>
            <h2 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">
                Home dell'applicativo
            </h2>
            <p class="mt-4 max-w-2xl leading-relaxed text-slate-600">
                Questa è la pagina principale da cui iniziare: trovi una panoramica chiara dello stato operativo,
                accesso rapido alle aree più utili e una struttura leggibile pensata per l'uso quotidiano.
            </p>
                <div class="mt-6 flex flex-wrap gap-3">
                <a href="#funzionalita" class="rounded-lg bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-slate-700">
                    Vai alle funzionalità
                </a>
                <a href="#supporto" class="rounded-lg border border-slate-300 px-5 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-100">
                    Contatta supporto
                </a>
                  @guest
                    <a href="{{ route('login') }}" class="rounded-md border border-slate-300 px-3 py-1.5 font-semibold text-slate-700 hover:bg-slate-100">Login</a>
                @endguest
                @auth
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="rounded-md border border-slate-300 px-3 py-1.5 font-semibold text-slate-700 hover:bg-slate-100">Logout</button>
                    </form>
                @endauth
            </div>
        </section>

        <section class="mt-8 grid gap-4 sm:grid-cols-3">
            <article class="rounded-xl border border-slate-200 bg-white p-5">
                <p class="text-sm text-slate-500">Attività completate</p>
                <p class="mt-1 text-2xl font-semibold text-slate-900">24</p>
            </article>
            <article class="rounded-xl border border-slate-200 bg-white p-5">
                <p class="text-sm text-slate-500">In approvazione</p>
                <p class="mt-1 text-2xl font-semibold text-slate-900">8</p>
            </article>
            <article class="rounded-xl border border-slate-200 bg-white p-5">
                <p class="text-sm text-slate-500">Segnalazioni aperte</p>
                <p class="mt-1 text-2xl font-semibold text-slate-900">3</p>
            </article>
        </section>
      <section id="funzionalita" class="mt-10">
            <h3 class="text-xl font-semibold text-slate-900">Funzionalità principali</h3>
            <div class="mt-4 grid gap-4 md:grid-cols-3">
                <article class="rounded-xl border border-slate-200 bg-white p-5">
                    <h4 class="font-semibold text-slate-900">Gestione attività</h4>
                    <p class="mt-2 text-sm leading-relaxed text-slate-600">Organizza task e priorità in modo ordinato e immediato.</p>
                </article>
                <article class="rounded-xl border border-slate-200 bg-white p-5">
                    <h4 class="font-semibold text-slate-900">Collaborazione team</h4>
                    <p class="mt-2 text-sm leading-relaxed text-slate-600">Condividi aggiornamenti e responsabilità in un unico flusso.</p>
                </article>
                <article class="rounded-xl border border-slate-200 bg-white p-5">
                    <h4 class="font-semibold text-slate-900">Monitoraggio risultati</h4>
                    <p class="mt-2 text-sm leading-relaxed text-slate-600">Controlla indicatori chiave e andamento operativo in tempo reale.</p>
                </article>
            </div>
        </section>
    </main>
         <footer id="supporto" class="border-t border-slate-200 bg-white py-6">
        <div class="mx-auto flex max-w-6xl flex-col gap-2 px-6 text-sm text-slate-500 md:flex-row md:items-center md:justify-between">
            <p>© {{ date('Y') }} {{ config('app.name', 'Mercurio') }}. Tutti i diritti riservati.</p>
            <p>Supporto: <a href="mailto:supporto@mercurio.app" class="font-medium text-slate-700 hover:text-slate-900">supporto@mercurio.app</a></p>
        </div>
          </footer>
    </body>
</html>