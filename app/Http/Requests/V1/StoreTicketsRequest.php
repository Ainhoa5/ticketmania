<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketsRequest extends FormRequest
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
            'concert_id' => ['required', 'integer', 'exists:concerts,id'],
            'user_id' => ['required', 'integer', 'exists:users,id']
        ];
    }



    /**
     * Prepare the data for validation, if necessary.
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'concert_id' => $this->concertId
        ]);
    }
}
