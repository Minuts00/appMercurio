@php
    $user = auth()->user();
    $role = $user?->getRoleNames()?->first();

    $menu = [
        'admin' => [
            ['label' => 'Home', 'url' => url('/')],
            ['label' => 'Dashboard', 'url' => route('admin.users.create')],
            ['label' => 'Inserimento', 'dropdown' => [
                ['label' => 'Utenti', 'url' => route('admin.users.create')],
                ['label' => 'Campagne', 'url' => url('/campaigns')],
            ]],
        ],
        'supervisor' => [
            ['label' => 'Home', 'url' => url('/')],
            ['label' => 'Modifica anagrafica', 'url' => route('anagraphics.upload-form')],
            ['label' => 'Inserimento', 'dropdown' => [
                ['label' => 'Script', 'url' => route('supervisor.scripts.create')],
                ['label' => 'Gestione obiezioni', 'url' => route('supervisor.objections.upload')],
                ['label' => 'Categoria/Sottocategoria', 'url' => route('supervisor.categories.create')],
            ]],
        ],
        'user' => [
            ['label' => 'Home', 'url' => url('/')],
            ['label' => 'Carica anagrafica', 'url' => route('anagraphics.upload-form')],
            ['label' => 'Script', 'dropdown' => [
                ['label' => 'Ingresso chiamata', 'url' => '#'],
                ['label' => 'Chiusura chiamata', 'url' => '#'],
            ]],
            ['label' => 'Supporto', 'dropdown' => [
                ['label' => 'Luce', 'url' => '#'],
                ['label' => 'Gas', 'url' => '#'],
                ['label' => 'Telco', 'url' => '#'],
            ]],
        ],
    ];

    $items = $menu[$role] ?? [];
@endphp

@if(!empty($items))
<nav class="border-b border-slate-200 bg-white">
    <div class="mx-auto flex max-w-6xl items-center gap-2 px-6 py-3 text-sm font-medium text-slate-700">
        @foreach($items as $item)
            @if(isset($item['dropdown']))
                <details class="group relative">
                    <summary class="cursor-pointer list-none rounded-md px-3 py-2 hover:bg-slate-100">
                        {{ $item['label'] }}
                    </summary>
                    <div class="absolute left-0 z-10 mt-1 min-w-52 rounded-lg border border-slate-200 bg-white p-1 shadow-lg">
                        @foreach($item['dropdown'] as $subItem)
                            <a href="{{ $subItem['url'] }}" class="block rounded-md px-3 py-2 hover:bg-slate-100">
                                {{ $subItem['label'] }}
                            </a>
                        @endforeach
                    </div>
                </details>
            @else
                <a href="{{ $item['url'] }}" class="rounded-md px-3 py-2 hover:bg-slate-100">{{ $item['label'] }}</a>
            @endif
        @endforeach
    </div>
</nav>
@endif