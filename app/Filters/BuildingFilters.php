<?php

namespace App\Filters;

use Essa\APIToolKit\Filters\QueryFilters;

class BuildingFilters extends BaseFilters
{
    protected array $allowedFilters = ['name'];

    protected array $columnSearch = ['name'];
}
