<?php

namespace App\Filters;

use Essa\APIToolKit\Filters\QueryFilters;

class LimitFilters extends BaseFilters
{
    protected array $allowedFilters = ['limit', 'year'];

    protected array $columnSearch = ['limit', 'year'];

    protected array $relationSearch = [
        'group' => ['name']
    ];
}
