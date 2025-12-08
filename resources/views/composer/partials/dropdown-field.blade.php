<div class="group mb-6">
    <div class="flex justify-between items-baseline mb-2">
        <label for="{{ $name }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 group-focus-within:text-indigo-600 dark:group-focus-within:text-indigo-400 transition-colors">
            {{ $title }}
        </label>

        @if($optional ?? false)
            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                Optioneel
            </span>
        @endif
    </div>

    <div class="relative">
        <select name="{{ $name }}" id="{{ $name }}"
                class="block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-3 pl-4 pr-10 appearance-none transition ease-in-out duration-150">

            <option value="" disabled {{ !old($name) ? 'selected' : '' }} class="text-gray-500">
                Selecteer een optie...
            </option>

            @if($optional ?? false)
                <option value="" {{ old($name) === "" ? 'selected' : '' }}>
                    🚫 Geen {{ strtolower($title) }}
                </option>
            @endif

            @foreach($items as $item)
                @php
                    // Formatting: "Name (€Price) • Time • Spec1, Spec 2"
                    $details = [];
                    $details[] = '€' . number_format($item->price, 0, ',', '.');
                    $details[] = ($item->required_time) . 'u';

                    if(isset($specs) && is_array($specs)) {
                        $specParts = [];
                        foreach($specs as $key => $label) {
                            if(isset($item->specifications[$key])) {
                                $specParts[] = $item->specifications[$key] . ($label ? ' ' . $label : '');
                            }
                        }
                        if(!empty($specParts)) {
                             $details[] = implode(', ', $specParts);
                        }
                    }
                    $meta = implode(' • ', $details);
                @endphp

                <option value="{{ $item->id }}" {{ old($name) == $item->id ? 'selected' : '' }}>
                    {{ $item->name }} ({{ $meta }})
                </option>
            @endforeach
        </select>

        {{-- Custom Chevron --}}
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 dark:text-gray-400">
            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M10 3a.75.75 0 01.55.24l3.25 3.5a.75.75 0 11-1.1 1.02L10 4.852 7.3 7.76a.75.75 0 01-1.1-1.02l3.25-3.5A.75.75 0 0110 3zm-3.76 9.2a.75.75 0 011.06.04l2.7 2.908 2.7-2.908a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0l-3.25-3.5a.75.75 0 01.04-1.06z" clip-rule="evenodd" />
            </svg>
        </div>
    </div>

    @error($name)
    <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center gap-1">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        {{ $message }}
    </p>
    @enderror
</div>
