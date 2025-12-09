<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white leading-tight">
            {{ __('Welkom bij Future Factory, ') }} <span class="text-indigo-400">{{ Auth::user()->name }}</span>!
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">

                @php $role = Auth::user()->role; @endphp

                @if($role->value === 'monteur' || $role->value === 'admin')
                    <div class="bg-gray-800 rounded-lg shadow-xl border border-gray-700 overflow-hidden">
                        <div class="p-6">
                            <div class="mb-4 border-b border-amber-500 pb-2">
                                <h3 class="text-xl font-extrabold text-white">Nieuw Project Starten</h3>
                            </div>
                            <p class="text-gray-400 mb-6">Stel een nieuw voertuig samen voor een klant. Zorg voor compatibiliteit bij wielen en chassis.</p>
                            <a href="{{ route('composer.create') }}" class="w-full inline-flex justify-center items-center bg-amber-600 hover:bg-amber-500 text-white font-semibold py-3 px-6 rounded-lg transition duration-150 shadow-lg">
                                Naar de Configurator &rarr;
                            </a>
                        </div>
                    </div>
                @endif

                @if($role->value === 'planner' || $role->value === 'admin')
                    <div class="bg-gray-800 rounded-lg shadow-xl border border-gray-700 overflow-hidden flex flex-col justify-between">
                        <div class="p-6">
                            <div class="mb-4 border-b border-indigo-500 pb-2">
                                <h3 class="text-xl font-extrabold text-white">Planning Beheren</h3>
                            </div>
                            <p class="text-gray-400 mb-6">Bekijk het rooster, wijs robots toe aan orders en volg de voortgang.</p>

                            <div class="flex flex-col gap-3">
                                <a href="{{ route('planning.index') }}" class="w-full inline-flex justify-center items-center bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-3 px-6 rounded-lg transition duration-150 shadow-lg">
                                    Open Kalender &rarr;
                                </a>

                                <a href="{{ route('planning.overview') }}" class="w-full inline-flex justify-center items-center bg-gray-700 hover:bg-gray-600 border border-indigo-500 text-white font-semibold py-3 px-6 rounded-lg transition duration-150 shadow-lg">
                                    Bekijk Voortgangsrapport
                                </a>
                            </div>
                        </div>
                        <div class="px-6 pb-4 pt-4 border-t border-gray-700 bg-gray-900/50">
                            <h4 class="text-sm font-semibold text-white mb-1">Robot Status:</h4>
                            <div class="flex flex-wrap gap-2">
                                <span class="px-3 py-1 bg-green-700 text-white text-xs font-medium rounded-full">TwoWheels: OK</span>
                                <span class="px-3 py-1 bg-green-700 text-white text-xs font-medium rounded-full">HydroBoy: OK</span>
                                <span class="px-3 py-1 bg-green-700 text-white text-xs font-medium rounded-full">HeavyD: OK</span>
                            </div>
                        </div>
                    </div>
                @endif

                @if($role->value === 'inkoper' || $role->value === 'admin')
                    <div class="bg-gray-800 rounded-lg shadow-xl border border-gray-700 overflow-hidden">
                        <div class="p-6">
                            <div class="mb-4 border-b border-blue-500 pb-2">
                                <h3 class="text-xl font-extrabold text-white">Voorraadbeheer</h3>
                            </div>
                            <p class="text-gray-400 mb-6">Beheer modules, prijzen en specificaties.</p>
                            <a href="{{ route('modules.index') }}" class="w-full inline-flex justify-center items-center bg-blue-600 hover:bg-blue-500 text-white font-semibold py-3 px-6 rounded-lg transition duration-150 shadow-lg">
                                Naar Module Overzicht &rarr;
                            </a>
                        </div>
                        <div class="px-6 pb-4 pt-4 border-t border-gray-700 bg-gray-900/50">
                            <a href="{{ route('modules.create') }}" class="text-white hover:text-blue-300 font-semibold text-sm">
                                + Nieuwe module registreren
                            </a>
                        </div>
                    </div>
                @endif

                @if($role->value === 'klant' || $role->value === 'admin')
                    <div class="bg-gray-800 rounded-lg shadow-xl border border-gray-700 overflow-hidden">
                        <div class="p-6">
                            <div class="mb-4 border-b border-green-500 pb-2">
                                <h3 class="text-xl font-extrabold text-white">Mijn Bestellingen</h3>
                            </div>
                            <p class="text-gray-400 mb-6">Volg de status van uw huidige orders en bekijk specificaties.</p>
                            <a href="{{ route('customer.dashboard') }}" class="w-full inline-flex justify-center items-center bg-green-600 hover:bg-green-500 text-white font-semibold py-3 px-6 rounded-lg transition duration-150 shadow-lg">
                                Bekijk mijn Voertuigen &rarr;
                            </a>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
