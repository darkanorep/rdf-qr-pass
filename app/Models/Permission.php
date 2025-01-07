<?php

namespace App\Models;

use App\Filters\PermissionFilters;
use Essa\APIToolKit\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

class Permission extends Model
{
    use HasFactory, softDeletes, Filterable, HasJsonRelationships;

    protected $fillable = ['name'];

    protected string $default_filters = PermissionFilters::class;

    protected $hidden = ['created_at'];

    public function users()
    {
        return $this->hasManyJson(User::class, 'permission_id');
    }
}
