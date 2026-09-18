<?php

namespace App\Http\Requests\Development;

use Illuminate\Foundation\Http\FormRequest;

class StoreMediaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasRole('development');
    }

    public function rules(): array
    {
        return [
            'file'        => ['required', 'file', 'max:10240', 'mimes:jpg,jpeg,png,webp,pdf,doc,docx,xls,xlsx'],
            'caption'     => ['nullable', 'string', 'max:255'],
            'category'    => ['required', 'string', 'in:gallery,document,announcement,general'],
            'is_public'   => ['nullable', 'boolean'],
        ];
    }
}