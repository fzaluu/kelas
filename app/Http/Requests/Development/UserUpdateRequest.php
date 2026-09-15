<?php

namespace App\Http\Requests\Development;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user');

        return [
            'username' => ['required', 'string', 'max:50', 'unique:users,username,' . $userId],
            'name'     => ['nullable', 'string', 'max:100'],
            'email'    => ['nullable', 'email', 'max:100', 'unique:users,email,' . $userId],
            'password' => ['nullable', 'string', 'min:8'], // Opsional saat edit
            'role_id'  => ['required', 'exists:roles,id'],
        ];
    }
}