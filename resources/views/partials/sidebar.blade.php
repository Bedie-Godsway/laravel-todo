@php
    $links = [
        'dashboard' => ['label' => 'Dashboard', 'icon' => 'fa-solid fa-gauge'],
        'todos'     => ['label' => 'Todo', 'icon' => 'fa-solid fa-list-check'],
        'profile'   => ['label' => 'Profile', 'icon' => 'fa-solid fa-user'],
        'settings'  => ['label' => 'Settings', 'icon' => 'fa-solid fa-gear'],
    ];
@endphp

<aside class="w-64 shrink-0 min-h-screen bg-[#0F1521] border-r border-white/5 flex flex-col">
    <nav class="flex-1 px-3 py-4 space-y-1">
        @foreach ($links as $route => ['label' => $label, 'icon' => $icon])
            @php $isActive = request()->is($route); @endphp

            <a href="{{ url($route) }}"
               class="group relative flex items-center gap-3 rounded-md px-3 py-2.5 text-sm font-medium transition-colors
                      {{ $isActive
                            ? 'text-white bg-white/[0.06]'
                            : 'text-slate-400 hover:text-slate-100 hover:bg-white/[0.04]' }}">
                @if ($isActive)
                    <span class="absolute left-0 top-1.5 bottom-1.5 w-[3px] rounded-full bg-teal-400"></span>
                @endif
                <i class="{{ $icon }} w-4 text-center"></i>
                {{ $label }}
            </a>
        @endforeach
    </nav>

    <div class="px-3 py-4 border-t border-white/5">
        <form method="POST" action="/logout">
            @csrf
            <button type="submit"
                    class="w-full flex items-center gap-3 rounded-md px-3 py-2.5 text-sm font-medium text-slate-400 hover:text-red-400 hover:bg-white/[0.04] transition-colors">
                <i class="fa-solid fa-right-from-bracket w-4 text-center"></i>
                Logout
            </button>
        </form>
    </div>
</aside>