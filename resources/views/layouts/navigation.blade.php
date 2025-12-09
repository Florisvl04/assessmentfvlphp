<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @auth
                        @php $role = Auth::user()->role; @endphp
                        {{-- MONTEUR LINKS --}}


                        @if($role->value === 'monteur' || $role->value === 'admin')
                            <x-nav-link :href="route('composer.create')" :active="request()->routeIs('composer.*')">
                                {{ __('Bouw Voertuig') }}
                            </x-nav-link>
                        @endif

                        {{-- PLANNER LINKS --}}
                        @if($role->value === 'planner' || $role->value === 'admin')
                            <x-nav-link :href="route('planning.index')" :active="request()->routeIs('planning.*')">
                                {{ __('Planning') }}
                            </x-nav-link>
                        @endif

                        {{-- INKOPER LINKS --}}
                        @if($role->value === 'inkoper' || $role->value === 'admin')
                            <x-nav-link :href="route('modules.index')" :active="request()->routeIs('modules.*')">
                                {{ __('Magazijn') }}
                            </x-nav-link>
                        @endif

                        {{-- KLANT LINKS --}}
                        @if($role->value === 'klant' || $role->value === 'admin')
                            <x-nav-link :href="route('customer.dashboard')" :active="request()->routeIs('customer.*')">
                                {{ __('Mijn Voertuigen') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">

                {{-- Role Badge --}}
                <span class="mr-4 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide
                    {{ match(Auth::user()->role->value) {
                        'monteur' => 'bg-orange-100 text-orange-800',
                        'planner' => 'bg-purple-100 text-purple-800',
                        'inkoper' => 'bg-blue-100 text-blue-800',
                        default   => 'bg-green-100 text-green-800'
                    } }}">
                    {{ Auth::user()->role->label() }}
                </span>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profiel') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                             onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Uitloggen') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</nav>
