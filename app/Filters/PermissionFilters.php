<?php

namespace App\Filters;

use Essa\APIToolKit\Filters\QueryFilters;

class PermissionFilters extends BaseFilters
{
    protected array $allowedFilters = ['name'];

    protected array $columnSearch = ['name'];
}
