<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name' => 'sometimes|required',
            'description' => 'sometimes|required',
            'image_cover' => 'sometimes|image|max:2048',  // make sure to validate it's an image if you're uploading one
            'image_background' => 'sometimes|image|max:2048'
        ];
    }


    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        $data = [];
        if ($this->has('imageCover')) {
            $data['image_cover'] = $this->imageCover;
        }
        if ($this->has('imageBackground')) {
            $data['image_background'] = $this->imageBackground;
        }

        $this->merge($data);
    }

}
