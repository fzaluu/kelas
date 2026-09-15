<?php

namespace App\Http\Requests\Development;

use Illuminate\Foundation\Http\FormRequest;

class ClassMemberUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $memberId = $this->route('member');

        return [
            'nis'         => ['required', 'string', 'max:20', 'unique:class_members,nis,' . $memberId],
            'nisn'        => ['nullable', 'string', 'max:20', 'unique:class_members,nisn,' . $memberId],
            'full_name'   => ['required', 'string', 'max:100'],
            'gender'      => ['required', 'in:L,P'],
            'pob'         => ['nullable', 'string', 'max:50'],
            'dob'         => ['nullable', 'date'],
            'address'     => ['nullable', 'string'],
            'user_id'     => ['nullable', 'exists:users,id', 'unique:class_members,user_id,' . $memberId],
            'status'      => ['required', 'in:ACTIVE,GRADUATED,TRANSFERRED,DROPPED_OUT'],
        ];
    }
}