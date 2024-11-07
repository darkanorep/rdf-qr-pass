<?php

namespace App\Http\Requests;

use App\Rules\GroupLimit;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
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
            'company' => ['required_if:group_id,1'],
            'employee_id' => [
                'required_if:group_id,1',
                'nullable',
                Rule::unique('attendees', 'employee_id')->ignore($this->attendee),
            ],
            'position' => ['required_if:group_id,1'],
            'department' => ['required_if:group_id,1'],
            'unit' => ['required_if:group_id,1'],
            'is_attending' => ['nullable', 'boolean'],
            'is_additional' => ['nullable', 'boolean'],
            'rsvp' => ['required_if:is_additional,true'],
            'rsvp.first_name' => ['required_if:is_additional,true'],
            'rsvp.last_name' => ['required_if:is_additional,true'],
            'rsvp.company' => ['required_if:is_additional,true'],
        ];
    }

    public function messages()
    {
        return [
            'company.required_if' => 'Company is required.',
            'employee_id.required_if' => 'Employee ID is required.',
            'position.required_if' => 'Position is required.',
            'department.required_if' => 'Department is required.',
            'unit.required_if' => 'Unit is required.',
            'group_id.required' => 'Group type is required.',
            'group_id.exists' => 'Invalid group type.',
            'rsvp.first_name.required_if' => 'First name is required.',
            'rsvp.last_name.required_if' => 'Last name is required.',
            'rsvp.company.required_if' => 'Company is required.',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        $errors = $validator->errors()->all();
        $customError = 'We are sorry to inform you that we have reached the maximum capacity for the Year Starter Party.';

        if (in_array($customError, $errors)) {
            throw new HttpResponseException(response()->json(['message' => $customError], 422));
        }
    }

}
