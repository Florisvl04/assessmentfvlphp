<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Welkom bij Future Factory, ') }} {{ Auth::user()->name }}!
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- GRID LAYOUT FOR ACTIONS --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- === MONTEUR VIEW === --}}
                @if(Auth::user()->role->value === 'monteur')
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-orange-500">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">🛠 Nieuw Project Starten</h3>
                        <p class="text-gray-600 mb-4">Stel een nieuw voertuig samen voor een klant.</p>
                        <a href="{{ route('composer.create') }}" class="inline-block bg-orange-600 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded">
                            Naar de Configurator &rarr;
                        </a>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">📋 Instructies</h3>
                        <p class="text-gray-600">Zorg dat je compatibiliteit checkt bij de wielen en het chassis.</p>
                    </div>
                @endif

                {{-- === PLANNER VIEW === --}}
                @if(Auth::user()->role->value === 'planner')
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-purple-500">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">📅 Planning Beheren</h3>
                        <p class="text-gray-600 mb-4">Bekijk het rooster en wijs robots toe aan orders.</p>
                        <a href="{{ route('planning.index') }}" class="inline-block bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                            Open Kalender &rarr;
                        </a>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">🤖 Robot Status</h3>
                        <div class="flex space-x-2">
                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded">TwoWheels: OK</span>
                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded">HydroBoy: OK</span>
                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded">HeavyD: OK</span>
                        </div>
                    </div>
                @endif

                {{-- === INKOPER VIEW === --}}
                @if(Auth::user()->role->value === 'inkoper')
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">📦 Voorraadbeheer</h3>
                        <p class="text-gray-600 mb-4">Beheer modules, prijzen en specificaties.</p>
                        <a href="{{ route('modules.index') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Naar Module Overzicht &rarr;
                        </a>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">➕ Snel Toevoegen</h3>
                        <a href="{{ route('modules.create') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                            Nieuwe module registreren &rarr;
                        </a>
                    </div>
                @endif

                {{-- === KLANT VIEW === --}}
                @if(Auth::user()->role->value === 'klant')
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">🚗 Mijn Bestellingen</h3>
                        <p class="text-gray-600 mb-4">Volg de status van uw huidige orders.</p>
                        <a href="{{ route('customer.dashboard') }}" class="inline-block bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Bekijk mijn Voertuigen &rarr;
                        </a>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">📞 Contact</h3>
                        <p class="text-gray-600 text-sm">Vragen over uw levering? Bel ons op 0900-FUTURE.</p>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
