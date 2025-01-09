<?php

namespace App\Imports;

use App\Models\Attendance;
use App\Models\Attendee;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class EligibleAttendees implements ToCollection, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function __construct()
    {
        $this->attendee = Attendee::select('id', 'employee_id')->get();
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            Validator::make($row->toArray(), $this->rules(), $this->customValidationMessages())->validated();
        }

        $rows->chunk(300)->each(function ($rows) {
            Attendance::insert($rows->map(function ($row) {
                return [
                    'attendee_id' => $this->attendee->where('employee_id', $row['idnumber'])->first()->id,
                    'is_present' => false,
                    'is_eligible' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            })->toArray());
        });
    }

    public function rules(): array
    {
        return [
            '*.idnumber' => ['required', 'string', 'distinct', 'exists:attendees,employee_id', 'unique:attendance,attendee_id'],
        ];
    }

    public function customValidationMessages(): array
    {
        return [
//            '*.idnumber.unique' => ':input already exists.',
            '*.idnumber.distinct' => 'ID Number :input has a duplicate.',
            '*.idnumber.required' => 'ID Number is required.',
            '*.idnumber.exists' => ':input does not exist in pre-registered list.',
        ];
    }
}
