<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LimitRequest extends FormRequest
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
            'group_id' => 'required|exists:groups,id',
            'limit' => 'required|numeric',
            'year' => [
                'required',
                Rule::unique('limits')->where(function ($query) {
                    return $query->where('group_id', $this->group_id);
                })->ignore($this->route('limit')),
            ],
        ];
    }

    public function messages()
    {
        return [
            'year.unique' => 'Year already exists for this group.',
        ];
    }
}
