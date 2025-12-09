<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-white leading-tight">
                {{ __('Module Bewerken') }}: <span class="text-indigo-400">{{ $module->name }}</span>
            </h2>
            <a href="{{ route('modules.index') }}" class="text-gray-400 hover:text-white transition">
                &larr; Terug naar overzicht
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-900">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            {{-- Feedback Messages are handled in layout, but putting error summary here helps too --}}
            @if($errors->any())
                <div class="mb-6 bg-red-600 border border-red-500 text-white px-4 py-3 rounded relative shadow-lg">
                    <strong class="font-bold">Er zijn fouten gevonden:</strong>
                    <ul class="list-disc list-inside text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg border border-gray-700">
                <div class="p-8">
                    <form action="{{ route('modules.update', $module) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- 1. General Info --}}
                        <div class="mb-6 border-b border-gray-700 pb-4">
                            <h3 class="text-lg font-medium text-white mb-4">Algemene Informatie</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- Name --}}
                                <div>
                                    <label for="name" class="text-white block text-sm font-medium">Naam</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $module->name) }}"
                                           class="mt-1 block w-full bg-gray-900 border-gray-600 rounded-md shadow-sm text-black focus:ring-indigo-500 focus:border-indigo-500">
                                </div>

                                {{-- Category --}}
                                <div>
                                    <label for="category" class="block text-sm font-medium text-white">Categorie</label>
                                    <select name="category" id="category"
                                            class="mt-1 block w-full bg-gray-900 border-gray-600 rounded-md shadow-sm text-black focus:ring-indigo-500 focus:border-indigo-500">
                                        @foreach(\App\Enums\ModuleCategory::cases() as $category)
                                            <option value="{{ $category->value }}" {{ old('category', $module->category->value) == $category->value ? 'selected' : '' }}>
                                                {{ ucfirst($category->value) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Price --}}
                                <div>
                                    <label for="price" class="block text-sm font-medium text-white">Prijs (€)</label>
                                    <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $module->price) }}"
                                           class="mt-1 block w-full bg-gray-900 border-gray-600 rounded-md shadow-sm text-black focus:ring-indigo-500 focus:border-indigo-500">
                                </div>

                                {{-- Required Time --}}
                                <div>
                                    <label for="required_time" class="block text-sm font-medium text-white">Productietijd (blokken)</label>
                                    <input type="number" name="required_time" id="required_time" value="{{ old('required_time', $module->required_time) }}"
                                           class="mt-1 block w-full bg-gray-900 border-gray-600 rounded-md shadow-sm text-black focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                            </div>
                        </div>

                        {{-- 2. Specifications (JSON handling) --}}
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-white mb-2">Specificaties</h3>
                            <p class="text-sm text-gray-400 mb-4">Vul de specifieke eigenschappen in voor dit type module.</p>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                {{-- Spec: Vehicle Type (Relevant for Chassis) --}}
                                <div>
                                    <label for="spec_vehicle_type" class="block text-sm font-medium text-white">
                                        Type Voertuig (bijv. Fiets, Vrachtwagen)
                                    </label>
                                    <input type="text" name="specifications[vehicle_type]" id="spec_vehicle_type"
                                           value="{{ old('specifications.vehicle_type', $module->specifications['vehicle_type'] ?? '') }}"
                                           placeholder="Alleen voor Chassis"
                                           class="mt-1 block w-full bg-gray-900 border-gray-600 rounded-md shadow-sm text-white focus:ring-indigo-500 focus:border-indigo-500 placeholder-gray-600">
                                </div>

                                {{-- Spec: Fuel Type (Relevant for Powertrain) --}}
                                <div>
                                    <label for="spec_fuel_type" class="block text-sm font-medium text-white">
                                        Brandstof (bijv. Waterstof, Diesel)
                                    </label>
                                    <input type="text" name="specifications[fuel_type]" id="spec_fuel_type"
                                           value="{{ old('specifications.fuel_type', $module->specifications['fuel_type'] ?? '') }}"
                                           placeholder="Alleen voor Powertrain"
                                           class="mt-1 block w-full bg-gray-900 border-gray-600 rounded-md shadow-sm text-black focus:ring-indigo-500 focus:border-indigo-500 placeholder-gray-600">
                                </div>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center justify-end pt-4 border-t border-gray-700">
                            <a href="{{ route('modules.index') }}" class="text-gray-400 hover:text-white mr-4 transition">
                                Annuleren
                            </a>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-2 px-6 rounded-lg shadow-lg transition duration-150">
                                Opslaan
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
