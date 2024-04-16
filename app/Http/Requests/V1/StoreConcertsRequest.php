<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreConcertsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'event_id' => ['required', 'integer', 'exists:events,id'],
            'date' => ['required', 'date'],
            'location' => ['required', 'string', 'max:255'],
            'capacity_total' => ['required', 'integer', 'min:0'],
            'tickets_sold' => ['required', 'integer', 'min:0'],
            'price' => ['required', 'numeric', 'min:0']
        ];
    }

    /**
     * Prepare the data for validation, if necessary.
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'event_id' => $this->eventId,
            'capacity_total' => $this->capacityTotal,
            'tickets_sold' => $this->ticketsSold
        ]);
    }
}
