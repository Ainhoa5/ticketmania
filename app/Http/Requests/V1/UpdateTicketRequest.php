<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Consider more specific authorization based on user roles or permissions
    }

    /**
     * Get the validation rules that apply to the request.
     * The rules differ for PUT (all fields required) vs PATCH (only provided fields are validated).
     */
    public function rules(): array
    {
        $method = $this->method();
        if ($method == 'PUT') {
            return [
                'concert_id' => ['required', 'integer', 'exists:concerts,id'],
                'user_id' => ['required', 'integer', 'exists:users,id']
            ];
        } else { // Handling PATCH requests
            return [
                'concert_id' => ['sometimes', 'required', 'integer', 'exists:concerts,id'],
                'user_id' => ['sometimes', 'required', 'integer', 'exists:users,id']
            ];
        }
    }

    /**
     * Prepare the data for validation, ensuring only to merge non-null values.
     */
    protected function prepareForValidation()
    {
        $data = [];
        if ($this->has('concertId')) {
            $data['concert_id'] = $this->concertId;
        }
        if ($this->has('userId')) {
            $data['user_id'] = $this->userId;
        }

        $this->merge($data);
    }
}
