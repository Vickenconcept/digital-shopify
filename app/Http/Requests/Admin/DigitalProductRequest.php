<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class DigitalProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'is_free' => ['required', 'boolean'],
            'price' => ['required_if:is_free,0', 'nullable', 'numeric', 'min:0'],
            'category_id' => ['required', 'exists:categories,id'],
            'file_type' => ['required', 'in:audio,video,ebook'],
            'is_featured' => ['boolean'],
            'is_active' => ['boolean'],
            'published_at' => ['nullable', 'date'],
        ];

        if ($this->isMethod('POST')) {
            $rules['file'] = ['required', 'file', 'max:512000']; // 500MB max
            $rules['thumbnail'] = ['nullable', 'image', 'max:2048']; // 2MB max
            $rules['preview'] = ['nullable', 'file', 'max:10240']; // 10MB max
        } else {
            $rules['file'] = ['nullable', 'file', 'max:512000'];
            $rules['thumbnail'] = ['nullable', 'image', 'max:2048'];
            $rules['preview'] = ['nullable', 'file', 'max:10240'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'file.max' => 'The file may not be greater than 500MB.',
            'thumbnail.max' => 'The thumbnail may not be greater than 2MB.',
            'preview.max' => 'The preview file may not be greater than 10MB.',
        ];
    }
}