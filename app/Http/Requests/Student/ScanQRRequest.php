<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class ScanQRRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'session_id' => ['required', 'integer', 'exists:attendance_sessions,id'],
            'scanned_token' => ['required', 'string'],
        ];
    }
}