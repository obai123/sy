<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFileRequest extends FormRequest
{
    public function authorize()
    {
        return true; //TODO set flase
    }

    public function rules()
    {
        return [
            'file' => 'required|file|max:10240', // Max file size 10MB
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:100',
        ];
    }
}
