<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateConcertsRequest extends FormRequest
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
        $method = $this->method();

        if ($method == 'PUT') {
            return [
                'event_id' => ['required', 'integer', 'exists:events,id'],
                'date' => ['required', 'date'],
                'location' => ['required', 'string', 'max:255'],
                'capacity_total' => ['required', 'integer', 'min:0'],
                'tickets_sold' => ['required', 'integer', 'min:0'],
                'price' => ['required', 'numeric', 'min:0']
            ];
        } else { // This assumes PATCH request handling
            return [
                'event_id' => ['sometimes', 'required', 'integer', 'exists:events,id'],
                'date' => ['sometimes', 'required', 'date'],
                'location' => ['sometimes', 'required', 'string', 'max:255'],
                'capacity_total' => ['sometimes', 'required', 'integer', 'min:0'],
                'tickets_sold' => ['sometimes', 'required', 'integer', 'min:0'],
                'price' => ['sometimes', 'required', 'numeric', 'min:0']
            ];
        }
    }

    /**
     * Prepare the data for validation, ensuring only to merge non-null values.
     */
    protected function prepareForValidation()
    {
        $data = [];
        if ($this->has('eventId')) {
            $data['event_id'] = $this->eventId;
        }
        if ($this->has('capacityTotal')) {
            $data['capacity_total'] = $this->capacityTotal;
        }
        if ($this->has('ticketsSold')) {
            $data['tickets_sold'] = $this->ticketsSold;
        }

        $this->merge($data);
    }
}
