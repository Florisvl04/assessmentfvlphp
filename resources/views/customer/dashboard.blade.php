<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mijn Voertuigen') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if($vehicles->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center text-gray-500">
                    <p class="mb-4">U heeft nog geen voertuigen samengesteld.</p>
                    <a href="{{ route('composer.create') }}" class="text-indigo-600 hover:text-indigo-900 font-bold">
                        Start nu met samenstellen &rarr;
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($vehicles as $vehicle)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 hover:shadow-md transition">
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-4">
                                    <h3 class="text-lg font-bold text-gray-800">{{ $vehicle->name }}</h3>
                                    {{-- Status Badge Logic --}}
                                    @php
                                        $colors = match($vehicle->status->value) {
                                            'concept' => 'bg-gray-100 text-gray-800',
                                            'in_wachtrij' => 'bg-yellow-100 text-yellow-800',
                                            'ingepland' => 'bg-blue-100 text-blue-800',
                                            'in_productie' => 'bg-purple-100 text-purple-800',
                                            'gereed' => 'bg-green-100 text-green-800',
                                            'geleverd' => 'bg-green-800 text-white',
                                            default => 'bg-gray-100 text-gray-800',
                                        };
                                    @endphp
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $colors }}">
                                        {{ $vehicle->status->label() }}
                                    </span>
                                </div>

                                <div class="text-sm text-gray-600 mb-4">
                                    <p>Aangemaakt op: {{ $vehicle->created_at->format('d-m-Y') }}</p>
                                    <p>Modules: {{ $vehicle->modules->count() }} onderdelen</p>
                                </div>

                                <a href="{{ route('customer.show', $vehicle) }}" class="block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                    Bekijk Status & Details
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
