<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Voertuig Configurator') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <form action="{{ route('composer.store') }}" method="POST">
                @csrf

                {{-- Global Error Summary --}}
                @if ($errors->any())
                    <div class="mb-6 rounded-md bg-red-50 dark:bg-red-900/50 p-4 border border-red-200 dark:border-red-800">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800 dark:text-red-200">
                                    Er zijn problemen met je selectie
                                </h3>
                                <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                                    <ul role="list" class="list-disc pl-5 space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="px-6 py-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Project Naam
                    </label>
                    <input type="text"
                           name="name"
                           id="name"
                           value="{{ old('name', 'Mijn Ontwerp') }}"
                           class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-white dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-lg"
                           placeholder="Geef uw voertuig een naam...">
                </div>

                    <div class="p-6 space-y-2">
                        <div class="grid grid-cols-1 gap-6">

                            {{-- 1. CHASSIS --}}
                            @include('composer.partials.dropdown-field', [
                                'title' => '1. Klant',
                                'name' => 'customer_id',
                                'items' => $customers,
                            ])
                            {{-- 1. CHASSIS --}}
                            @include('composer.partials.dropdown-field', [
                                'title' => '1. Chassis',
                                'name' => 'chassis_id',
                                'items' => $chassisList,
                                'specs' => ['vehicle_type' => '', 'wheel_count' => 'wielen']
                            ])

                            {{-- 2. AANDRIJVING --}}
                            @include('composer.partials.dropdown-field', [
                                'title' => '2. Aandrijving',
                                'name' => 'drive_id',
                                'items' => $driveList,
                                'specs' => ['fuel_type' => '', 'horsepower' => 'PK']
                            ])

                            {{-- 3. WIELEN --}}
                            @include('composer.partials.dropdown-field', [
                                'title' => '3. Wielen',
                                'name' => 'wheels_id',
                                'items' => $wheelsList,
                                'specs' => ['diameter' => 'inch', 'tire_type' => '']
                            ])

                            {{-- 4. STUUR --}}
                            @include('composer.partials.dropdown-field', [
                                'title' => '4. Stuur',
                                'name' => 'steering_id',
                                'items' => $steeringList,
                                'specs' => ['shape' => 'vorm']
                            ])

                            {{-- 5. STOELEN --}}
                            @include('composer.partials.dropdown-field', [
                                'title' => '5. Stoelen',
                                'name' => 'seats_id',
                                'items' => $seatsList,
                                'optional' => true,
                                'specs' => ['material' => '', 'count' => 'stuks']
                            ])

                        </div>
                    </div>

                    {{-- Footer Action Area --}}
                    <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            * Compatibiliteit wordt gecontroleerd bij opslaan.
                        </div>

                        <button type="submit"
                                class="inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 transition-colors w-full sm:w-auto">
                            <span>Samenstellen & Berekenen</span>
                            <svg class="ml-2 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</x-app-layout>
