<?php

namespace App\Rules;

use App\Models\Attendee;
use App\Models\Limit;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class GroupLimit implements ValidationRule
{

    private $group_id;

    public function __construct($group_id)
    {
        $this->group_id = $group_id;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $limit = Limit::where('group_id', $this->group_id)
            ->where('year', now()->year)
            ->first();

        if ($limit) {
            $attendees = Attendee::where('group_id', $this->group_id)
                ->whereYear('created_at', now()->year)
                ->count();

            if ($attendees >= $limit->limit) {
                $fail("We are sorry to inform you that we have reached the maximum capacity for the Year Starter Party.");
            }
        }
    }
}
