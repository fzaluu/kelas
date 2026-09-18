<?php

namespace App\Http\Requests\Development;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MemberUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $memberId = $this->route('member')?->id ?? $this->route('member');

        return [
            'class_id'      => ['required', 'exists:classes,id'],
            'name'          => ['required', 'string', 'max:255'],
            'nis'           => ['nullable', 'string', 'max:20', Rule::unique('members', 'nis')->ignore($memberId)],
            'nisn'          => ['nullable', 'string', 'max:20', Rule::unique('members', 'nisn')->ignore($memberId)],
            'gender'        => ['required', 'in:L,P'],
            'member_status' => ['required', 'in:ACTIVE,INACTIVE,GRADUATED,TRANSFERRED'],
            'public_bio'    => ['nullable', 'string'],
            'public_status' => ['nullable', 'string', 'max:255'],
        ];
    }
}