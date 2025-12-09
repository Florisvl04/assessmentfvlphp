<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductionRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'vehicle_id' => 'required|exists:vehicles,id',
            'date'       => 'required|date|after_or_equal:today',
            'start_slot' => 'required|integer|min:1|max:4',
        ];
    }

    public function messages(): array
    {
        return [
            'date.after_or_equal' => 'Je kunt niet in het verleden plannen.',
            'start_slot.max'      => 'Er zijn maar 4 tijdsloten per dag.',
        ];
    }
}
