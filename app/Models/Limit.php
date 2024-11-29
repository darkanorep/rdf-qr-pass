<?php

namespace App\Models;

use App\Filters\LimitFilters;
use Essa\APIToolKit\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Limit extends Model
{
    use HasFactory, SoftDeletes, Filterable;

    protected string $default_filters = LimitFilters::class;

    protected $fillable = [
        "group_id",
        "limit",
        "year",
    ];

    protected $hidden = [
        'created_at'
    ];

    public function group(){
        return $this->hasMany(Group::class, 'id', 'group_id');
    }
}
