<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePaymentsRequest extends FormRequest
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
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'ticket_id' => ['required', 'integer', 'exists:tickets,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'status' => ['required', Rule::in(['pending', 'completed', 'failed'])],
            'stripe_payment_id' => ['required', 'string', 'max:255']
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'user_id' => $this->userId,
            'ticket_id' => $this->ticketId,
            'stripe_payment_id' => $this->stripePaymentId
        ]);
    }
}
