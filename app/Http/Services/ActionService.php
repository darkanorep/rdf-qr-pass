<?php

namespace App\Http\Services;

use App\Enums\GroupType;
use App\Events\AttendeeEvent;
use App\Models\Attendee;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
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

//        if (GroupType::SUPPLIER == $this->attendee->group->name) {
//            $this->attendee->responses()->create([
//                'year' => Carbon::now()->year,
//                'is_additional' => $data['is_additional'] ?? false
//            ]);
//
//            if ($data['is_additional']) {
//                $this->attendee->supplier_guests()->create([
//                    'first_name' => $data['rsvp']['first_name'],
//                    'last_name' => $data['rsvp']['last_name'],
//                    'company' => $data['rsvp']['company'],
//                    'attendee_response_id' => $this->attendee->responses->first()->id
//                ]);
//            }
//        }
    }
    public function preRegisterChecker($request)
    {
        $employeeID = $request->input('employee_id');

        $attendee = $this->attendee->where('employee_id', $employeeID)
            ->with([
                'group:id,name',
                'building:id,name,color_id',
                'building.color:id,name,hex'
            ])
            ->select(
                'id',
                'employee_id',
                'first_name',
                'middle_name',
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
                'qr_code',
                'attendee_number'
            )
            ->first();

        return $attendee
            ? !$attendee->qr_code
                ? $attendee
                : response()->json([
                    'message' => 'Already registered.',
                    'qr_code' => $attendee->qr_code,
                    'attendee_number' => $attendee->attendee_number,
                    'employee_id' => $attendee->employee_id,
                    'category' => $attendee->category ?? null,
                    'building' => $attendee->building ? [
                        'id' => $attendee->building->id ?? null,
                        'name' => $attendee->building->name ?? null,
                        'color' => [
                            'name' => $attendee->building->color->name ?? null,
                            'hex' => $attendee->building->color->hex ?? null,
                        ],
                    ] : null,
                    'middle_name' => $attendee->middle_name,
                    'last_name' => $attendee->last_name
                ])
            : response()->json([], 404);
    }
    public function attendance($request) : \Illuminate\Http\JsonResponse  {
        $attendee = $this->attendee->where('qr_code', $request->input('qr_code'))
            ->whereNotNull('qr_code')
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
            'is_present' => true,
            'created_at' => Carbon::now()->timezone('Asia/Manila')->format('Y-m-d H:i:s')
        ]);

//        event(new AttendeeEvent($attendee));

        return response()->json([
            'message' => 'Please proceed to the venue.',
            'attendee' => $attendee->makeHidden('attendance')
        ], 200);
    }
    public function winner($request) : void {
        $attendee = $this->attendee->where('id', $request->attendee_id)
            ->withTrashed()
            ->first();
        $attendee->winner()->create([
            'category' => $request->category,
        ]);
        $attendee->attendance()->delete();
    }
}
