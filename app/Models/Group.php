<?php

namespace App\Models;

use App\Filters\GroupFilters;
use Essa\APIToolKit\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use HasFactory, softDeletes, Filterable;

    protected string $default_filters = GroupFilters::class;

    protected $fillable = [
        'name'
    ];

    protected $hidden = [
        'created_at',
    ];
}
