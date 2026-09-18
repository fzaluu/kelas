<?php

namespace App\Http\Requests\Development;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user')?->id ?? $this->route('user');

        return [
            'username'  => ['required', 'string', 'max:255', Rule::unique('users', 'username')->ignore($userId)],
            'email'     => ['nullable', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'password'  => ['nullable', 'string', 'min:8'],
            'role_id'   => ['required', 'exists:roles,id'],
            'member_id' => ['nullable', 'exists:members,id', Rule::unique('users', 'member_id')->ignore($userId)],
            'status'    => ['required', 'in:ACTIVE,INACTIVE,SUSPENDED'],
        ];
    }
}