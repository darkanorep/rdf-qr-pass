<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'role_id' => ['required', 'integer', 'exists:roles,id'],
            'company' => ['required', 'string'],
            'employee_id' => ['required', 'string'],
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'department' => ['required', 'string'],
            'unit' => ['required', 'string'],
            'position' => ['required', 'string'],
            'username' => ['required',
                'string',
                Rule::unique('users', 'username')->ignore($this->user),
            ],
            'password' => ['required', 'string', 'confirmed'],
        ];
    }

    public function messages()
    {
        return [
            'role_id.required' => 'Role type is required.',
            'role_id.exists' => 'Invalid role type.',
        ];
    }
}
