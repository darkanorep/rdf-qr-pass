<?php

namespace App\Filters;

use Essa\APIToolKit\Filters\QueryFilters;

class ColorFilters extends BaseFilters
{
    protected array $allowedFilters = ['name', 'hex'];

    protected array $columnSearch = ['name', 'hex'];
}
