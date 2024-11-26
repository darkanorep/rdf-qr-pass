<?php

namespace App\Http\Services;

use App\Enums\GroupType;
use App\Events\AttendeeEvent;
use App\Models\Attendee;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;

class ActionService
{
    private Attendee $attendee;
    public function __construct(Attendee $attendee) {
        $this->attendee = $attendee;
    }
    public function isAttending(array $data): void {

        $this->attendee->answers()->create([
            'year' => Carbon::now()->year,
            'is_attending' => $data['is_attending'] ?? false
        ]);

        if (GroupType::SUPPLIER == $this->attendee->group->name) {
            $this->attendee->responses()->create([
                'year' => Carbon::now()->year,
                'is_additional' => $data['is_additional'] ?? false
            ]);

            if ($data['is_additional']) {
                $this->attendee->supplier_guests()->create([
                    'first_name' => $data['rsvp']['first_name'],
                    'last_name' => $data['rsvp']['last_name'],
                    'company' => $data['rsvp']['company'],
                    'attendee_response_id' => $this->attendee->responses->first()->id
                ]);
            }
        }
    }
    public function preRegisterChecker($request)
    {
        $employeeID = $request->input('employee_id');

        $attendee = $this->attendee->where('employee_id', $employeeID)
            ->with([
                'group:id,name',
                'building:id,name'
            ])
            ->select(
                'id',
                'employee_id',
                'first_name',
                'last_name',
                'suffix',
                'contact',
                'company',
                'position',
                'department',
                'unit',
                'category',
                'group_id',
                'building_id',
                'category',
                'qr_code'
            )
            ->first();

        return $attendee
            ? !$attendee->qr_code
                ? $attendee
                : response()->json([
                    'message' => 'Already registered.',
                    'qr_code' => $attendee->qr_code
                ])
            : response()->json([], 404);
    }
    public function findQR($request) {
        $employeeID = $request->input('employee_id');

        $attendee = $this->attendee->where('employee_id', $employeeID)
            ->first()->qr_code;

        return $attendee ?: response()->json([], 404);
    }
    public function attendance($request) : \Illuminate\Http\JsonResponse  {
        $attendee = $this->attendee->where('qr_code', $request->input('qr_code'))
            ->with('attendance')
            ->first();

        if (!$attendee) {
            return response()->json([
                'message' => 'Attendee not found.'
            ], 404);
        }

        if ($attendee->attendance()->exists()) {
            return response()->json([
                'message' => 'Already at the venue.'
            ], 400);
        }

        $attendee->attendance()->create([
            'is_present' => true
        ]);

        event(new AttendeeEvent($attendee));

        return response()->json([
            'message' => 'Please proceed to the venue.'
        ], 200);
    }
}
