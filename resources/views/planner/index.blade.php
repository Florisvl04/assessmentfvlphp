<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Productieplanning') }}
        </h2>
    </x-slot>

    {{-- SUCCESS/ERROR MESSAGES --}}
    @if($errors->any() || session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            @if($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 text-red-700">
                    <ul class="list-disc ml-5">@foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach</ul>
                </div>
            @endif
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 text-green-700">
                    {{ session('success') }}
                </div>
            @endif
        </div>
    @endif

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-6">

                {{-- LEFT SIDEBAR: TOOLS --}}
                <div class="w-full lg:w-1/4 space-y-6">

                    {{-- 1. SCHEDULER --}}
                    <div class="bg-white shadow rounded-lg p-4">
                        <h3 class="font-bold text-gray-700 border-b pb-2 mb-3">Inplannen</h3>
                        <form action="{{ route('planning.schedule') }}" method="POST">
                            @csrf
                            <div class="space-y-3">
                                <div>
                                    <label class="text-xs font-bold text-gray-500 uppercase">Voertuig</label>
                                    <select name="vehicle_id" class="w-full text-sm border-gray-300 rounded focus:ring-indigo-500">
                                        @forelse($vehicles as $vehicle)
                                            {{--
                                                $vehicle->total_required_time = Total Blocks (e.g., 3)
                                                $vehicle->total_required_time * 2 = Total Hours (e.g., 6)
                                            --}}
                                            <option value="{{ $vehicle->id }}">
                                                {{ $vehicle->name }}
                                                — ⏱ {{ $vehicle->total_required_time }} blokken
                                                ({{ $vehicle->total_required_time * 2 }} uur)
                                            </option>
                                        @empty
                                            <option disabled>Geen voertuigen in wachtrij</option>
                                        @endforelse
                                    </select>
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-gray-500 uppercase">Start Datum</label>
                                    <input type="date" name="date" min="{{ now()->format('Y-m-d') }}" value="{{ now()->format('Y-m-d') }}" class="w-full text-sm border-gray-300 rounded">
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-gray-500 uppercase">Start Blok</label>
                                    <select name="start_slot" class="w-full text-sm border-gray-300 rounded">
                                        <option value="1">08:00 (Blok 1)</option>
                                        <option value="2">10:00 (Blok 2)</option>
                                        <option value="3">12:30 (Blok 3)</option>
                                        <option value="4">14:30 (Blok 4)</option>
                                    </select>
                                </div>
                                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 rounded text-sm transition">
                                    Opslaan
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- 2. MAINTENANCE --}}
                    <div class="bg-white shadow rounded-lg p-4">
                        <h3 class="font-bold text-gray-700 border-b pb-2 mb-3">Onderhoud</h3>
                        <form action="{{ route('planning.maintenance') }}" method="POST">
                            @csrf
                            <div class="space-y-3">
                                <div>
                                    <label class="text-xs font-bold text-gray-500 uppercase">Robot</label>
                                    <select name="robot_id" class="w-full text-sm border-gray-300 rounded">
                                        @foreach($robots as $robot)
                                            <option value="{{ $robot->id }}">{{ $robot->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="grid grid-cols-2 gap-2">
                                    <input type="date" name="date" min="{{ now()->format('Y-m-d') }}" value="{{ now()->format('Y-m-d') }}" class="text-sm border-gray-300 rounded w-full">
                                    <select name="slot" class="text-sm border-gray-300 rounded w-full">
                                        <option value="1">Blok 1</option>
                                        <option value="2">Blok 2</option>
                                        <option value="3">Blok 3</option>
                                        <option value="4">Blok 4</option>
                                    </select>
                                </div>
                                <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-2 rounded text-sm transition">
                                    Blokkeren
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- RIGHT CONTENT: CALENDAR GRID --}}
                <div class="w-full lg:w-3/4">
                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                            <h3 class="font-bold text-gray-700">Rooster (Komende 5 Dagen)</h3>
                            <span class="text-xs text-gray-400">Automatische updates</span>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead>
                                <tr class="bg-gray-100 text-gray-600 uppercase text-xs leading-normal">
                                    <th class="py-3 px-4 text-left">Tijdslot</th>
                                    @foreach($robots as $r)
                                        <th class="py-3 px-4 text-center">{{ $r->name }}</th>
                                    @endforeach
                                </tr>
                                </thead>
                                <tbody class="text-gray-600 text-sm font-light">
                                @foreach($dates as $date)
                                    <tr class="bg-gray-200 font-bold text-gray-700">
                                        <td colspan="{{ $robots->count() + 1 }}" class="py-2 px-4 text-left">
                                            {{ $date->format('l d-m-Y') }}
                                        </td>
                                    </tr>
                                    @foreach($slots as $slot)
                                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                                            <td class="py-3 px-4 text-left font-medium">
                                                Blok {{ $slot }}
                                                <span class="text-gray-400 text-xs block">
                                                        {{ match($slot) { 1=>'08:00', 2=>'10:00', 3=>'12:00', 4=>'14:00'} }}
                                                    </span>
                                            </td>
                                            @foreach($robots as $robot)
                                                @php
                                                    $alloc = $allocations->first(fn($a) =>
                                                        $a->robot_id === $robot->id &&
                                                        $a->date->isSameDay($date) &&
                                                        $a->slot === $slot
                                                    );
                                                @endphp
                                                <td class="py-3 px-4 text-center">
                                                    @if($alloc)
                                                        <div class="inline-block px-3 py-1 rounded-full text-xs font-bold
                                                                {{ $alloc->type->value === 'onderhoud' ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }}">
                                                            {{ $alloc->type->value === 'onderhoud' ? 'Onderhoud' : $alloc->vehicle->name }}
                                                        </div>
                                                    @else
                                                        <span class="text-gray-300">-</span>
                                                    @endif
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
