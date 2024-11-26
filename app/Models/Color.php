<?php

namespace App\Models;

use App\Filters\ColorFilters;
use Essa\APIToolKit\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Color extends Model
{
    use HasFactory, softDeletes, Filterable;

    protected string $default_filters = ColorFilters::class;

    protected $fillable = [
        'name'
    ];

    protected $hidden = [
        'created_at'
    ];
}
