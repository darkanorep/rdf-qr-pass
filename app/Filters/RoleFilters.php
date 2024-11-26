<?php

namespace App\Filters;

use Essa\APIToolKit\Filters\QueryFilters;

class RoleFilters extends BaseFilters
{
    protected array $allowedFilters = ['name'];

    protected array $columnSearch = ['name'];
}
