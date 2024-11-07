<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
        $productId = $this->route('product'); // Get the product ID from the route

        return [
            'name' => 'required|string|max:100|unique:products,name,' . ($productId ?: 'NULL'), // Handle null case
            'description' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ];
    }
}
