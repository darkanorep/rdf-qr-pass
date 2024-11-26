<?php

namespace App\Filters;

use Essa\APIToolKit\Filters\QueryFilters;

class BaseFilters extends QueryFilters
{
    protected array $allowedFilters = [];

    protected array $columnSearch = [];

    public function status($status): \Illuminate\Database\Eloquent\Builder
    {
        return $status ? $this->builder->whereNull('deleted_at') : $this->builder->whereNotNull('deleted_at');
    }
}
