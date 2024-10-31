<?php

namespace App\Http\Services;

use App\Models\Attendee;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class ActionService
{
    public function __construct(Attendee $attendee) {
        $this->attendee = $attendee;
    }

    public function readQR($request) {
        $attendee = $this->attendee->find(Crypt::decrypt($request->qr_code));

        if ($attendee) {
            return response()->json([
                'message' => 'Attendee found.',
                'attendee' => $attendee
            ]);
        }

        return response()->json([
            'message' => 'Attendee not found.'
        ]);
    }
}
