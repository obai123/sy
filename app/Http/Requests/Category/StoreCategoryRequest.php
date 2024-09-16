<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; //TODO set false 
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'parent_category_id' => 'nullable|exists:categories,id',
            'title' => 'required|string|max:45',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Image validation
            'description' => 'nullable|string|max:300',
            'location' => 'nullable|string|max:45',
        ];
    }
}
