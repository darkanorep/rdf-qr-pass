<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Crypt;
use Psy\Util\Str;

class AttendeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'contact' => $this->contact,
            'company' => $this->company,
            'employee_id' => $this->employee_id,
            'position' => $this->position,
            'department' => $this->department,
            'unit' => $this->unit,
            'subunit' => $this->subunit,
            'group' => $this->group->name ?? null,
            'category' => $this->category,
            'building' => $this->building ? [
                'id' => $this->building->id ?? null,
                'name' => $this->building->name ?? null,
                'color' => [
                    'name' => $this->building->color->name ?? null,
                    'hex' => $this->building->color->hex ?? null,
                ],
            ] : null,
            'qr_code' => $this->qr_code,
            'attendee_number' => $this->attendee_number,
        ];
    }
}
