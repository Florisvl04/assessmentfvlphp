<div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
        {{ __('Dashboard') }}
    </x-nav-link>

    @auth
        @php $role = Auth::user()->role; @endphp

        {{-- MONTEUR LINKS (Visible to Monteur OR Admin) --}}
        @if($role->value === 'monteur' || $role->value === 'admin')
            <x-nav-link :href="route('composer.create')" :active="request()->routeIs('composer.*')">
                🛠 {{ __('Bouw Voertuig') }}
            </x-nav-link>
        @endif

        {{-- PLANNER LINKS (Visible to Planner OR Admin) --}}
        @if($role->value === 'planner' || $role->value === 'admin')
            <x-nav-link :href="route('planning.index')" :active="request()->routeIs('planning.*')">
                📅 {{ __('Planning') }}
            </x-nav-link>
        @endif

        {{-- INKOPER LINKS (Visible to Inkoper OR Admin) --}}
        @if($role->value === 'inkoper' || $role->value === 'admin')
            <x-nav-link :href="route('modules.index')" :active="request()->routeIs('modules.*')">
                📦 {{ __('Magazijn') }}
            </x-nav-link>
        @endif

        {{-- KLANT LINKS (Visible to Klant OR Admin) --}}
        @if($role->value === 'klant' || $role->value === 'admin')
            <x-nav-link :href="route('customer.dashboard')" :active="request()->routeIs('customer.*')">
                🚗 {{ __('Mijn Voertuigen') }}
            </x-nav-link>
        @endif
    @endauth
</div>
