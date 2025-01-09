<?php

namespace App\Imports;

use App\Models\Attendance;
use App\Models\Attendee;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class NonEligibleAttendees implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function __construct()
    {
        $this->attendee = Attendee::select('id', 'employee_id')->get();
        $this->attendance = Attendance::select('id', 'attendee_id', 'is_present', 'is_eligible')->get();
    }

    public function collection(Collection $rows)
    {
        $rows->chunk(300)->each(function ($rows){
            $rows->map(function ($row) {

                $attendee = $this->attendee->where('employee_id', $row['idnumber'])->first();
                $attendance = $this->attendance->where('attendee_id', $attendee->id)->first();

                if ($attendance) {
                    $attendance->is_eligible = false;
                    $attendance->save();
                }
            });
        });
    }
}
