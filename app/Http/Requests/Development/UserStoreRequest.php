<?php

namespace App\Http\Requests\Development;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username'  => ['required', 'string', 'max:255', 'unique:users,username'],
            'email'     => ['nullable', 'email', 'max:255', 'unique:users,email'],
            'password'  => ['required', 'string', 'min:8'],
            'role_id'   => ['required', 'exists:roles,id'],
            'member_id' => ['nullable', 'exists:members,id', 'unique:users,member_id'],
            'status'    => ['required', 'in:ACTIVE,INACTIVE,SUSPENDED'],
        ];
    }
}