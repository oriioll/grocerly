<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RecipePostRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'is_public' => 'required|boolean',
            'servings' => 'required|integer|max:50',
            'foods' => 'required|array|max:9000',
            'foods.*.food_id' => 'required|integer|exists:food,food_id',
            'foods.*.grams' => 'required|string|max:20',
        ];
    }
}
