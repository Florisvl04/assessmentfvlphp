<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Productie Overzicht') }}
            </h2>
            <a href="{{ route('planning.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded text-sm">
                &larr; Terug naar Kalender
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Voertuig</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Opleverdatum</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($vehicles as $vehicle)
                        <tr class="{{ $vehicle->is_completed ? 'bg-green-50' : '' }}">

                            {{-- Name --}}
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900">{{ $vehicle->name }}</div>
                                <div class="text-xs text-gray-500">{{ $vehicle->user->name }}</div>
                            </td>

                            {{-- Status  --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($vehicle->is_completed)
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Voltooid
                                        </span>
                                @elseif($vehicle->is_fully_planned)
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            Ingepland
                                        </span>
                                @else
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Wachtrij
                                        </span>
                                @endif
                            </td>

                            {{-- Completion Date --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                {{ $vehicle->estimated_completion_date ?? '-' }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>++
