<?php

namespace App\Filters;

use Essa\APIToolKit\Filters\QueryFilters;
use Illuminate\Contracts\Database\Eloquent\Builder;

class AttendeeFilters extends BaseFilters
{
    protected array $allowedFilters = ['first_name', 'last_name', 'employee_id'];

    protected array $columnSearch = ['first_name', 'last_name', 'employee_id'];

    protected array $relationSearch = [
        'building' => ['name'],
    ];

    public function departments($departments) {
        return $this->builder->when(isset($departments), function ($query) use ($departments) {
            return $query->whereIn('department', explode(',', $departments));
        });
    }
    public function is_registered($is_registered): Builder
    {
        return $this->builder->when($is_registered, function ($query) {
            return $query->whereNotNull('qr_code');
        }, function ($query) {
            return $query->whereNull('qr_code')
                ->orWhereNotNull('qr_code');
        });
    }
}
