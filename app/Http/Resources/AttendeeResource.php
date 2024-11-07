<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Crypt;

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
            'last_name' => $this->last_name,
            'contact' => $this->contact,
            'company' => $this->company,
            'employee_id' => $this->employee_id,
            'position' => $this->position,
            'department' => $this->department,
            'unit' => $this->unit,
            'group' => $this->group->name,
            'qr_code' => Crypt::encrypt($this->id)
        ];
    }
}
