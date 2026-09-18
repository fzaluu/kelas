<?php

namespace App\Http\Requests\Development;

use Illuminate\Foundation\Http\FormRequest;

class MemberStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'class_id'      => ['required', 'exists:classes,id'],
            'name'          => ['required', 'string', 'max:255'],
            'nis'           => ['nullable', 'string', 'max:20', 'unique:members,nis'],
            'nisn'          => ['nullable', 'string', 'max:20', 'unique:members,nisn'],
            'gender'        => ['required', 'in:L,P'],
            'member_status' => ['required', 'in:ACTIVE,INACTIVE,GRADUATED,TRANSFERRED'],
            'public_bio'    => ['nullable', 'string'],
            'public_status' => ['nullable', 'string', 'max:255'],
        ];
    }
}