<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nieuwe Module Toevoegen</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form action="{{ route('modules.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- 1. General Info --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Naam</label>
                            <input type="text" name="name" class="w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Categorie</label>
                            <select name="category" class="w-full border-gray-300 rounded-md shadow-sm">
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->value }}">{{ $cat->label() }}</option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 mt-1">Selecteer de juiste categorie voor de filters hieronder.</p>
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Prijs (€)</label>
                            <input type="number" name="price" class="w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Montagetijd (blokken van 2u)</label>
                            <input type="number" name="required_time" value="1" class="w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                        <div class="col-span-2">
                            <label class="block font-medium text-sm text-gray-700">Afbeelding</label>
                            <input type="file" name="image" class="w-full">
                        </div>
                    </div>

                    <hr class="my-6">
                    <h3 class="font-bold text-lg mb-4">Specificaties per Categorie</h3>
                    <p class="mb-4 text-sm text-gray-600">Vul alleen de velden in die horen bij de gekozen categorie.</p>

                    {{-- 2. Chassis Specs --}}
                    <div class="bg-gray-50 p-4 rounded mb-4 border">
                        <h4 class="font-bold text-gray-700 mb-2">Alleen voor Chassis</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm">Type Voertuig (bijv. Personenauto)</label>
                                <input type="text" name="specs[vehicle_type]" class="w-full border-gray-300 rounded text-sm">
                            </div>
                            <div>
                                <label class="text-sm">Aantal Wielen</label>
                                <input type="number" name="specs[wheel_count]" class="w-full border-gray-300 rounded text-sm">
                            </div>
                        </div>
                    </div>

                    {{-- 3. Engine Specs --}}
                    <div class="bg-gray-50 p-4 rounded mb-4 border">
                        <h4 class="font-bold text-gray-700 mb-2">Alleen voor Aandrijving</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm">Brandstof (Waterstof/Elektrisch)</label>
                                <input type="text" name="specs[fuel_type]" class="w-full border-gray-300 rounded text-sm">
                            </div>
                            <div>
                                <label class="text-sm">Vermogen (PK)</label>
                                <input type="number" name="specs[horsepower]" class="w-full border-gray-300 rounded text-sm">
                            </div>
                        </div>
                    </div>

                    {{-- 4. Wheel Specs --}}
                    <div class="bg-gray-50 p-4 rounded mb-4 border">
                        <h4 class="font-bold text-gray-700 mb-2">Alleen voor Wielen</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm">Diameter (Inch)</label>
                                <input type="number" name="specs[diameter]" class="w-full border-gray-300 rounded text-sm">
                            </div>
                            <div>
                                <label class="text-sm">Type Band (Zomer/Winter)</label>
                                <input type="text" name="specs[tire_type]" class="w-full border-gray-300 rounded text-sm">
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end mt-6">
                        <button type="submit" class="bg-indigo-600 text-white font-bold py-2 px-6 rounded shadow hover:bg-indigo-700">
                            Module Opslaan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
