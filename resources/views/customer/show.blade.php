<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $vehicle->name }}
            </h2>
            <a href="{{ route('customer.dashboard') }}" class="text-sm text-gray-500 hover:text-gray-700">&larr; Terug naar overzicht</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- 1. STATUS PROGRESS BAR (CSS Only) --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <h3 class="text-lg font-medium text-gray-900 mb-6">Status Voortgang</h3>

                {{-- Determine active step index for styling --}}
                @php
                    $steps = ['concept', 'in_wachtrij', 'ingepland', 'in_productie', 'gereed', 'geleverd'];
                    $currentStepIndex = array_search($vehicle->status->value, $steps);
                    $labels = ['Concept', 'Wachtrij', 'Ingepland', 'Productie', 'Gereed', 'Geleverd'];
                @endphp

                <div class="relative flex justify-between items-center w-full">
                    {{-- The Gray Background Line --}}
                    <div class="absolute top-1/2 left-0 w-full h-1 bg-gray-200 -z-0"></div>

                    {{-- The Colored Active Line --}}
                    <div class="absolute top-1/2 left-0 h-1 bg-indigo-600 -z-0 transition-all duration-500"
                         style="width: {{ ($currentStepIndex / (count($steps) - 1)) * 100 }}%;"></div>

                    {{-- The Steps --}}
                    @foreach($steps as $index => $step)
                        <div class="relative z-10 flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs
                                {{ $index <= $currentStepIndex ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-500' }}">
                                {{ $index + 1 }}
                            </div>
                            <span class="mt-2 text-xs font-medium {{ $index <= $currentStepIndex ? 'text-indigo-600' : 'text-gray-400' }}">
                                {{ $labels[$index] }}
                            </span>
                        </div>
                    @endforeach
                </div>

                {{-- Completion Date Box --}}
                @if($completionDate)
                    <div class="mt-8 bg-blue-50 border-l-4 border-blue-500 p-4">
                        <p class="text-blue-700">
                            <strong>📅 Verwachte Oplevering:</strong> Uw voertuig staat ingepland om klaar te zijn op
                            <span class="font-bold">{{ $completionDate }}</span>.
                        </p>
                    </div>
                @elseif($vehicle->status->value === 'concept' || $vehicle->status->value === 'in_wachtrij')
                    <div class="mt-8 bg-yellow-50 border-l-4 border-yellow-500 p-4">
                        <p class="text-yellow-700">
                            <strong>⏳ Nog niet ingepland:</strong> Uw voertuig wacht op goedkeuring van de planner.
                        </p>
                    </div>
                @endif
            </div>

            {{-- 2. MODULE OVERVIEW (Read-Only) --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <h3 class="text-lg font-medium text-gray-900 mb-6">Specificaties</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($modules as $module)
                        <div class="flex items-start border border-gray-200 rounded-lg p-4">
                            {{-- Module Image --}}
                            <div class="w-20 h-20 bg-gray-100 rounded flex-shrink-0 overflow-hidden mr-4">
                                @if($module->image_path)
                                    <img src="{{ asset('images/' . $module->image_path) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs">No Img</div>
                                @endif
                            </div>

                            {{-- Details --}}
                            <div>
                                <h4 class="font-bold text-gray-800">{{ $module->name }}</h4>
                                <p class="text-xs text-indigo-600 font-semibold mb-1">{{ $module->category->label() }}</p>

                                <ul class="text-xs text-gray-600 space-y-1">
                                    @foreach($module->specifications as $key => $value)
                                        @if(!is_array($value) && $key !== 'compatible_chassis')
                                            <li><span class="font-medium">{{ ucfirst($key) }}:</span> {{ $value }}</li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8 border-t pt-4 flex justify-end">
                    <div class="text-right">
                        <span class="text-gray-500">Totaalprijs</span>
                        <div class="text-2xl font-bold text-gray-900">€ {{ $vehicle->total_price }}</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
