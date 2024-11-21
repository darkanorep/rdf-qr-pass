<?php

namespace App\Filters;

use Essa\APIToolKit\Filters\QueryFilters;

class AttendeeFilters extends QueryFilters
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
}
