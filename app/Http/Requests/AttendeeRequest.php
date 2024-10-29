<?php

namespace App\Http\Requests;

use App\Rules\GroupLimit;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AttendeeRequest extends FormRequest
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
            'group_id' => ['required', 'exists:groups,id', new GroupLimit($this->group_id)],
            'first_name' => ['required'],
            'last_name' => ['required'],
            'contact' => ['required'],
            'company' => ['required'],
            'employee_id' => [
                'required',
                Rule::unique('attendees', 'employee_id')->ignore($this->attendee),
            ],
            'position' => ['required'],
            'department' => ['required'],
            'unit' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'group_id.required' => 'Group type is required.',
            'group_id.exists' => 'Invalid group type.',
        ];
    }
}
