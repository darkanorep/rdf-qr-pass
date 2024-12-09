<?php

namespace App\Imports;

use App\Models\Attendee;
use App\Models\Building;
use App\Models\Group;
use App\Rules\EmployeeIdImport;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Validation\Rule;

class AttendeesImport implements WithHeadingRow, ToCollection, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    private $group;
    private $building;
    public function __construct()
    {
        $this->group = Group::select('id', 'name')->get();
        $this->building = Building::select('id', 'name')->get();
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            Validator::make($row->toArray(), $this->rules(), $this->customValidationMessages())->validated();
        }

        $rows->chunk(300)->each(function ($rows) {
            Attendee::insert($rows->map(function ($row) {
                return [
                    'group_id' => $this->group->where('name', $row['team'])->first()->id,
                    'employee_id' => $row['idnumber'],
                    'first_name' => $row['firstname'],
                    'last_name' => $row['lastname'],
                    'middle_name' => $row['middlename'],
                    'suffix' => $row['suffix'],
                    'department' => $row['department'],
                    'unit' => $row['unit'],
//                    'subunit' => $row['subunit'],
                    'building_id' => $this->building->where('name', $row['building'])->first()->id ?? null,
                    'category' => $row['category'],


//                    'contact' => $row['contact'],
//                    'company' => $row['company'],

//                    'position' => $row['position'],

                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            })->toArray());
        });
    }

    public function rules(): array
    {
        return [
            '*.idnumber' => ['required', 'string', 'distinct', 'unique:attendees,employee_id'],
            '*.team' => ['required', 'string', 'exists:groups,name'],
            '*.building' => ['nullable', 'string', 'exists:buildings,name'],
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            '*.idnumber.unique' => ':input already exists.',
            '*.idnumber.distinct' => 'ID Number :input has a duplicate.',
            '*.idnumber.required' => 'ID Number is required.',
            '*.team.exists' => ':input does not exist.',
            '*.team.required' => 'Team field is required.',
            '*.building.exists' => ':input does not exist',
        ];
    }
}
