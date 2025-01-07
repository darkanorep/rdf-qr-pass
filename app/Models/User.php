<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\RoleType;
use App\Filters\UserFilters;
use Essa\APIToolKit\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;
use Staudenmeir\EloquentJsonRelations\Relations\BelongsToJson;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, Filterable, HasJsonRelationships;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected string $default_filters = UserFilters::class;

    protected $fillable = [
        'role_id',
        'permission_id',
        'company',
        'employee_id',
        'first_name',
        'last_name',
        'department',
        'unit',
        'position',
        'username',
        'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'permission_id',
        'password',
        'remember_token',
        'created_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'permission_id' => 'json'
    ];

    public function role() : BelongsTo
    {
        return $this->belongsTo(Role::class)->withTrashed();
    }

    public function isAdmin(): bool
    {
        return $this->role->name == RoleType::ADMIN || $this->role->name == RoleType::HR;
    }

    public function permissions() : BelongsToJson
    {
        return $this->belongsToJson(Permission::class, 'permission_id')->withTrashed()->select('id', 'name');
    }
}
