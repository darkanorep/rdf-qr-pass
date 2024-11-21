<?php

namespace App\Filters;

use Essa\APIToolKit\Filters\QueryFilters;

class GroupFilters extends QueryFilters
{
    protected array $allowedFilters = ['name'];

    protected array $columnSearch = ['name'];

    public function status($status)
    {
        return $this->builder->when($status == 1, function ($query) {
            return $query->whereNull('deleted_at');
        }, function ($query) {
            return $query->whereNotNull('deleted_at');
        });
    }

}
