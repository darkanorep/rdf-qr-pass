<?php

namespace App\Models;

use App\Filters\RoleFilters;
use Essa\APIToolKit\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, SoftDeletes, Filterable;

    protected string $default_filters = RoleFilters::class;

    protected $fillable = [
        'name',
    ];

    protected $hidden = [
        'created_at',
    ];
}
