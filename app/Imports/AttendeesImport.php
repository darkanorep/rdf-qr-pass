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

//    public function model(array $row)
//    {
//        return new Attendee([
//            'group_id' => $this->group->where('name', $row['group'])->first()->id,
//            'first_name' => $row['firstname'],
//            'last_name' => $row['lastname'],
//            'suffix' => $row['suffix'],
//            'contact' => $row['contact'],
//            'company' => $row['company'],
//            'employee_id' => $row['employeeid'],
//            'position' => $row['position'],
//            'department' => $row['department'],
//            'unit' => $row['unit'],
//            'category' => $row['category'],
//            'building_id' => $this->building->where('name', $row['building'])->first()->id,
//        ]);
//    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            Validator::make($row->toArray(), $this->rules(), $this->customValidationMessages())->validated();
        }

        $rows->chunk(300)->each(function ($rows) {
            Attendee::insert($rows->map(function ($row) {
                return [
                    'group_id' => $this->group->where('name', $row['group'])->first()->id,
                    'first_name' => $row['firstname'],
                    'last_name' => $row['lastname'],
                    'suffix' => $row['suffix'],
                    'contact' => $row['contact'],
                    'company' => $row['company'],
                    'employee_id' => $row['employeeid'],
                    'position' => $row['position'],
                    'department' => $row['department'],
                    'unit' => $row['unit'],
                    'category' => $row['category'],
                    'building_id' => $this->building->where('name', $row['building'])->first()->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            })->toArray());
        });
    }

    public function rules(): array
    {
        return [
            '*.employeeid' => ['required', 'string', 'distinct', 'unique:attendees,employee_id'],
            '*.group' => ['required', 'string', 'exists:groups,name'],
            '*.building' => ['nullable', 'string', 'exists:buildings,name'],
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            '*.employeeid.unique' => ':input already exists.',
            '*.group.exists' => ':input does not exist.',
            '*.building.exists' => ':input does not exist',
        ];
    }
}
