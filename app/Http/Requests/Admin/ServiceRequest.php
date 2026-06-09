<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'icon'         => ['required', 'string', 'max:100'],
            'title'        => ['required', 'string', 'max:255'],
            'excerpt'      => ['nullable', 'string', 'max:500'],
            'description'  => ['nullable', 'string'],           // rich HTML from the builder
            'content_json' => ['nullable', 'string'],           // builder block model
            'sort_order'   => ['nullable', 'integer', 'min:0'],
            'is_active'    => ['nullable', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active'  => $this->boolean('is_active'),
            'sort_order' => $this->input('sort_order', 0),
        ]);
    }
}
