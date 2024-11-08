<?php

namespace App\Http\Services;

use App\Enums\GroupType;
use App\Models\Attendee;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ActionService
{
    private Attendee $attendee;

    public function __construct($attendee) {
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
}
